<?php

namespace App\Http\Controllers;

use App\Jobs\createHistoryJob;
use App\Jobs\ProcessSaveWinDataJob;
use App\Jobs\ProcessVoid;
use App\Models\Company;
use App\Models\Game;
use App\Models\Historytransaction;
use App\Models\HistorytransactionOld;
use App\Models\Member;
use App\Models\Period;
use App\Models\PeriodBet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        try {
            $token = $this->checkAuthentication($request->bearerToken());
            if (!$token) {
                return response()->json(['status' => 'Failed', 'message' => 'Unauthorized'], 401);
            }

            $validator = Validator::make($request->all(), [
                'companyKey' => 'required|string',
                'username' => 'required|string',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $member = Member::where('username', $request->username)->first();
            $company = Company::where('key', $request->companyKey)->first();

            if(!$company) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Company not found'
                ], 422);
            }

            if(!$member) {
                $member = Member::create([
                    'company_id' => $company->id,
                    'username' => $request->username,
                    'password' => Hash::make('$request->username'),
                ]);
            }
            
            $getBalance = $this->apiGetBalance($member->username);
            
            if($getBalance['message'] === 'Success' && $getBalance['data']['ErrorCode'] === 0) {
                $balance = $getBalance['data']['Balance'];
            } else {
                Log::channel('error-custom-logs')->error("['ApiController', 'login'] Failed Api login to call Api GetBalance failed response for user {$request->username} and ErrorCode : " . $getBalance['data']['ErrorCode']);
                $balance = 0;
            }
            
            $token = $member->createToken('auth_token')->plainTextToken;
           
            $dataMember = [
                'username' => $member->username,
                'periodno' => $member->periodno,
                'statusgame' => $member->statusgame,
                'balance' => $balance
            ];

            return response()->json([
                'status' => 'Success',
                'message' => 'Login successful',
                'data' => [
                    'user' => $dataMember,
                    'token' => $token
                ]
            ]);
        }  catch (\Exception $e) {
            return $e->getMessage();
            Log::channel('error-custom-logs')->error("['ApiController', 'login', 'exception'] Failed Api login to call Api GetBalance : " . $e->getMessage());
            return response()->json([
                'status' => 'fail',
                'message' => 'error.',
                'error' => $e->getMessage(),  
            ], 500);
        }
        
    }

    public function register(Request $request)
    {
        try {
            $token = $this->checkAuthentication($request->bearerToken());
            if (!$token) {
                return response()->json(['status' => 'Failed', 'message' => 'Unauthorized'], 401);
            }
            
            $validator = Validator::make($request->all(), [
                'companyKey' => 'required|string',
                'username' => 'required|string|unique:member',
                'password' => 'required|string',
                'bank' => 'required|string',
                'hp' => 'required|string',
                'namarek' => 'required|string',
                'norek' => 'required|string',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
           
            $member = Member::where('username', $request->username)->first();
            $company = Company::where('key', $request->companyKey)->first();

            $dataRequest = [
                'company_id' => $company->id,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'bank' => $request->bank,
                'hp' => $request->hp,
                'namarek' => $request->namarek,
                'norek' => $request->norek
            ];

            if(!$company) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Company not found'
                ], 422);
            }

            if(isset($request->referral)) {
                $memberReferral = Member::where('username', $request->referral)->first();
                if(!$memberReferral) {
                    return response()->json([
                        'status' => 'Failed',
                        'message' => 'Referral not found'
                    ]);
                } else {
                    $dataRequest['referral'] = $request->referral;
                }
                
            } 
            

            if(!$member) {
                $member = Member::create($dataRequest);
            }
            
            $regusterPlayer = $this->apiRegister($request, $company);
            
            if($regusterPlayer['message'] === 'Success' && $regusterPlayer['data']['ErrorCode'] === 0) {
            } else {
                Log::channel('error-custom-logs')->error("['ApiController', 'login'] Failed Api login to call Api GetBalance failed response for user {$request->username} and ErrorCode : " . $regusterPlayer['data']['ErrorCode']);
            }
            
            $token = $member->createToken('auth_token')->plainTextToken;

            $dataMember = [
                'username' => $member->username,
                'periodno' => '',
                'statusgame' => '',
                'balance' => 0
            ];

            return response()->json([
                'status' => 'Success',
                'message' => 'Login successful',
                'data' => [
                    'user' => $dataMember,
                    'token' => $token
                ]
            ]);
        }  catch (\Exception $e) {
            return $e->getMessage();
            Log::channel('error-custom-logs')->error("['ApiController', 'login', 'exception'] Failed Api login to call Api GetBalance : " . $e->getMessage());
            return response()->json([
                'status' => 'fail',
                'message' => 'error.',
                'error' => $e->getMessage(),  
            ], 500);
        }
        
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user(); 
            $user->currentAccessToken()->delete(); 

            return response()->json([
                'status' => 'Success',
                'message' => 'Logged out successfully'
            ]);
        }  catch (\Exception $e) {
            Log::channel('error-custom-logs')->error("['ApiController', 'logout', 'exception'] Failed Api logout : " . $e->getMessage());
            return response()->json([
                'status' => 'fail',
                'message' => 'error.',
                'error' => $e->getMessage(),  
            ], 500);
        }
    }

    public function getBalance()
    {
        try {
            $username = Auth::user()->username;
            
            if (!$username) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Username cannot be empty'
                ], 400);
            }

            $data = $this->apiGetBalance($username);
            if ($data['data']['ErrorCode'] !== 0) {
                Log::channel('error-custom-logs')->error("['ApiController', 'getBalance'] Failed apiGetBalance failed response for user {$username} and ErrorCode : " . $data['data']['ErrorCode']);
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Balance retrieved failed'
                ], 404);
            }

            return response()->json([
                'status' => 'Success',
                'message' => 'Balance retrieved successfully',
                'data' => [
                    'username' => $data["data"]["AccountName"],
                    'balance' => $data["data"]["Balance"]
                ]
            ]);
        } catch (\Exception $e) {
            Log::channel('error-custom-logs')->error("['ApiController', 'getBalance', 'exception'] Failed Api GetBalance : " . $e->getMessage());
            return response()->json([
                'status' => 'fail',
                'message' => 'error.',
                'error' => $e->getMessage(),  
            ], 500);
        }
    }

    public function savePalceBet(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'periodno' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'mc' => 'nullable|numeric|min:0',
                'head_mc' => 'nullable|numeric|min:0',
                'body_mc' => 'nullable|numeric|min:0',
                'leg_mc' => 'nullable|numeric|min:0',
                'bm' => 'nullable|numeric|min:0',
                'head_bm' => 'nullable|numeric|min:0',
                'body_bm' => 'nullable|numeric|min:0',
                'leg_bm' => 'nullable|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Validation error: ' . implode(', ', $validator->errors()->all()),
                ], 422);
            }

            $dataPeriod = Period::where('periodno', $request->periodno)->where('statusgame', 1)->first();
            if(!$dataPeriod) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Period not found or already completed',
                ], 422);
            }
            $dataUser = $this->apiGetBalance($request->username);
            
            if($dataUser["data"]["ErrorCode"] !== 0) {
                Log::channel('error-custom-logs')->error("['ApiController', 'savePalceBet'] Failed apiGetBalance failed response for : ", [
                    "user" => $request->username,
                    "ErrorCode" =>  $dataUser["data"]["ErrorCode"]
                ]);
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'User not found. Please check the username and try again.',
                ], 422);
            }

            $mc = $request->mc ?? 0;
            $head_mc = $request->head_mc ?? 0;
            $body_mc = $request->body_mc ?? 0;
            $leg_mc = $request->leg_mc ?? 0;
            $bm = $request->bm ?? 0;
            $head_bm = $request->head_bm ?? 0;
            $body_bm = $request->body_bm ?? 0;
            $leg_bm = $request->leg_bm ?? 0;

            $totalBet = $mc + $head_mc + $body_mc + $leg_mc + $bm + $head_bm + $body_bm + $leg_bm;
            
            if($totalBet > $dataUser["data"]["Balance"]) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Insufficient balance.',
                ], 422);
            }

            if($totalBet == 0) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Invalid bet.',
                ], 422);
            }

            $cekDataPeriodBet = PeriodBet::with('period')
                ->whereHas('period', function ($query) use ($request) {
                    $query->where('periodno', $request->periodno);
                })
                ->where('username', $request->username)
                ->first();
                
            if($cekDataPeriodBet) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'You have already placed a bet for this period.',
                ], 422);
            }
            $TransactionCode = $this->getRandomTransactionNo();
           
            $company = Member::where('username', $request->username)->first()->company;
            
            $periodBet = new PeriodBet();
            $periodBet->company_id = $company ? $company->id : 1;
            $periodBet->period_id = $dataPeriod->id;
            $periodBet->transaction_code = $TransactionCode;
            $periodBet->Username = $request->username;
            $periodBet->mc = $mc;
            $periodBet->head_mc = $head_mc;
            $periodBet->body_mc = $body_mc;
            $periodBet->leg_mc = $leg_mc;
            $periodBet->bm = $bm;
            $periodBet->head_bm = $head_bm;
            $periodBet->body_bm = $body_bm;
            $periodBet->leg_bm = $leg_bm;
            $periodBet->amount_bet = $totalBet;
            
            try {
                DB::transaction(function () use (&$periodBet, $dataPeriod, $dataUser, $totalBet, $TransactionCode, $company, $request) {
                    if ($dataUser["data"]["Balance"] >= $totalBet) {
                        if (!$periodBet->save()) {
                            throw new \Exception("Gagal menyimpan periodBet");
                        }

                        $member = Member::where('username', $periodBet->Username)->first();
                        $period = Period::where('id', $periodBet->period_id)->first();

                        $member->update([
                            'periodno' => $period->periodno,
                            'statusgame' => 1
                        ]);

                        $deduct = $this->apiDeduct($periodBet->Username, $periodBet->amount_bet, $TransactionCode, $company);
                        
                        if ($deduct['message'] !== 'Success' || ($deduct['data']['ErrorCode'] ?? 1) !== 0) {
                            throw new \Exception('Gagal melakukan deduct saldo: ' . ($deduct['error'] ?? 'Unknown error'));
                        }
                        
                        $dataBetting = $this->getDataBetting($request);

                        $this->createHistoryTransaction($dataBetting, $dataPeriod->id, $periodBet->Username, $period->periodno, '-', 'pemasangan', $totalBet, 0, $dataUser["data"]["Balance"], $company, $periodBet->transaction_code, 1); //game id sementara di static dulu
                    } else {
                        Log::channel('error-custom-logs')->error("['ApiController', 'savePalceBet', 'exception'] Balance samll then betting amount");
                        throw new \Exception('Insufficient balance.');
                    }
                });
                
            } catch (\Exception $e) {
                Log::channel('error-custom-logs')->error("['ApiController', 'savePalceBet', 'exception'] Failed process createPeriodBet : " . $e->getMessage());
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'An error occurred during the transaction. Please try again later.',
                ], 500);
            }

            try {
                $balanceAfterBetting = $this->apiGetBalance($periodBet->Username)["data"]["Balance"];
                
                $this->broadcastBalance($periodBet->Username, $balanceAfterBetting);
            } catch (\Exception $e) {
                Log::channel('error-custom-logs')->error("['ApiController', 'savePalceBet', 'exception'] Failed process broadcastBalance but Transaction created successfully, error : " . $e->getMessage());
                return response()->json([
                    'status' => 'Success with Warning',
                    'message' => 'Transaksi berhasil, tapi gagal melakukan broadcast saldo.',
                ]);
            }

            return response()->json([
                'status' => 'Success',
                'message' => 'Period bet created successfully!',
            ], 201);
        } catch (\Exception $e) {
            Log::channel('error-custom-logs')->error("['ApiController', 'savePalceBet', 'exception2'] Failed process createPeriodBet : " . $e->getMessage());
            return response()->json([
                'status' => 'Failed',
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function getDataBetting($request){
        $dataBetting = [];
        if(($request->bm ?? 0) > 0) {
            $dataBetting[] = 'bm';
        } 
        if(($request->head_bm ?? 0) > 0) {
            $dataBetting[] = 'head_bm';
        }
        if(($request->body_bm ?? 0) > 0) {
            $dataBetting[] = 'body_bm';
        }
        if(($request->leg_bm ?? 0) > 0) {
            $dataBetting[] = 'leg_bm';
        }
        if(($request->bm ?? 0) > 0) {
            $dataBetting[] = 'mc';
        } 
        if(($request->head_mc ?? 0) > 0) {
            $dataBetting[] = 'head_mc';
        }
        if(($request->body_mc ?? 0) > 0) {
            $dataBetting[] = 'body_mc';
        }
        if(($request->leg_mc ?? 0) > 0) {
            $dataBetting[] = 'leg_mc';
        }
        return $dataBetting;
    }

    private function broadcastBalance($username, $balance)
    {
        try {
            Http::get(env('WS_URL') . '/api/broadcastBalance/' . $username . '/' . $balance);
        } catch (\Throwable $e) {
            Log::channel('error-custom-logs')->error("Failed GetBalance failed response for user {$username}: " . json_encode($e->getMessage()));
        }
        return ;
    }

    public function apiGetBalance($username)
    {
        $url = env('URL_SEAMLESS') . '/api/GetBalance';
        
        $data = [
            'CompanyKey' => Member::where('username', $username)->first()->company->key,
            'Username'   => $username,
        ];

        $response = Http::post($url, $data);
        if ($response->successful()) {
            return [
                'message' => 'Success',
                'data' => $response->json(),
            ];
        } else {
            return [
                'message' => 'Failed',
                'data' => ['ErrorCode' => 99],
                'error' => $response->body(),
            ];
        }
    }

    public function apiRegister($request, $company)
    {
        $url = env('URL_SEAMLESS') . '/api/Register';

        $data = [
            'Username' => $request->username,
            'CompanyKey' => $company->key,
        ];

        $response = Http::post($url, $data);
        if ($response->successful()) {
            return [
                'message' => 'Success',
                'data' => $response->json(),
            ];
        } else {
            return [
                'message' => 'Failed',
                'data' => [],
                'error' => $response->body(),
            ];
        }
    }

    public function apiDeduct($username, $amount, $transactionId, $company)
    {
        $url = env('URL_SEAMLESS') . '/api/Deduct';
        $data = [
            "CompanyKey" => $company->key,
            "TransactionCode" => $transactionId,
            'Username' => $username,
            'Amount' => $amount,
            "GameId" => 1,
        ];
        
        $response = Http::post($url, $data);
        if ($response->successful()) {
            if($response->json()["ErrorCode"] == 0) {
                return [
                    'message' => 'Success',
                    'data' => $response->json(),
                ];
            } else {
                Log::channel('error-custom-logs')->error("['ApiController', 'apiDeduct'] Failed apiDeduct : ", [
                    'body' => $data,
                    'ErrorCode' => $response->json()["ErrorCode"],
                ]);
            }
        } else {
            Log::channel('error-custom-logs')->error("['ApiController', 'apiDeduct'] Failed apiDeduct : ", [
                'body' => $data,
                'error' => $response->body(),
            ]);
        }

        return [
            'message' => 'Failed',
            'data' => [],
            'error' => $response->body(),
        ];
    }

    private function createHistoryTransaction($dataBetting, $period_id, $username, $periodno, $keterangan, $status, $debit, $kredit, $balance, $company, $transactionCode, $GameId)
    {
        $data = [
            "outstanding" => [
                'company_id' => $company->id,
                'username' => $username,
                'periode_code' => $periodno,
                'nominal' => $debit
            ],
            "historyTransaksi" => [
                'company_id' => $company->id,
                'game_id' => $GameId,
                'period_id' => $period_id,
                'username' => $username,
                'periodno' => $periodno,
                'transaction_code' => $transactionCode,
                'keterangan' => $keterangan,
                'status' => $status,
                'betting' => json_encode($dataBetting),
                'debit' => $debit,
                'kredit' => $kredit,
            ],
            "gameId" => $GameId
        ];

        createHistoryJob::dispatch($data);
        return;
    }

    public function checkAuthentication($token)
    {
        if (!$token) {
            return false;
        }
        $tokenEnv = env('TOKEN_BEARER');
    
        if (hash_equals($token, $tokenEnv)) {
            return true;
        }
    
        return false;
    }

    private function getRandomTransactionNo()
    {
        $data = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < 10; $i++) {
            $randomString .= $data[rand(0, strlen($data) - 1)];
        }

        return $randomString;
    }

    public function getCompany(Request $request)
    {
        $token = $this->checkAuthentication($request->bearerToken());
        if (!$token) {
            return response()->json(['status' => 'Failed', 'message' => 'Unauthorized'], 401);
        }

        $data = Company::first();
        return response()->json([
            'status' => 'success',
            'message' => 'Data successfully fetched',
            'data' => $data
        ]);
    }

    public function processSave(Request $request)
    {
        try {
            $token = $this->checkAuthentication($request->bearerToken());
            if (!$token) {
                return response()->json(['status' => 'Failed', 'message' => 'Unauthorized'], 401);
            }

            $dataWin = $request->input('dataWin');
            $periodno = $request->input('periodno');
            $gameId = $request->input('gameId');

            ProcessSaveWinDataJob::dispatch([
                'dataWin' => $dataWin,
                'periodno' => $periodno,
                'gameId' => $gameId
            ]);
            return response()->json([
                'status' => 'Success',
                'message' => 'Job dispatched successfully'
            ]);

        } catch (\Exception $e) {
            Log::channel('error-custom-logs')->error("['ApiController', 'processSave'] Failed to dispatch job : " . $e->getMessage());

            return response()->json([
                'status' => 'fail',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),  
            ], 500);
        }
    }

    public function getHistory(Request $request)
    {
        $username = Auth::user()->username;
        
        if (!$username) {
            Log::channel('error-custom-logs')->error("['ApiController', 'getHistory'] Username not registered");

            return response()->json([
                'status' => 'fail',
                'message' => 'Username not registered.',
            ], 500);
        }

        $query = Historytransaction::with('period')->where('username', $username);

        $histories = $query->orderBy('created_at', 'desc')->limit(30)->get();

        $histories->transform(function ($item) {
            if (is_string($item->betting)) {
                $item->betting = json_decode($item->betting, true);
            }
            return $item;
        });

        return response()->json([
            'status' => 'success',
            'data' => $histories,
        ]);
    }

    public function getHistoryOld(Request $request)
    {
        $username = Auth::user()->username;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $page = $request->page ?? 1;
        
        if (!$username) {
            Log::channel('error-custom-logs')->error("['ApiController', 'getHistoryOld'] Username not registered");

            return response()->json([
                'status' => 'fail',
                'message' => 'Username not registered.',
            ], 500);
        }

        $query = HistorytransactionOld::with('period')->where('username', $username);

        if ($date_from && $date_to) {
            $query->whereBetween('created_at', [
                $date_from . " 00:00:00", 
                $date_to . " 23:59:59"
            ]);
        }

        $histories = $query->orderBy('created_at', 'desc')->paginate(10, ['*'], 'page', $page);

        $histories->transform(function ($item) {
            if (is_string($item->betting)) {
                $item->betting = json_decode($item->betting, true);
            }
            return $item;
        });

        return response()->json([
            'status' => 'success',
            'data' => $histories,
        ]);
    }

    public function getHistoryFilter(Request $request)
    {
        $username = Auth::user()->username;
        $filterPeriodno = $request->periodno;
        // $page = $request->page ?? 1;
        
        if (!$username) {
            Log::channel('error-custom-logs')->error("['ApiController', 'getHistoryOld'] Username not registered");

            return response()->json([
                'status' => 'fail',
                'message' => 'Username not registered.',
            ], 500);
        }

        $query = HistorytransactionOld::with('period')->where('username', $username);
        
        if ($filterPeriodno) {
            $query->where('periodno', 'like', '%' . $filterPeriodno . '%');  
        }

        $histories = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $histories,
        ]);
    }

    public function listGame(Request $request)
    {
        $token = $this->checkAuthentication($request->bearerToken());
        if (!$token) {
            return response()->json(['status' => 'Failed', 'message' => 'Unauthorized'], 401);
        }
        
        $data = Game::get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function processVoid(Request $request) 
    {
        $token = $this->checkAuthentication($request->bearerToken());
        if (!$token) {
            return response()->json(['status' => 'Failed', 'message' => 'Unauthorized'], 401);
        }

        $period_id = $request->input('period_id');
        $dataPeriod = Period::where('id', $period_id)->where('statusgame', '!=', '3')->first();
        $company = Company::first();
        
        if($dataPeriod) {
            $dataPeriodBet = PeriodBet::where('period_id', $dataPeriod->id)->get();
            $data = [
                'period_id' => $period_id,
                'dataPeriodBet' => $dataPeriodBet,
                'companyKey' => $company->key
            ];
            ProcessVoid::dispatch($data);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Job dispatched successfully'
        ]);
    }

    public function deposit(Request $request)
    {
        $username = Auth::user()->username;

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
        ]);
        
        $company = Company::where('id', Auth::user()->company_id)->first();

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [
            'username' => $username,
            'balance' => $request->amount,
            'companyKey' => $company->key,
        ];
        
        $response = $this->apiDeposit($data, $company);
        return $response;
    }


    public function apiDeposit($request, $company)
    {
        $url = env('URL_SEAMLESS') . '/api/CreateNewDepo';
        
        $data = [
            'Username' => $request['username'],
            'Balance' => $request['balance'],
            'CompanyKey' => $company->key,
        ];
        
        $response = Http::post($url, $data);
        if ($response->successful()) {
            return [
                'message' => 'Success',
                'data' => $response->json(),
            ];
        } else {
            return [
                'message' => 'Failed',
                'data' => [],
                'error' => $response->body(),
            ];
        }
    }

    public function getConfigMinMax()
    {
        $dataMember = Auth::user();
        $dataConfig = Member::where('member_id', $dataMember->id)->where('company_id', $dataMember->company_id)->first();
        if(!$dataConfig) {
            $dataConfig = Company::where('company_id', $dataMember->company_id)->first();
        }

        return response()->json([
            'status' => 'success',
            'data' => $dataConfig
        ]);
    }
}
