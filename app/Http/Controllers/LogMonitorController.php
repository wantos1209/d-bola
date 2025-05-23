<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogMonitorController extends Controller
{
    public function index(Request $request)
    {
        $selectedFile = $request->input('logFile');

        $logFiles = collect(File::files(storage_path('logs')))
        ->filter(function ($file) {
            $name = $file->getFilename();
            return $name === 'laravel.log' || str_contains($name, 'error-custom-logs.log');
        })
        ->map(function ($file) {
            return $file->getFilename();
        })
        ->sort()
        ->values();

        $activeLogFile = $selectedFile ?? $logFiles->last();
        $logPath = storage_path('logs/' . $activeLogFile);

        $logs = File::exists($logPath) ? File::get($logPath) : 'Log file not found.';

        return view('monitorlog.index', [
            'title' => 'Custom Log Monitor',
            'logs' => $logs,
            'logFile' => $activeLogFile,
            'availableLogs' => $logFiles,
        ]);
    }

    public function clear(Request $request)
    {
        $logFile = $request->input('logFile');
        $logPath = storage_path('logs/' . $logFile);

        if (File::exists($logPath)) {
            File::put($logPath, ''); 
        }

        return redirect()->route('log.index', ['logFile' => $logFile])
            ->with('status', "Log {$logFile} berhasil dikosongkan.");
    }
}
