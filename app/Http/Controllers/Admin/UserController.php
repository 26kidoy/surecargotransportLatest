<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20|unique:users',
            'password' => 'required|min:8|confirmed',
            'city' => 'nullable|string|max:255',
            'user_type' => 'nullable|string|in:customer,driver,poultry_owner,admin',
            'role' => 'nullable|string|max:255',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20|unique:users,mobile_number,' . $id,
            'city' => 'nullable|string|max:255',
            'user_type' => 'nullable|string|in:customer,driver,poultry_owner,admin',
            'role' => 'nullable|string|max:255',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Log the deletion attempt
            Log::info('Attempting to delete user', [
                'user_id' => $id,
                'admin_id' => auth()->id() ?? 'unknown',
                'user_name' => $user->full_name ?? $user->first_name . ' ' . $user->last_name
            ]);
            
            // Delete the user
            $user->delete();
            
            Log::info('User deleted successfully', ['user_id' => $id]);
            
            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
            
        } catch (QueryException $e) {
            // Check if it's a foreign key constraint violation
            if (str_contains($e->getMessage(), 'Integrity constraint violation') || 
                str_contains($e->getMessage(), 'foreign key') ||
                str_contains($e->getMessage(), 'SQLSTATE[23000]')) {
                
                Log::warning('User deletion failed due to foreign key constraint', [
                    'user_id' => $id,
                    'error' => $e->getMessage()
                ]);
                
                // Find the specific foreign key relationship
                $foreignKeyInfo = '';
                if (str_contains($e->getMessage(), 'bookings')) {
                    $foreignKeyInfo = ' This user has associated bookings.';
                } elseif (str_contains($e->getMessage(), 'payments')) {
                    $foreignKeyInfo = ' This user has associated payments.';
                } elseif (str_contains($e->getMessage(), 'messages')) {
                    $foreignKeyInfo = ' This user has associated messages.';
                } elseif (str_contains($e->getMessage(), 'notifications')) {
                    $foreignKeyInfo = ' This user has associated notifications.';
                } elseif (str_contains($e->getMessage(), 'damage_requests')) {
                    $foreignKeyInfo = ' This user has associated damage requests.';
                } elseif (str_contains($e->getMessage(), 'user_requests')) {
                    $foreignKeyInfo = ' This user has associated user requests.';
                } elseif (str_contains($e->getMessage(), 'batches')) {
                    $foreignKeyInfo = ' This user is associated with batches.';
                } elseif (str_contains($e->getMessage(), 'truck_locations')) {
                    $foreignKeyInfo = ' This user has associated truck locations.';
                } else {
                    $foreignKeyInfo = ' This user has associated records in the system.';
                }
                
                return redirect()->route('admin.users.index')
                    ->with('error', 'Cannot delete this user because they have associated records.' . $foreignKeyInfo . ' Please remove or reassign these records first.');
            }
            
            // Re-throw other query exceptions to be handled by the global handler
            throw $e;
            
        } catch (\Exception $e) {
            Log::error('User deletion failed', [
                'user_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('admin.users.index')
                ->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}