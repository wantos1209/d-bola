<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\SeamlessSetting;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::query();

        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->key) {
            $query->where('key', 'like', '%' . $request->key . '%');
        }

        $data = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('company.index', [
            'title' => 'Company Lists',
            'data' => $data
        ]);
    }
    
    public function create()
    {
        return view('company.create', [
            'title' => 'New Company'
        ]);
    }

    public function edit($id)
    {
        $data = Company::where('id', $id)->first();
        return view('company.edit', [
            'title' => 'New Company',
            'data' => $data
        ]);
    }   

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:company,name',
                'min_bet' => 'required|numeric',
                'max_bet' => 'required|numeric'
            ]); 
            
            $createCompany = Company::create([
                'name' => $request->name,
                'key' => $this->generateRandomString(),
                'min_bet' => $request->min_bet,
                'max_bet' => $request->max_bet
            ]);

            $type = [
                'Cancel',
                'Deduct',
                'GetBalance',
                'Rollback',
                'Settle'
            ];
            
            if($createCompany) {
                foreach($type as $tp) {
                    SeamlessSetting::create([
                        'company_id' => $createCompany->id,
                        'type' => $tp,
                        'endpoint' => $tp,
                        'is_enable' => false
                    ]);
                }
            }
            return redirect('/company')->with('success', 'Produk berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|unique:company,name,' . $id,   
                'min_bet' => 'required|numeric',
                'max_bet' => 'required|numeric'    
            ]); 
           
            $company = Company::findOrFail($id);

            $company->update([
                'name' => $request->name,
                'min_bet' =>$request->min_bet,
                'max_bet' =>$request->max_bet
            ]);

            return redirect('/company')->with('success', 'Data perusahaan berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            SeamlessSetting::where('company_id', $id)->delete();

            $company = Company::find($id);
            $company->delete();

            return redirect('/company')->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    private function generateRandomString($length = 60) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }   
}
