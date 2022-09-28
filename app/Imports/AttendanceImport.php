<?php

namespace App\Imports;

use App\Models\AttendanceEmployee;
use App\Models\Employee;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;


class AttendanceImport implements ToModel
{
   

    public function model(array $row)
    {

       
        // dd($idemployee->toArray()->id);
        $time = strtotime('2022-07-20 07:46:32');
        $newformat = date('H:i:s',$time);
        // echo $newformat;
         $idemployee = User::where('email', $row[1])->first();



        return new AttendanceEmployee(
            
            [
            'employee_id' => User::where('email', $row[1])->get('id'),
            'date' => 'test',
            'clock_in' => 'test',
            'clock_out' => 'test',
            'status' => $newformat,
            'created_by' => 'test',
        ]);
    }
}
