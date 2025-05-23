<?php

namespace App\Http\Controllers;

use App\Models\AnalyticDay;
use App\Models\AnalyticMonth;
use App\Models\AnalyticYear;
use App\Models\KeywordDetail;
use App\Models\Searchlogs;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Termwind\Components\Dd;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        return view('dashboard.index', [
            'totalKeyword' => 'Dashboard'
        ]);
    }

}
