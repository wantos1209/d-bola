<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Historytransaction;
use App\Models\Period;
use App\Models\PeriodBet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Historytransaction::with(['company', 'game']);

        $dateFrom = $request->tgldari ?: Carbon::today()->toDateString();
        $dateTo   = $request->tgldari ?: Carbon::today()->toDateString();

        $query->whereDate('created_at', '>=', $dateFrom)->whereDate('created_at', '<=', $dateTo);

        if ($request->company) {
            $query->where('company_id', $request->company);
        }

        if ($request->username) {
            $query->where('username', 'like', '%' . $request->username . '%');
        }

        if ($request->periodno) {
            $query->where('periodno', 'like', '%' . $request->periodno . '%');
        }

        if ($request->transaction_code) {
            $query->where('transaction_code', 'like', '%' . $request->transaction_code . '%');
        }

        if ($request->statusgame) {
            $query->whereHas('game', function ($q) use ($request) {
                $q->where('status', 'like', '%' . $request->statusgame . '%');
            });
        }

        $data = $query->orderBy('created_at', 'desc')->paginate(20);

        $dataCompany = Company::orderBy('name', 'ASC')->get();

        return view('transaction.index', [
            'title' => 'History Transaction',
            'data' => $data,
            'dataCompany' => $dataCompany,
        ]);
    }


    public function indexperiod(Request $request)
    {
        $query = Period::query();
        
        $dateFrom = $request->datefrom ?: Carbon::today()->toDateString();
        $dateTo   = $request->dateto   ?: Carbon::today()->toDateString();

        $query->whereDate('created_at', '>=', $dateFrom)->whereDate('created_at', '<=', $dateTo);


        if ($request->periodno) {
            $query->where('periodno', $request->periodno);
        }

        if ($request->statusgame) {
            $query->where('statusgame', $request->statusgame);
        }

        $data = $query->orderBy('created_at', 'DESC')->paginate(20);
        
        return view('transaction.indexperiod', [
            'title' => 'History Transaction',
            'data' => $data,
            'request' => $request
        ]);
    }
}

