<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        'id',
        'employee_id',
        'Leave_type_id',
        'applied_on',
        'start_date',
        'end_date',
        'total_leave_days',
        'leave_reason',
        'remark',
        'status',
        'created_by',
        'rejected_by',
    ];

    public function leaveType()
    {
        return $this->hasOne('App\Models\LeaveType', 'id', 'leave_type_id');
    }

    public function employees()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id');
    }

    public function hr()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'created_by');
    }

    public function rejectedBy()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'rejected_by');
    }

    public function approvedLeave()
    {
        return $this->hasMany(ApprovedLeave::class, 'leave_id', 'id');
    }
}
