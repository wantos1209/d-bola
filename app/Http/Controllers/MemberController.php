<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with('company');
    
        if ($request->company) {
            $query->where('company_id', $request->company);
        }
    
        if ($request->username) {
            $query->where('username', 'like', '%' . $request->username . '%');
        }
    
        $data = $query->orderBy('created_at', 'desc')->paginate(20);
    
        $dataCompany = Company::orderBy('name', 'ASC')->get();
    
        return view('member.index', [
            'title' => 'Member',
            'data' => $data,
            'dataCompany' => $dataCompany
        ]);
    }
    

    public function create()
    {
        $dataCompany = Company::get();
        return view('member.create', [
            'title' => 'Member',
            'dataCompany' => $dataCompany
        ]);
    }

    public function edit($id)
    {
        $dataCompany = Company::get();
        $data = Member::where('id', $id)->first();
        return view('member.edit', [
            'title' => 'Member',
            'dataCompany' => $dataCompany,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'company_id' => 'required|exists:company,id',
                'username' => 'required|string|unique:member,username',
                'status' => 'required|in:1,2',
                'min_bet' => 'required|numeric',
                'max_bet' => 'required|numeric'
            ]);

            Member::create([
                'company_id' => $request->company_id,
                'username' => $request->username,
                'status' => $request->status,
                'min_bet' => $request->min_bet,
                'max_bet' => $request->max_bet
            ]);

            return redirect('/member')->with('success', 'Member berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'company_id' => 'required|exists:company,id',
                'username' => 'required|string|unique:member,username,' . $id,
                'status' => 'required|in:1,2',
                'min_bet' => 'required|numeric',
                'max_bet' => 'required|numeric'
            ]);

            Member::where('id', $id)->update([
                'company_id' => $request->company_id,
                'username' => $request->username,
                'status' => $request->status,
                'min_bet' => $request->min_bet,
                'max_bet' => $request->max_bet
            ]);

            return redirect('/member')->with('success', 'Member berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            Member::where('id', $id)->delete();
            return redirect('/member')->with('success', 'Member berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
