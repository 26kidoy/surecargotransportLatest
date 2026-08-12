<?php
// app/Models/UserRequest.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'know_site',
        'message',
        'ip_address',
        'user_agent',
        'status',
        'approved_at',
        'rejected_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    // Scope for pending requests
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope for approved requests
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Check if request is pending
    public function isPending()
    {
        return $this->status === 'pending';
    }

    // Check if request is approved
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    // Check if request is rejected
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    // Approve the request
    public function approve()
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);
    }

    // Reject the request
    public function reject()
    {
        $this->update([
            'status' => 'rejected',
            'rejected_at' => now(),
        ]);
    }
}