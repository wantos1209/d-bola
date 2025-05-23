<?php

namespace App\Http\Controllers;

use App\Exports\DailyWinloseExport;
use App\Exports\MonthlyWinloseExport;
use App\Exports\YearlyWinloseExport;
use App\Models\Company;
use App\Models\ReportDailyWinlose;
use App\Models\ReportMonthlyWinlose;
use App\Models\ReportYearlyWinlose;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reportDailywinlose = $this->getDataReportDaily($request);
        $dataCompany = Company::orderBy('name', 'ASC')->get();

        return view('report.index', [
            'title' => 'Report Rekap Winlose',
            'data' => $reportDailywinlose,
            'dataCompany' => $dataCompany
        ]);
    }

    private function getDataReportDaily($request)
    {
        $query = ReportDailyWinlose::with(['company', 'game']);

        $dateFrom = $request->tgldari ?: Carbon::today()->toDateString();
        $dateTo   = $request->tglsampai ?: Carbon::today()->toDateString();

        $query->whereDate('created_at', '>=', $dateFrom)
            ->whereDate('created_at', '<=', $dateTo);

        if ($request->company) {
            $query->where('company_id', $request->company);
        }

        if ($request->username) {
            $query->where('username', 'like', '%' . $request->username . '%');
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function indexmonthly(Request $request)
    {
        $month = [
            1 => 'JAN',
            2 => 'FEB',
            3 => 'MAR',
            4 => 'APR',
            5 => 'MEY',
            6 => 'JUN',
            7 => 'JUL',
            8 => 'AUG',
            9 => 'SEP',
            10 => 'OCT',
            11 => 'NOB',
            12 => 'DEC',
        ];

        $year = range(2025, date('Y') + 1);
        $reportDailywinlose = $this->getDataMonthly($request);
        $dataCompany = Company::orderBy('name', 'ASC')->get();

        return view('report.indexmonth',[
            'title' => 'Report Rekap Winlose',
            'data' => $reportDailywinlose,
            'dataMonth' => $month,
            'dataYear' => $year,
            'dataCompany' => $dataCompany
        ]);
    }

    private function getDataMonthly($request)
    {
        
        $reportQuery = ReportMonthlyWinlose::with(['company', 'game']);
        
        if ($request->company) {
            $reportQuery->where('company_id', $request->company);
        }
       
        if ($request->username) {
            $reportQuery->where('username', 'like', '%' . $request->username . '%');
        }
        
        if ($request->month && $request->month != 'all' && $request->month != 'undefined') {
            $reportQuery->where('month', $request->month);
        }

        if ($request->year && $request->month != 'undefined') {
            $reportQuery->where('year', $request->year);
        }

        $reportDailywinlose = $reportQuery->get();

        return $reportDailywinlose;
    }
    
    public function indexyearly(Request $request)
    {
        $year = range(2025, date('Y') + 1);

        $reportQuery = ReportYearlyWinlose::with(['company', 'game']);

        if ($request->company) {
            $reportQuery->where('company_id', $request->company);
        }

        if ($request->username) {
            $reportQuery->where('username', 'like', '%' . $request->username . '%');
        }


        if ($request->year) {
            $reportQuery->where('year', $request->year);
        }

        $reportDailywinlose = $reportQuery->get();
        $dataCompany = Company::orderBy('name', 'ASC')->get();

        return view('report.indexyear',[
            'title' => 'Report Rekap Winlose',
            'data' => $reportDailywinlose,
            'dataYear' => $year,
            'dataCompany' => $dataCompany
        ]);
    }

    public function exportReportDaily(Request $request) 
    {
        $reportDailywinlose = $this->getDataReportDaily($request);

        $data = $reportDailywinlose->map(function ($d) {
            return [
                $d->company->name ?? '-',
                $d->username,
                $d->created_at->format('d-m-Y H:i:s'),
                number_format($d->turnover, 0, ',', '.'),
                number_format($d->bet_count, 0, ',', '.'),
                number_format($d->member_win, 0, ',', '.'),
                number_format($d->member_win * -1, 0, ',', '.'),
            ];
        })->toArray();

        $tgldari = $request->tgldari ? Carbon::parse($request->tgldari)->format('d-m-Y') : Carbon::today()->format('d-m-Y');
        $tglsampai = $request->tglsampai ? Carbon::parse($request->tglsampai)->format('d-m-Y') : Carbon::today()->format('d-m-Y');

        return Excel::download(new DailyWinloseExport($data), 'report-daily-winlose-' . $tgldari . ' to ' . $tglsampai . '.xlsx');
    } 

    public function exportReportMonthly(Request $request) 
    {
        $reportDailywinlose = $this->getDataMonthly($request);

        $data = $reportDailywinlose->map(function ($d) {
            return [
                $d->company->name ?? '-',
                $d->username,
                $d->month,
                $d->year,
                number_format($d->turnover, 0, ',', '.'),
                number_format($d->bet_count, 0, ',', '.'),
                number_format($d->member_win, 0, ',', '.'),
                number_format($d->member_win * -1, 0, ',', '.')
            ];
        })->toArray();

        $namereport = 'report-monthly-winlose';

        if ($request->month && $request->month != 'all' && $request->month != 'undefined') {
            $namereport .= '-' . $request->month;
        }

        if ($request->year && $request->month != 'undefined') {
            $namereport .= '-' . $request->year;
        }
        
        $namereport .= '.xlsx';

        return Excel::download(new MonthlyWinloseExport($data), $namereport);
    } 

    public function exportReportYearly(Request $request) 
    {
        $reportDailywinlose = $this->getDataMonthly($request);

        $data = $reportDailywinlose->map(function ($d) {
            return [
                $d->company->name ?? '-',
                $d->username,
                $d->month,
                $d->year,
                number_format($d->turnover, 0, ',', '.'),
                number_format($d->bet_count, 0, ',', '.'),
                number_format($d->member_win, 0, ',', '.'),
                number_format($d->member_win * -1, 0, ',', '.')
            ];
        })->toArray();

        $namereport = 'report-yearly-winlose';

        if ($request->month && $request->month != 'all' && $request->month != 'undefined') {
            $namereport .= '-' . $request->month;
        }

        if ($request->year && $request->month != 'undefined') {
            $namereport .= '-' . $request->year;
        }
        
        $namereport .= '.xlsx';

        return Excel::download(new YearlyWinloseExport($data), $namereport);
    }
}
