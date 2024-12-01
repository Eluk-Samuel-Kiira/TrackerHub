<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $departments = Department::where('isActive', 1)->get();
        $roles = Role::all()->pluck('name');
        
        View::share([
            'roles' => $roles,
            'departments' => $departments,
        ]);

        
        $app_mails = Setting::first();
        if ($app_mails) {
            $data =  [
                'transport' => $app_mails->mail_mailer,
                'host' => $app_mails->mail_host,
                'port' => $app_mails->mail_port,
                'username' => $app_mails->mail_username,
                'password' => $app_mails->mail_password,
                'encryption' => $app_mails->mail_encryption,
                'timeout' => null, 
                'local_domain' => env('MAIL_EHLO_DOMAIN'),
                'from' => [
                    'address' => $app_mails->mail_address,
                    'name' => $app_mails->mail_name,
                ],
            ];
            \Config::set('mail.mailers.smtp', $data);
            \Config::set('mail.default', $data['transport']);
            \Config::set('mail.from', $data['from']); 
            
            \Config::set('app.name', $app_mails->app_name); 
        } else {
            \Config::set('mail.mailers.smtp', []);
            \Config::set('mail.from', []);
        }
    }
}
