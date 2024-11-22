<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use ZipArchive;

class SettingController extends Controller
{
    public function index(Request $request) {
        
        $app_info = Setting::find(1);

        return view('settings.settings-index', [
            'app_info' => $app_info,
        ]);
    }

    
    public function updateSettings(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'app_name' => 'nullable|string|max:255',
            'app_email' => 'nullable|email|max:255',
            'app_contact' => 'nullable|string|max:50',
            'meta_keyword' => 'nullable|string|max:255',
            'meta_descrip' => 'nullable|string|max:500',
            'favicon' => 'nullable|string|max:255', 
            'logo' => 'nullable|string|max:255',
            'mail_status' => 'nullable|in:enabled,disabled',
            'mail_mailer' => 'nullable|string|max:50',
            'mail_host' => 'nullable|string|max:255',
            'mail_port' => 'nullable|integer|min:1|max:65535',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|string|in:tls,ssl',
            'mail_address' => 'nullable|string|max:255',
            'mail_name' => 'nullable|string|max:255',
        ]);

        // Retrieve the application settings
        $setting = Setting::find(1);

        if (!$setting) {
            return response()->json([
                'success' => false,
                'message' => 'Settings not found.',
            ], 404);
        }

        $componentToReload = null;

        // Determine what to update based on provided inputs
        if ($request->hasAny(['mail_mailer', 'mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption', 'mail_address', 'mail_name', 'mail_status'])) {
            $setting->update($request->only([
                'mail_mailer', 'mail_host', 'mail_port', 'mail_username', 
                'mail_password', 'mail_encryption', 'mail_address', 
                'mail_name', 'mail_status',
            ]));
            $componentToReload = 'updateSMTPForm';

        } elseif ($request->hasAny(['app_name', 'app_email', 'app_contact'])) {
            $setting->update($request->only(['app_name', 'app_email', 'app_contact']));
            $componentToReload = 'updateAppInfoForm';

        } elseif ($request->hasAny(['meta_keyword', 'meta_descrip'])) {
            $setting->update($request->only(['meta_keyword', 'meta_descrip']));
            $componentToReload = 'updateMetaInfoForm';

        } else {
            return response()->json([
                'success' => false,
                'message' => __('Something Went Wrong'),
            ], 400);
        }

        // Return success response
        return response()->json([
            'success' => true,
            'message' => __('Settings Updated'),
            'reload' => true,
            'component' => $componentToReload,
            'redirect' => route('setting.index'),
        ], 200);
    }


    public function uploadLogo(Request $request) 
    {
        // Validate the request
        $request->validate([
            'logo_image' => 'required|image|mimes:jpeg,png,gif|max:5120', // Max size: 5MB
        ]);

        // Handle the uploaded file
        if ($request->hasFile('logo_image')) {
            // Get the uploaded file
            $file = $request->file('logo_image');
            $path = public_path('app/assets/img/logo'); // Adjust the path as needed
            // Create the directory if it doesn't exist
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            // Check if there's an existing logo
            $setting = Setting::find(1);
            $existingLogo = $setting->logo ?? null;

            // Delete the existing logo if it exists
            if ($existingLogo && file_exists($path . '/' . $existingLogo)) {
                unlink($path . '/' . $existingLogo);
            }

            // Generate a unique filename
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();

            // Move the uploaded file to the desired location
            $file->move($path, $filename);

            // Optionally, you can store the filename in the database if needed
            $setting->update(['logo' => $filename]);

            // Return a success response
            return response()->json([
                'success' => true,
                'message' => __('Logo Uploaded'), 
            ]);
        }

        // Return an error response if no file was uploaded
        return response()->json([
            'success' => false,
            'message' => __('Upload Failed'),  // Error message
        ], 400);
    }

    public function uploadFavicon(Request $request) 
    {
        try {
            // Handle the uploaded file
            if ($request->hasFile('favicon_image')) {
                // Get the uploaded file
                $file = $request->file('favicon_image');
                $path = public_path('app/assets/img/favicon'); // Adjust the path as needed
                
                // Create the directory if it doesn't exist
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
        
                // Check if there's an existing favicon
                $setting = Setting::find(1);
                $existingFavicon = $setting->favicon ?? null;
        
                // Delete the existing favicon if it exists
                if ($existingFavicon && file_exists($path . '/' . $existingFavicon)) {
                    unlink($path . '/' . $existingFavicon);
                }
        
                // Generate a unique filename
                $filename = 'favicon_' . time() . '.ico'; // Always use .ico extension
        
                // Move the uploaded file to the desired location
                $file->move($path, $filename);
        
                // Optionally, you can store the filename in the database if needed
                $setting->update(['favicon' => $filename]);
        
                // Return a success response
                return response()->json([
                    'success' => true,
                    'message' => __('Favicon Uploaded'), 
                ]);
            }
        
            // Return an error response if no file was uploaded
            return response()->json([
                'success' => false,
                'message' => __('Upload Failed'),  // Error message
            ], 400);
        } catch (\Exception $e) {
            \Log::error('Upload Favicon Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function backupOrRestore($action)
    {
        if ($action === 'backup') {
            try {
                Artisan::call('optimize:clear');
                Artisan::call('backup:db');
                return response()->json([
                    'success' => true,
                    'message' => __('Database And App Backed Up Successfully.'),
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->message(),
                ]);
            }
        }
    }


}
