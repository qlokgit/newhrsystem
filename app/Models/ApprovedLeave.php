<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovedLeave extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function leave()
    {
        return $this->hasOne(Leave::class, 'id', 'leave_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }
}
