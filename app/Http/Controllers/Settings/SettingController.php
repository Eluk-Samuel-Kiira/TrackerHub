<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index(Request $request) {
        
        $app_info = Setting::find(1);

        return view('settings.settings-index', [
            'app_info' => $app_info,
        ]);
    }

}
