<?php


use App\Models\Setting;
use App\Models\Currency;

if (! function_exists('is_tab_show')) {
    function is_tab_show($routeName)
    {
        return request()->routeIs($routeName) ? 'show' : '';
    }
}

if (! function_exists('is_route_active')) {
    function is_route_active($routeName)
    {
        return request()->routeIs($routeName) ? 'active' : '';
    }
}


if (!function_exists('trim_description')) {
    function trim_description($text, $wordLimit = 10)
    {
        $words = explode(' ', $text);
        if (count($words) > $wordLimit) {
            return implode(' ', array_slice($words, 0, $wordLimit)) . '...';
        }
        return $text;
    }
}


if (!function_exists('getProfileImage')) {
    function getProfileImage()
    {
        $user = auth()->user();
        $defaultImage = asset('assets/media/avatars/300-3.jpg'); // Default image path

        // Check if the user exists and has a profile image
        if ($user && $user->profile_image) {
            // Use the stored relative path
            $filename = $user->profile_image;

            // Build the full path to the image using the public path
            $path = public_path('storage/' . $filename); // Full path to the file

            // Check if the file exists
            if (file_exists($path)) {
                // Return the URL to access the image
                return asset('storage/' . $filename); // Return the image URL
            }
        }

        // Return the default image URL if no profile image is found
        return $defaultImage;
    }
}



if (!function_exists('getLogoImage')) {
    function getLogoImage()
    {
        // Retrieve the logo filename from the settings table
        $setting = Setting::find(1);
        
        if ($setting && !empty($setting->logo)) {
            $logoPath = public_path('app/assets/img/logo/' . $setting->logo);
            
            // Check if the logo image exists in the specified location
            if (file_exists($logoPath)) {
                return asset('app/assets/img/logo/' . $setting->logo); // Return the logo URL from the database
            }
        }

        // Return the default logo if not found in the database or does not exist
        return asset('assets/media/logos/default-dark.svg'); // Default logo path
    }
}


if (!function_exists('getFaviconImage')) {
    function getFaviconImage()
    {
        // Retrieve the logo filename from the settings table
        $setting = Setting::find(1);
        
        if ($setting && !empty($setting->favicon)) {
            $logoPath = public_path('app/assets/img/favicon/' . $setting->favicon);
            
            // Check if the logo image exists in the specified location
            if (file_exists($logoPath)) {
                return asset('app/assets/img/favicon/' . $setting->favicon); // Return the logo URL from the database
            }
        }
        return asset('assets/media/logos/favicon.ico');
    }
}


