<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Utility;
use App\Models\Employee;
use App\Models\AttendanceEmployee;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class AttenImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row[1]);
        $time = strtotime('2022-07-20 07:46:32');
       

        $datetimein = strtotime($row[1]);
        $date = date('y-m-d',$datetimein);
        $check_in = date('H:i:s',$datetimein);


        $datetimeout = strtotime($row[2]);
        $check_out = date('H:i:s',$datetimeout);


        // dd($date ,$check_in);

        $startTime = Utility::getValByName('company_start_time');
        $endTime   = Utility::getValByName('company_end_time');
        
        //late
        $totalLateSeconds = strtotime($check_in) - strtotime($startTime);
        $hours = floor($totalLateSeconds / 3600);
        $mins  = floor($totalLateSeconds / 60 % 60);
        $secs  = floor($totalLateSeconds % 60);
        $late  = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

       

        //early Leaving
        $totalEarlyLeavingSeconds = strtotime($endTime) - strtotime($check_out);
        $hours                    = floor($totalEarlyLeavingSeconds / 3600);
        $mins                     = floor($totalEarlyLeavingSeconds / 60 % 60);
        $secs                     = floor($totalEarlyLeavingSeconds % 60);
        $earlyLeaving             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

        //early Leaving
    
         //overtime
        $totalOvertimeSeconds = strtotime($check_out) - strtotime($endTime);
        $hours                = floor($totalOvertimeSeconds / 3600);
        $mins                 = floor($totalOvertimeSeconds / 60 % 60);
        $secs                 = floor($totalOvertimeSeconds % 60);
        $overtime             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
        

    


       
        if(strtotime($late) == null){
            $late = '00:00:00';
        }

        if(strtotime($earlyLeaving) == null){
            $earlyLeaving = '00:00:00';
            
        }

        if(strtotime($overtime)== null){
            $overtime = '00:00:00';
        }

         $idemployee = Employee::where('email', $row[0])->first();


         if($idemployee == ''){
            $idemployee = 0;
         }else{
            $idemployee = $idemployee->id;
         }
         $hey = Employee::where('email', $row[0])->get('id');
        // dd($idemployee->id);

        // $kita = $idemployee->id;
        // dd($kita);
        //  test::where('id' ,'>' ,0)->get('id');

        if($check_in == '00:00:00'){
            $status_presensi = 'Absent';
            $earlyLeaving = '00:00:00';
        }else{
            $status_presensi = 'Present';
        }
        
        return new AttendanceEmployee([  
            'employee_id' => $idemployee,
            'date' => $date,
            'clock_in' => $check_in,
            'clock_out' => $check_out,
            'late' => $late,
            'early_leaving' => $earlyLeaving,
            'overtime' => $overtime,
            'status' => $status_presensi,
            'created_by' => Auth::user()->id,
        
        ]);
    }
}
