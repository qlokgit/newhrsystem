<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommonEmailTemplate;


use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

class Utility extends Model
{
    public static function settings()
    {
        $data = DB::table('settings');

       if (\Auth::check()) {

            $data=$data->where('created_by','=',\Auth::user()->creatorId())->get();
            if(count($data)==0){
                $data =DB::table('settings')->where('created_by', '=', 1 )->get();
            }

        } else {

            $data->where('created_by', '=', 1);
            $data = $data->get();
        }


        $settings = [
            "site_currency" => "Dollars",
            "site_currency_symbol" => "$",
            "site_currency_symbol_position" => "pre",
            "site_date_format" => "M j, Y",
            "site_time_format" => "g:i A",
            "company_name" => "",
            "company_address" => "",
            "company_city" => "",
            "company_state" => "",
            "company_zipcode" => "",
            "company_country" => "",
            "company_telephone" => "",
            "company_email" => "",
            "company_email_from_name" => "",
            "employee_prefix" => "#EMP00",
            "footer_title" => "",
            "footer_notes" => "",
            "company_start_time" => "09:00",
            "company_end_time" => "18:00",
            'create_user' => '1',
            'employee_create' => '1',
            'payroll_create' => '1',
            'ticket_create' => '1',
            'award_create' => '1',
            'employee_transfer' => '1',
            'employee_resignation' => '1',
            'employee_trip' => '1',
            'employee_promotion' => '1',
            'employee_complaints' => '1',
            'employee_warning' => '1',
            'employee_termination' => '1',
            'leave_status' => '1',
            'contract'=>'1',
            "default_language" => "en",
            "display_landing_page" => "on",
            "ip_restrict" => "on",
            "title_text" => "",
            "footer_text" => "",
            "gdpr_cookie" => "",
            "cookie_text" => "",
            "metakeyword" => "",
            "metadesc" => "",
            "zoom_apikey" => "",
            'zoom_secret_key' => "",
            'disable_signup_button' => "",
            // "dark_mode"=>"off",
            // "theme_color"=>'theme-3',
            // "is_sidebar_transperent"=>'on',
            "theme_color" => "theme-3",
            "cust_theme_bg" => "on",
            "cust_darklayout" => "off",
            "SITE_RTL" => "off",
            "company_logo" => 'logo-dark.png',
            "company_logo_light"=> 'logo-light.png',
            "dark_logo" => "logo-dark.png",
            "light_logo" => "logo-light.png",
            "contract_prefix" => "#CON",

           
        ];

        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }

    // get date format
    public static function getDateFormated($date, $time = false)
    {
        if (!empty($date) && $date != '0000-00-00') {
            if ($time == true) {
                return date("d M Y H:i A", strtotime($date));
            } else {
                return date("d M Y", strtotime($date));
            }
        } else {
            return '';
        }
    }

    public static function languages()
    {
        $dir     = base_path() . '/resources/lang/';
        $glob    = glob($dir . "*", GLOB_ONLYDIR);
        $arrLang = array_map(
            function ($value) use ($dir) {
                return str_replace($dir, '', $value);
            },
            $glob
        );
        $arrLang = array_map(
            function ($value) use ($dir) {
                return preg_replace('/[0-9]+/', '', $value);
            },
            $arrLang
        );
        $arrLang = array_filter($arrLang);

        return $arrLang;
    }

    public static function getValByName($key)
    {
        $setting = Utility::settings();
        if (!isset($setting[$key]) || empty($setting[$key])) {
            $setting[$key] = '';
        }

        return $setting[$key];
    }

