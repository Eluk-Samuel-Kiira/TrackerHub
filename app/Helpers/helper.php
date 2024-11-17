<?php

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

