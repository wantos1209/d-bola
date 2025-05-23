<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiTestController extends Controller
{
    public function runTests(Request $request)
    {
        try {
            $validated = $request->validate([
                'company_key' => 'required|string',
                'username' => 'required|string',
                'apiUrl' => 'required|url',
            ]);
            
            $CompanyKey = $validated['company_key'];
            $username = $validated['username'];
            $apiUrl = rtrim($validated['apiUrl'], '/');
            $transaction_code = $this->generateRandomString();

            $results = [];
            $webException = null;

            $initialBalance = $this->fetchInitialBalance($apiUrl, $CompanyKey, $username);
        
            if ($initialBalance === null) {
                return response()->json(['error' => 'Failed to fetch initial balance'], 500);
            }

            $currentBalance = $initialBalance;

            $testCases = $this->getDynamicTestCases($apiUrl, $CompanyKey, $username, $transaction_code, $currentBalance);

            $countFailed = 0; 
            foreach ($testCases as $test) {
                $url = $test['url'];
                $requestBody = $test['requestBody'];

                try {
                    $response = Http::post($url, $requestBody);

                    $actualResponse = $response->json();
                    if (is_null($actualResponse)) {
                        $countFailed++;
                        throw new \Exception('Your API response is null or empty.');
                    }

                    $isPassed = $this->compareRelevantAttributes($actualResponse, $test['correctResponse']);
                    
                    if(!$isPassed) {
                        $countFailed++;
                    }

                    $results[] = [
                        'checked' => $isPassed ? 'Passed' : 'Need To Fix',
                        'no' => $test['no'],
                        'method' => $test['method'],
                        'url' => $test['url'],
                        'testDescription' => $test['description'],
                        'requestBody' => json_encode($requestBody),
                        'yourResponse' => $response->body(),
                        'correctResponse' => json_encode($test['correctResponse']),
                    ];

                    if ($test['method'] === 'Deduct') {
                        $currentBalance -= $test['requestBody']['Amount'];
                    } elseif ($test['method'] === 'Settle') {
                        $currentBalance += $test['requestBody']['WinLoss'];
                    }

                } catch (\Exception $e) {
                    $webException = $e->getMessage();

                    $results[] = [
                        'checked' => 'Need to Fix',
                        'no' => $test['no'],
                        'method' => $test['method'],
                        'url' => $test['url'],
                        'testDescription' => $test['description'],
                        'requestBody' => json_encode($requestBody),
                        'yourResponse' => 'Web Exception: ' . $webException,
                        'correctResponse' => json_encode($test['correctResponse']),
                    ];
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json([
            'results' => $results,
            'webException' => $webException ? 'Web Exception: ' . $webException : null,
            'countFailed' => $countFailed
        ]);
    }

    private function compareRelevantAttributes(array $actualResponse, array $expectedResponse)
    {
        if (is_null($actualResponse) || empty($actualResponse)) {
            return false;
        }

        foreach ($expectedResponse as $key => $value) {
            if (!isset($actualResponse[$key]) || $actualResponse[$key] != $value) {
                return false;
            }
        }
        return true; 
    }

    private function fetchInitialBalance($apiUrl, $CompanyKey, $username)
    {
        try {
            $response = Http::post($apiUrl . '/GetBalance', ['CompanyKey'=> $CompanyKey,'Username' => $username]);
            if ($response->successful()) {
                return $response->json()['Balance'];
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    private function generateRandomString() {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $length = 7;
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    private function getDynamicTestCases($url, $CompanyKey, $username, $transaction_code, &$currentBalance)
    {
        return [
            [
                'no' => 1,
                'method' => 'GetBalance',
                'description' => 'Get balance before deduct',
                'url' => $url . '/GetBalance',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'AccountName' => $username,
                    'Balance' => $currentBalance, 
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 2,
                'method' => 'GetBetStatus',
                'description' => 'Get bet status should not exist',
                'url' => $url . '/GetBetStatus',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'TransactionCode' => $transaction_code,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'ErrorCode' => 6,
                    'ErrorMessage' => 'Bet not exists'
                ],
            ],
            [
                'no' => 3,
                'method' => 'Deduct',
                'description' => '1st time deduct should be success',
                'url' => $url . '/Deduct',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'TransactionCode' => $transaction_code,
                    'Username' => $username,
                    'Amount' => 100,
                    'GameId' => 1
                ],
                'correctResponse' => [
                    'Balance' => $currentBalance -= 100, 
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 4,
                'method' => 'GetBalance',
                'description' => 'Get balance again should different balance',
                'url' => $url . '/GetBalance',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'AccountName' => $username,
                    'Balance' => $currentBalance, 
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 5,
                'method' => 'GetBetStatus',
                'description' => 'Get bet status again should running',
                'url' => $url . '/GetBetStatus',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'TransactionCode' => $transaction_code,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'Status' => 'Running',
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 6,
                'method' => 'Deduct',
                'description' => '2nd time deduct should be failed',
                'url' => $url . '/Deduct',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'TransactionCode' => $transaction_code,
                    'Username' => $username,
                    'Amount' => 100,
                    'GameId' => 1
                ],
                'correctResponse' => [
                    'ErrorCode' => 5003,
                    'ErrorMessage' => 'Bet With Same RefNo Exists'
                ],
            ],
            [
                'no' => 7,
                'method' => 'GetBalance',
                'description' => 'Get balance again should same balance',
                'url' => $url . '/GetBalance',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'AccountName' => $username,
                    'Balance' => $currentBalance, 
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 8,
                'method' => 'GetBetStatus',
                'description' => 'Get bet status again should running',
                'url' => $url . '/GetBetStatus',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    "TransactionCode" => $transaction_code,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'Status' => 'Running',
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 9,
                'method' => 'Settle',
                'description' => '1st time settle should be success',
                'url' => $url . '/Settle',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'TransactionCode' => $transaction_code,
                    'Username' => $username,
                    'WinLoss' => 300
                ],
                'correctResponse' => [
                    'Balance' => $currentBalance += 300, 
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 10,
                'method' => 'GetBalance',
                'description' => 'Get balance again should different balance',
                'url' => $url . '/GetBalance',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'AccountName' => $username,
                    'Balance' => $currentBalance, 
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 11,
                'method' => 'GetBetStatus',
                'description' => 'Get bet status again should settled',
                'url' => $url . '/GetBetStatus',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'TransactionCode' => $transaction_code,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'Status' => 'Settled',
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 12,
                'method' => 'Settle',
                'description' => '2nd time settle should be failed',
                'url' => $url . '/Settle',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'TransactionCode' => $transaction_code,
                    'Username' => $username,
                    'WinLoss' => 300
                ],
                'correctResponse' => [
                    'ErrorCode' => 2001,
                    'ErrorMessage' => 'Bet Already Settled'
                ],
            ],
            [
                'no' => 13,
                'method' => 'GetBalance',
                'description' => 'Get balance again should same balance',
                'url' => $url . '/GetBalance',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'AccountName' => $username,
                    'Balance' => $currentBalance, 
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 14,
                'method' => 'GetBetStatus',
                'description' => 'Get bet status again should settled',
                'url' => $url . '/GetBetStatus',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'TransactionCode' => $transaction_code,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'Status' => 'Settled',
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 15,
                'method' => 'Cancel',
                'description' => '1st time cancel should be success',
                'url' => $url . '/Cancel',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'TransactionCode' => $transaction_code,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'Balance' => $currentBalance -=(300-100),
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 16,
                'method' => 'GetBalance',
                'description' => 'Get balance again should different balance',
                'url' => $url . '/GetBalance',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'AccountName' => $username,
                    'Balance' => $currentBalance, 
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 17,
                'method' => 'GetBetStatus',
                'description' => 'Get bet status again should void',
                'url' => $url . '/GetBetStatus',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'TransactionCode' => $transaction_code,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'Status' => 'Void',
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 18,
                'method' => 'Cancel',
                'description' => '2nd time cancel should be failed',
                'url' => $url . '/Cancel',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'TransactionCode' => $transaction_code,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'ErrorCode' => 2002,
                    'ErrorMessage' => 'Bet Already Canceled'
                ],
            ],
            [
                'no' => 19,
                'method' => 'GetBalance',
                'description' => 'Get balance again should same balance',
                'url' => $url . '/GetBalance',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'AccountName' => $username,
                    'Balance' => $currentBalance,
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 20,
                'method' => 'GetBetStatus',
                'description' => 'Get bet status again should void',
                'url' => $url . '/GetBetStatus',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'TransactionCode' => $transaction_code,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'Status' => 'Void',
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 21,
                'method' => 'Rollback',
                'description' => '1st time rollback should be success',
                'url' => $url . '/Rollback',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'TransactionCode' => $transaction_code,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'Balance' => $currentBalance -= 100, 
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 22,
                'method' => 'GetBalance',
                'description' => 'Get balance again should different balance',
                'url' => $url . '/GetBalance',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'AccountName' => $username,
                    'Balance' => $currentBalance,
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 23,
                'method' => 'GetBetStatus',
                'description' => 'Get bet status again should running',
                'url' => $url . '/GetBetStatus',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'TransactionCode' => $transaction_code,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'Status' => 'Running',
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 24,
                'method' => 'Rollback',
                'description' => '2nd time rollback should be failed',
                'url' => $url . '/Rollback',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'TransactionCode' => $transaction_code,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'ErrorCode' => 2003,
                    'ErrorMessage' => 'Bet Already Rollback'
                ],
            ],
            [
                'no' => 25,
                'method' => 'GetBalance',
                'description' => 'Get balance again should same balance',
                'url' => $url . '/GetBalance',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'AccountName' => $username,
                    'Balance' => $currentBalance, 
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 26,
                'method' => 'GetBetStatus',
                'description' => 'Get bet status again should running',
                'url' => $url . '/GetBetStatus',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'TransactionCode' => $transaction_code,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'Status' => 'Running',
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 27,
                'method' => 'Settle',
                'description' => 'Settle after rollback should be success',
                'url' => $url . '/Settle',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'TransactionCode' => $transaction_code,
                    'Username' => $username,
                    'WinLoss' => 300
                ],
                'correctResponse' => [
                    'Balance' => $currentBalance += 300, 
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 28,
                'method' => 'GetBalance',
                'description' => 'Get balance again should different balance',
                'url' => $url . '/GetBalance',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'AccountName' => $username,
                    'Balance' => $currentBalance, 
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ],
            [
                'no' => 29,
                'method' => 'GetBetStatus',
                'description' => 'Get bet status again should settled',
                'url' => $url . '/GetBetStatus',
                'requestBody' => [
                    'CompanyKey' => $CompanyKey,
                    'TransactionCode' => $transaction_code,
                    'Username' => $username
                ],
                'correctResponse' => [
                    'Status' => 'Settled',
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ],
            ]
        ];
    }
    
    public function documentation()
    {
        return view('documentation.index');
    }

    public function docsTest()
    {
        return view('documentation.indextest');
    }
}