    public static function setEnvironmentValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str     = file_get_contents($envFile);
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $keyPosition       = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine           = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}='{$envValue}'\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }
            }
        }
        $str = substr($str, 0, -1);
        $str .= "\n";
        if (!file_put_contents($envFile, $str)) {
            return false;
        }

        return true;
    }

    public static $emailStatus = [
        'create_user' => 'User Create',
        'employee_create' => 'Employee Create',
        'payroll_create' => 'Payroll create',
        'ticket_create' => 'Ticket create',
        'award_create' => 'Award create',
        'employee_transfer' => 'Employee Transfer',
        'employee_resignation' => 'Employee Resignation',
        'employee_trip' => 'Employee Trip',
        'employee_promotion' => 'Employee Promotion',
        'employee_complaints' => 'Employee Complaints',
        'employee_warning' => 'Employee Warning',
        'employee_termination' => 'Employee Termination',
        'leave_status' => 'Leave Status',
        'contract'=>'Contract',
    ];

    public static function employeePayslipDetail($employeeId)
    {
        $earning['allowance']         = Allowance::where('employee_id', $employeeId)->get();
        $employess = Employee::find($employeeId);

        $totalAllowance = 0;

        foreach ($earning['allowance'] as $earn) {
            if ($earn->type == 'percentage') {
                $empall  = $earn->amount * $employess->salary / 100;
            } else {
                $empall = $earn->amount;
            }
            $totalAllowance += $empall;
        }

        $earning['commission']        = Commission::where('employee_id', $employeeId)->get();
        $employess = Employee::find($employeeId);
        $totalCommission = 0;

        foreach ($earning['commission'] as $earn) {
            if ($earn->type == 'percentage') {
                $empcom  = $earn->amount * $employess->salary / 100;
            } else {
                $empcom = $earn->amount;
            }
            $totalCommission += $empcom;
        }

        $earning['otherPayment']      = OtherPayment::where('employee_id', $employeeId)->get();
        $employess = Employee::find($employeeId);
        $totalotherpayment = 0;

        foreach ($earning['otherPayment'] as $earn) {
            if ($earn->type == 'percentage') {
                $empotherpay  = $earn->amount * $employess->salary / 100;
            } else {
                $empotherpay = $earn->amount;
            }
            $totalotherpayment += $empotherpay;
        }

        $earning['overTime']          = Overtime::select('id', 'title')->selectRaw('number_of_days * hours* rate as amount')->where('employee_id', $employeeId)->get();
        $earning['totalOverTime']     = Overtime::selectRaw('number_of_days * hours* rate as total')->where('employee_id', $employeeId)->get()->sum('total');

        $deduction['loan']           = Loan::where('employee_id', $employeeId)->get();
        $employess = Employee::find($employeeId);
        $totalloan = 0;

        foreach ($deduction['loan'] as $earn) {
            if ($earn->type == 'percentage') {
                $emploan  = $earn->amount * $employess->salary / 100;
            } else {
                $emploan = $earn->amount;
            }
            $totalloan += $emploan;
        }

        $deduction['deduction']      = SaturationDeduction::where('employee_id', $employeeId)->get();
        $employess = Employee::find($employeeId);
        $totaldeduction = 0;

        foreach ($deduction['deduction'] as $earn) {
            if ($earn->type == 'percentage') {
                $empdeduction  = $earn->amount * $employess->salary / 100;
            } else {
                $empdeduction = $earn->amount;
            }
            $totaldeduction += $empdeduction;
        }

        $payslip['earning']        = $earning;
        $payslip['totalEarning']   = $totalAllowance + $totalCommission + $totalotherpayment + $earning['totalOverTime'];

        $payslip['deduction']      = $deduction;
        $payslip['totalDeduction'] = $totalloan + $totaldeduction;

        return $payslip;
    }

    // public static function employeePayslipDetail($employeeId)
    // {
    //     $earning['allowance']         = Allowance::where('employee_id', $employeeId)->get();
    //     $earning['totalAllowance']    = Allowance::where('employee_id', $employeeId)->get()->sum('amount');
    //     $earning['commission']        = Commission::where('employee_id', $employeeId)->get();
    //     $earning['totalCommission']   = Commission::where('employee_id', $employeeId)->get()->sum('amount');
    //     $earning['otherPayment']      = OtherPayment::where('employee_id', $employeeId)->get();
    //     $earning['totalOtherPayment'] = OtherPayment::where('employee_id', $employeeId)->get()->sum('amount');
    //     $earning['overTime']          = Overtime::select('id', 'title')->selectRaw('number_of_days * hours* rate as amount')->where('employee_id', $employeeId)->get();
    //     $earning['totalOverTime']     = Overtime::selectRaw('number_of_days * hours* rate as total')->where('employee_id', $employeeId)->get()->sum('total');

    //     $deduction['loan']           = Loan::where('employee_id', $employeeId)->get();
    //     $deduction['totalLoan']      = Loan::where('employee_id', $employeeId)->get()->sum('amount');
    //     $deduction['deduction']      = SaturationDeduction::where('employee_id', $employeeId)->get();
    //     $deduction['totalDeduction'] = SaturationDeduction::where('employee_id', $employeeId)->get()->sum('amount');

    //     $payslip['earning']        = $earning;
    //     $payslip['totalEarning']   = $earning['totalAllowance'] + $earning['totalCommission'] + $earning['totalOtherPayment'] + $earning['totalOverTime'];
    //     $payslip['deduction']      = $deduction;
    //     $payslip['totalDeduction'] = $deduction['totalLoan'] + $deduction['totalDeduction'];

    //     return $payslip;
    // }


    public static function delete_directory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!self::delete_directory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }

    public static function addNewData()
    {
        \Artisan::call('cache:forget spatie.permission.cache');
        \Artisan::call('cache:clear');
        $usr            = \Auth::user();
        $arrPermissions = [
            "Manage Job Category",
            "Create Job Category",
            "Edit Job Category",
            "Delete Job Category",
            "Manage Job Stage",
            "Create Job Stage",
            "Edit Job Stage",
            "Delete Job Stage",
            "Manage Job",
            "Create Job",
            "Edit Job",
            "Delete Job",
            "Show Job",
            "Manage Job Application",
            "Create Job Application",
            "Edit Job Application",
            "Delete Job Application",
            "Show Job Application",
            "Move Job Application",
            "Add Job Application Note",
            "Delete Job Application Note",
            "Add Job Application Skill",
            "Manage Job OnBoard",
            "Manage Custom Question",
            "Create Custom Question",
            "Edit Custom Question",
            "Delete Custom Question",
            "Manage Interview Schedule",
            "Create Interview Schedule",
            "Edit Interview Schedule",
            "Delete Interview Schedule",
            "Manage Career",
            "Manage Competencies",
            "Create Competencies",
            "Edit Competencies",
            "Delete Competencies",
        ];
        foreach ($arrPermissions as $ap) {
            // check if permission is not created then create it.
            $permission = Permission::where('name', 'LIKE', $ap)->first();
            if (empty($permission)) {
                Permission::create(['name' => $ap]);
            }
        }
        $companyRole          = Role::where('name', 'LIKE', 'company')->where('created_by', '=', $usr->creatorId())->first();
        $companyPermissions   = $companyRole->getPermissionNames()->toArray();
        $companyNewPermission = [
            "Manage Job Category",
            "Create Job Category",
            "Edit Job Category",
            "Delete Job Category",
            "Manage Job Stage",
            "Create Job Stage",
            "Edit Job Stage",
            "Delete Job Stage",
            "Manage Job",
            "Create Job",
            "Edit Job",
            "Delete Job",
            "Show Job",
            "Manage Job Application",
            "Create Job Application",
            "Edit Job Application",
            "Delete Job Application",
            "Show Job Application",
            "Move Job Application",
            "Add Job Application Note",
            "Delete Job Application Note",
            "Add Job Application Skill",
            "Manage Job OnBoard",
            "Manage Custom Question",
            "Create Custom Question",
            "Edit Custom Question",
            "Delete Custom Question",
            "Manage Interview Schedule",
            "Create Interview Schedule",
            "Edit Interview Schedule",
            "Delete Interview Schedule",
            "Manage Career",
            "Manage Competencies",
            "Create Competencies",
            "Edit Competencies",
            "Delete Competencies",
        ];
        foreach ($companyNewPermission as $op) {
            // check if permission is not assign to owner then assign.
            if (!in_array($op, $companyPermissions)) {
                $permission = Permission::findByName($op);
                $companyRole->givePermissionTo($permission);
            }
        }
        $employeeRole          = Role::where('name', 'LIKE', 'employee')->first();
        $employeePermissions   = $employeeRole->getPermissionNames()->toArray();
        $employeeNewPermission = [
            'Manage Career',
        ];
        foreach ($employeeNewPermission as $op) {
            // check if permission is not assign to owner then assign.
            if (!in_array($op, $employeePermissions)) {
                $permission = Permission::findByName($op);
                $employeeRole->givePermissionTo($permission);
            }
        }
    }

    public static function jobStage($id)
    {
        $stages = [
            'Applied',
            'Phone Screen',
            'Interview',
            'Hired',
            'Rejected',
        ];
        foreach ($stages as $stage) {

            JobStage::create(
                [
                    'title' => $stage,
                    'created_by' => $id,
                ]
            );
        }
    }

    public static function sendEmailTemplate($emailTemplate, $mailTo, $obj)
    {


        // dd($emailTemplate, $mailTo, $obj);
        $usr = \Auth::user();

        //Remove Current Login user Email don't send mail to them
        unset($mailTo[$usr->id]);

        $mailTo = array_values($mailTo);

        if($usr->type != 'super admin')
        {
        // dd($usr->type);

            // find template is exist or not in our record
            $template = EmailTemplate::where('slug', $emailTemplate)->first();

// dd($template);
            if(isset($template) && !empty($template))
            {
                // check template is active or not by company
                $is_active = UserEmailTemplate::where('template_id', '=', $template->id)->where('user_id', '=', $usr->creatorId())->first();

                // dd($is_active);
                if($is_active->is_active == 1)
                {
                    $settings = self::settings();

                    // get email content language base
                    $content = EmailTemplateLang::where('parent_id', '=', $template->id)->where('lang', 'LIKE', $usr->lang)->first();

                    $content->from = $template->from;
                  
                    if(!empty($content->content))
                    {

                        $content->content = self::replaceVariable($content->content, $obj);
                        // send email
                        try
                        {
                            // dd($mailTo,$content, $settings);
                            Mail::to($mailTo)->send(new CommonEmailTemplate($content, $settings));
                        }
                        catch(\Exception $e)
                        {
                            // dd( $e);
                            $error = __('E-Mail has been not sent due to SMTP configuration');
                        }

                        if(isset($error))
                        {
                            $arReturn = [
                                'is_success' => false,
                                'error' => $error,
                            ];
                        }
                        else
                        {
                            $arReturn = [
                                'is_success' => true,
                                'error' => false,
                            ];
                        }
                    }
                    else
                    {
                        $arReturn = [
                            'is_success' => false,
                            'error' => __('Mail not send, email is empty'),
                        ];
                    }

                    return $arReturn;
                }
                else
                {
                    return [
                        'is_success' => true,
                        'error' => false,
                    ];
                }
            }
            else
            {
                return [
                    'is_success' => false,
                    'error' => __('Mail not send, email not found'),
                ];
            }
        }
    }
    
    public static function replaceVariable($content, $obj)
    {
        $arrVariable = [
            '{email}',
            '{password}',
            
            '{app_name}',
            '{app_url}',


            '{employee_name}',
            '{employee_email}',
            '{employee_password}',
            '{employee_branch}',
            '{employee_department}',
            '{employee_designation}',
            
            // '{payslip_email}',
            '{name}',
            '{salary_month}',
            '{url}',

            '{ticket_title}',
            '{ticket_name}',
            '{ticket_code}',
            '{ticket_description}',
            '{award_name}',

            '{transfer_name}',
            '{transfer_date}',
            '{transfer_department}',
            '{transfer_branch}',
            '{transfer_description}',
            
            '{assign_user}',
            '{resignation_date}',
            '{notice_date}',

            '{employee_trip_name}',
            '{purpose_of_visit}',
            '{start_date}',
            '{end_date}',
            '{place_of_visit}',
            '{trip_description}',

            '{employee_promotion_name}',
            '{promotion_designation}',
            '{promotion_title}',
            '{promotion_date}',
            
            '{employee_complaints_name}',
            
            '{employee_warning_name}',
            '{warning_subject}',
            '{warning_description}',

            '{employee_termination_name}',
            '{notice_date}',
            '{termination_date}',
            '{termination_type}',

            '{leave_status_name}',
            '{leave_status}',
            '{leave_reason}',
            '{leave_start_date}',
            '{leave_end_date}',
            '{total_leave_days}',

            '{contract_subject}',
            '{contract_employee}',
            '{contract_start_date}',
            '{contract_end_date}',

            // '{credit_description}',
            // '{support_title}',
            // '{assign_user}',
            // '{support_priority}',
            // '{support_end_date}',
            // '{support_description}',
            // '{contract_subject}',
            // '{contract_client}',
            // '{contract_value}',
            // '{contract_start_date}',
            // '{contract_end_date}',
            // '{contract_description}',
            // '{company_name}',
            // '{email}',
            // '{password}',
        ];
        $arrValue    = [
            'email' => '-',
            'password' => '-',
            
            'app_name' => '-',
            'app_url' => '-',

            'employee_name' => '-',
            'employee_email' => '-',
            'employee_password' => '-', 
            'employee_branch' => '-',
            'employee_department' => '-',
            'employee_designation' => '-',
            
            'name' => '-',
            'salary_month' => '-',
            'url' => '-',

            'ticket_title' => '-',
            'ticket_name' => '-',
            'ticket_code' => '-',
            'ticket_description' => '-',
            'award_name' => '-',

            'transfer_name' => '-',
            'transfer_date' => '-',
            'transfer_department' => '-',
            'transfer_branch' => '-',
            'transfer_description' => '-',

            'assign_user' => '-',
            'resignation_date' => '-',
            'notice_date' => '-',

            'employee_trip_name' => '-',
            'purpose_of_visit' => '-',
            'start_date' => '-',
            'end_date' => '-',
            'place_of_visit' => '-',
            'trip_description' => '-',

            'employee_promotion_name' => '-',
            'promotion_designation' => '-',
            'promotion_title' => '-',
            'promotion_date' => '-',

            'employee_complaints_name' => '-',

            'employee_warning_name' => '-',
            'warning_subject' => '-',
            'warning_description' => '-',

            'employee_termination_name' => '-',
            'notice_date' => '-',
            'termination_date' => '-',
            'termination_type' => '-',

            'leave_status_name' => '-',
            'leave_status' => '-',
            'leave_reason' => '-',
            'leave_start_date' => '-',
            'leave_end_date' => '-',
            'total_leave_days' => '-',

            'contract_subject' => '-',
            'contract_employee' => '-',
            'contract_start_date' => '-',
            'contract_end_date' => '-',

            // 'credit_description' => '-',
            // 'support_title' => '-',
            // 'assign_user' => '-',
            // 'support_priority' => '-',
            // 'support_end_date' => '-',
            // 'support_description' => '-',
            // 'contract_subject' => '-',
            // 'contract_client' => '-',
            // 'contract_value' => '-',
            // 'contract_start_date' => '-',
            // 'contract_end_date' => '-',
            // 'contract_description' => '-',
            // 'company_name' => '-',
            // 'email' => '-',
            // 'password' => '-',
        ];

        foreach($obj as $key => $val)
        {
            $arrValue[$key] = $val;
        }
        $settings = Utility::settings();
        $company_name = $settings['company_name'];
        //   dd(env('APP_NAME'));
        $arrValue['app_name']     = env('APP_NAME');
        $arrValue['company_name'] = self::settings()['company_name'];
        $arrValue['app_url']      = '<a href="' . env('APP_URL') . '" target="_blank">' . env('APP_URL') . '</a>';

        return str_replace($arrVariable, array_values($arrValue), $content);
    }
    public static function makeEmailLang($lang)
    {
        $template = EmailTemplate::all();
        foreach($template as $t)
        {
            $default_lang                 = EmailTemplateLang::where('parent_id', '=', $t->id)->where('lang', 'LIKE', 'en')->first();
            $emailTemplateLang            = new EmailTemplateLang();
            $emailTemplateLang->parent_id = $t->id;
            $emailTemplateLang->lang      = $lang;
            $emailTemplateLang->subject   = $default_lang->subject;
            $emailTemplateLang->content   = $default_lang->content;
            $emailTemplateLang->save();
        }
    }
    public static function getAdminPaymentSetting()
    {

        $data     = \DB::table('admin_payment_settings');

        $settings = [];
        if (\Auth::check()) {
            $user_id = 1;
            $data    = $data->where('created_by', '=', $user_id);
        }
        $data = $data->get();
        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }
        return $settings;
    }

   

    public static function error_res($msg = "", $args = array())
    {
        $msg       = $msg == "" ? "error" : $msg;
        $msg_id    = 'error.' . $msg;
        $converted = \Lang::get($msg_id, $args);
        $msg       = $msg_id == $converted ? $msg : $converted;
        $json      = array(
            'flag' => 0,
            'msg' => $msg,
        );

        return $json;
    }

    public static function success_res($msg = "", $args = array())
    {
        $msg       = $msg == "" ? "success" : $msg;
        $msg_id    = 'success.' . $msg;
        $converted = \Lang::get($msg_id, $args);
        $msg       = $msg_id == $converted ? $msg : $converted;
        $json      = array(
            'flag' => 1,
            'msg' => $msg,
        );

        return $json;
    }

    public static function getProgressColor($percentage)
    {
        $color = '';
        if ($percentage <= 20) {
            $color = 'danger';
        } elseif ($percentage > 20 && $percentage <= 40) {
            $color = 'warning';
        } elseif ($percentage > 40 && $percentage <= 60) {
            $color = 'info';
        } elseif ($percentage > 60 && $percentage <= 80) {
            $color = 'primary';
        } elseif ($percentage >= 80) {
            $color = 'success';
        }
        return $color;
    }

    public static function getselectedThemeColor()
    {
        $color = env('THEME_COLOR');
        if ($color == "" || $color == null) {
            $color = 'blue';
        }
        return $color;
    }

    public static function getAllThemeColors()
    {
        $colors = [
            'blue', 'denim', 'sapphire', 'olympic', 'violet', 'black', 'cyan', 'dark-blue-natural', 'gray-dark', 'light-blue', 'light-purple', 'magenta', 'orange-mute', 'pale-green', 'rich-magenta', 'rich-red', 'sky-gray'
        ];
        return $colors;
    }

    public static function send_slack_msg($msg)
    {

        $settings  = Utility::settings(\Auth::user()->creatorId());

        try {
            if (isset($settings['slack_webhook']) && !empty($settings['slack_webhook'])) {
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $settings['slack_webhook']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['text' => $msg]));

                $headers = array();
                $headers[] = 'Content-Type: application/json';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);
            }
        } catch (\Exception $e) {
        }
    }

    public static function send_telegram_msg($resp)
    {

        $settings  = Utility::settings(\Auth::user()->creatorId());

        try {
            $msg = $resp;
            // Set your Bot ID and Chat ID.
            $telegrambot    = $settings['telegram_accestoken'];
            $telegramchatid = $settings['telegram_chatid'];
            // Function call with your own text or variable
            $url     = 'https://api.telegram.org/bot' . $telegrambot . '/sendMessage';
            $data    = array(
                'chat_id' => $telegramchatid,
                'text' => $msg,
            );
            $options = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => "Content-Type:application/x-www-form-urlencoded\r\n",
                    'content' => http_build_query($data),
                ),
            );
            $context = stream_context_create($options);
            $result  = file_get_contents($url, false, $context);
            $url     = $url;
        } catch (\Exception $e) {
        }
    }

    public static function send_twilio_msg($to, $msg)
    {

        $settings  = Utility::settings(\Auth::user()->creatorId());

        try {
            $account_sid    = $settings['twilio_sid'];
            $auth_token = $settings['twilio_token'];
            $twilio_number = $settings['twilio_from'];
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($to, [
                'from' => $twilio_number,
                'body' => $msg
            ]);

            //dd('SMS Sent Successfully.');
        } catch (\Exception $e) {
        }
    }

    // public static function colorset()
    // {

    //     if(\Auth::user())
    //     {
    //         $user = \Auth::user()->id;
    //         $setting = DB::table('settings')->where('created_by',$user)->pluck('value','name')->toArray();

    //     }
    //     else{
    //         $setting = DB::table('settings')->pluck('value','name')->toArray();
    //     }
    //     return $setting;

    //     $is_dark_mode = $setting['dark_mode'];

    //     if($is_dark_mode == 'on'){
    //         return 'logo-light.png';
    //     }else{
    //         return 'logo-dark.png';
    //     }

    // }

    // public static function mode_layout()
    // {

    //     $data = DB::table('settings');
    //     $data = $data->where('created_by', '=', 1);
    //     $data     = $data->get();
    //     $settings = [
    //         "dark_mode" => "off",
    //         "is_sidebar_transperent" => "off",
    //         "theme_color" => 'theme-3'
    //     ];
    //     foreach($data as $row)
    //     {
    //         $settings[$row->name] = $row->value;
    //     }

    //     return $settings;
    // }

    public static function get_superadmin_logo(){

        $is_dark_mode = DB::table('settings')->where('created_by', '1')->pluck('value','name')->toArray();

        if(!empty($is_dark_mode['dark_mode'])){
            $is_dark_modes = $is_dark_mode['dark_mode'];

            if($is_dark_modes == 'on'){
                return 'logo-light.png';
            }else{
                return 'logo-dark.png';
            }
        }
        else{
            return 'logo-dark.png';
        }
    }

    public static function get_company_logo(){
       
        $is_dark_mode = DB::table('settings')->where('created_by', Auth::user()->id)->pluck('value','name')->toArray();  

        $is_dark_modes = !empty($is_dark_mode['dark_mode']) ? $is_dark_mode['dark_mode'] : 'off';
            if($is_dark_modes == 'on'){
                return Utility::getValByName('company_logo_light');
            }else{
                return Utility::getValByName('company_logo');
            }
        
        
    }

