<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralReportsController extends Controller
{
    public function index(Request $request) {
        
        return view('reports.report-index', [
            //
        ]);
    }
}
