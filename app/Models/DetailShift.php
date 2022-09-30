<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailShift extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function employeeShift()
    {
        return $this->hasOne('App\Models\EmployeeShift', 'id', 'employee_shift_id');
    }
}
