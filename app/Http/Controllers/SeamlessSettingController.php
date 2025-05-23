<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\SeamlessSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeamlessSettingController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::query();

        if ($request->company) {
            $query->where('id', $request->company);
        }

        if ($request->companyKey) {
            $query->where('key', 'like', '%' . $request->companyKey . '%');
        }

        $data = $query->orderBy('name', 'ASC')->get();
        $dataCompany = Company::orderBy('name', 'ASC')->get();

        return view('seamlesssetting.index', [
            'title' => 'Seamless Wallet Setting',
            'data' => $data,
            'dataCompany' => $dataCompany
        ]);
    }


    public function create ()
    {
        return view('seamlesssetting.create', [
            'title' => 'Seamless Wallet Setting'
        ]);
    }

    public function view ($company_id)
    {
        if(!Auth::user()->is_superadmin) {
          $company_id = Auth::user()->company_id;
        }
        
        $data = SeamlessSetting::where('company_id', $company_id)->get();
        
        $dataCompany = Company::where('id', $company_id)->first();
        return view('seamlesssetting.create', [
            'title' => 'Seamless Wallet Setting',
            'data' => $data,
            'dataCompany' => $dataCompany
        ]);
    }


    public function updateEnable(Request $request)
    {
        try {
        $validated = $request->validate([
            'id' => 'required|exists:seamless_settings,id',
            'is_enable' => 'required|boolean',
        ]);

        $setting = SeamlessSetting::find($validated['id']);
        $setting->is_enable = $validated['is_enable'];
        $setting->save();
        
        return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