//  public static function getLayoutsSetting()
//     {
//         // $data = DB::table('settings');

//         // if(\Auth::check()){

//         //      $data =\DB::table('settings')->where('created_by', '=', \Auth::user()->id )->get();

//         //      if(count($data)==0){
//         //         $data =\DB::table('settings')->where('created_by', '=', 1 )->get();
//         //     }
//         // }else{
//         //     $data = $data->where('created_by', '=', 1);

//         // }

        
//         // $data     = $data->get();
//         // $settings = [
//         //     "cust_theme_bg"=>"on",
//         //     "cust_darklayout"=>"off",
//         //     "color"=>"theme-3",
//         // ];

//         // foreach($data as $row)
//         // {
//         //     $settings[$row->name] = $row->value;
//         // }

//         // return $settings;

//         $data = DB::table('settings');

//         if (\Auth::check()) {
 
//              $data=$data->where('created_by','=',\Auth::user()->creatorId())->get();
//              if(count($data)==0){
//                  $data =DB::table('settings')->where('created_by', '=', 1 )->get();
//              }
 
//          } else {
 
//              $data->where('created_by', '=', 1);
//              $data = $data->get();
//              $settings = [
//                      "is_sidebar_transperent"=>"on",
//                     "dark_mode"=>"off",
//                     "color"=>"theme-3",
//                  ];
//     }

