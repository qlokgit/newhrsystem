<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function notification($employeeId, $title, $description, $type, $url)
    {
        return Notification::create([
            'employee_id' => $employeeId,
            'title' => $title,
            'description' => $description,
            'type' => $type,
            'url' => $url
        ]);
    }
}
