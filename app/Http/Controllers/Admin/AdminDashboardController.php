<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\Truck;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login.form')->with('error', 'Please login as admin first.');
        }

        $admin = Auth::guard('admin')->user();
        $cacheDuration = 5; // minutes

        // Existing stats
        $stats = Cache::remember('admin_stats', $cacheDuration, function () {
            try {
                return [
                    'total_admins' => Admin::count(),
                    'active_admins' => Admin::where('is_active', true)->count(),
                ];
            } catch (\Exception $e) {
                Log::error('Failed to fetch admin stats: ' . $e->getMessage());
                return ['total_admins' => 0, 'active_admins' => 0];
            }
        });

        $totalUsers = Cache::remember('total_users_count', $cacheDuration, function () {
            try {
                return User::count();
            } catch (\Exception $e) {
                Log::error('Failed to fetch users count: ' . $e->getMessage());
                return 0;
            }
        });

        $totalTrucks = Cache::remember('total_trucks_count', $cacheDuration, function () {
            try {
                return class_exists(Truck::class) ? Truck::count() : 0;
            } catch (\Exception $e) {
                Log::error('Failed to fetch trucks count: ' . $e->getMessage());
                return 0;
            }
        });

        $totalBookings = Cache::remember('total_bookings_count', $cacheDuration, function () {
            try {
                return class_exists(Booking::class) ? Booking::count() : 0;
            } catch (\Exception $e) {
                Log::error('Failed to fetch bookings count: ' . $e->getMessage());
                return 0;
            }
        });

        // NEW: Approved payments chart data (last 7 days, daily amounts)
        $approvedPaymentsChart = $this->getApprovedPaymentsDaily();

        return view('admin.admin_dashboard', compact(
            'admin', 'stats', 'totalUsers', 'totalTrucks', 'totalBookings', 'approvedPaymentsChart'
        ));
    }

    /**
     * Get daily approved payment amounts for the last 7 days.
     * Uses payment_date if available, otherwise falls back to created_at.
     * Returns an array with 'dates' and 'daily_amounts'.
     */
    private function getApprovedPaymentsDaily()
    {
        $endDate = Carbon::today();
        $startDate = Carbon::today()->subDays(6);

        // Use COALESCE to fallback to created_at when payment_date is null
        $dailySums = Payment::where('status', 'approve')
            ->whereBetween(
                DB::raw('COALESCE(payment_date, created_at)'),
                [$startDate->startOfDay(), $endDate->endOfDay()]
            )
            ->select(
                DB::raw('DATE(COALESCE(payment_date, created_at)) as date'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date');

        $dates = [];
        $dailyAmounts = [];

        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $dateStr = $date->toDateString();
            $dates[] = $date->format('D, M j'); // matches previous format
            $dailyAmounts[] = $dailySums[$dateStr]->total ?? 0;
        }

        // Optional: log for debugging (remove in production)
        Log::info('Approved payments chart data', ['dates' => $dates, 'amounts' => $dailyAmounts]);

        return [
            'dates' => $dates,
            'daily_amounts' => $dailyAmounts,
        ];
    }
}