//     }



        public static function colorset(){
            if(\Auth::user())
            {
                if(\Auth::user()->type == 'super admin')
                {
                    $user = \Auth::user();

                    $setting = DB::table('settings')->where('created_by',$user->id)->pluck('value','name')->toArray();
                }
                else
                {
                    $setting = DB::table('settings')->where('created_by', \Auth::user()->creatorId())->pluck('value','name')->toArray();
                }
            }
            else
            {
                $user = User::where('type','super admin')->first();
                $setting = DB::table('settings')->where('created_by',$user->id)->pluck('value','name')->toArray();
            }
            if(!isset($setting['color']))
            {
                $setting = Utility::settings();
            }
            return $setting;
        }

        public static function GetLogo()
        {
            $setting = Utility::colorset();
            //  dd($setting);
            if(\Auth::user() && \Auth::user()->type != 'super admin')
            {
                   
                if(Utility::getValByName('cust_darklayout') == 'on')
                {
                
                    return Utility::getValByName('company_logo_light');
                }
                else
                {
                    return Utility::getValByName('company_logo');
                }
            }
            else
            {      
                                    
                if(Utility::getValByName('cust_darklayout') == 'on')
                {
                    
                    return Utility::getValByName('light_logo');
                }
                else
                {
                    return Utility::getValByName('dark_logo');
                }
            }
        }  


        public static function GetLogolanding()
        {
            $setting = Utility::colorset();
            //  dd($setting);
            if(\Auth::user() && \Auth::user()->type != 'super admin')
            {
                   
                if(Utility::getValByName('cust_darklayout') == 'on')
                {
                
                    return Utility::getValByName('company_logo_light');
                }
                else
                {
                    return Utility::getValByName('company_logo');
                }
            }
            else
            {      
                                    
                
               
                    return Utility::getValByName('light_logo');
            }
        }



}