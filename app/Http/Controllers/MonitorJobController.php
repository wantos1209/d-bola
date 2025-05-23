<?php

namespace App\Http\Controllers;

use App\Models\AnalyticQueue;
use App\Models\Company;
use App\Models\MonitorQueue;
use App\Models\User;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitorJobController extends Controller
{
    public function index(Request $request)
    {
        $query = MonitorQueue::query();

        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->error) {
            $query->where('error', 'like', '%' . $request->error . '%');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $MonitorQueue = $query->orderBy('created_at', 'DESC')->paginate(10);

        $AnnalyticQueue = AnalyticQueue::first();
        
        return view('monitorjob.index', [
            'title' => 'Queue Monitor',
            'MonitorQueue' => $MonitorQueue,
            'AnnalyticQueue' => $AnnalyticQueue
        ]);
    }


    public function indexfailjob(Request $request)
    {
        $jobs = DB::table('jobs')->orderByDesc('created_at')->get();
        return view('monitorjob.index', [
            'title' => 'Monitor Job',
            'data' => $jobs
        ]);
    }
}
