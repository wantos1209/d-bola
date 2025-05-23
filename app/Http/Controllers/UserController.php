<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\UserAccess;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('company');

        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->username) {
            $query->where('username', 'like', '%' . $request->username . '%');
        }

        if ($request->company) {
            $query->where('company_id', $request->company);
        }

        $data = $query->orderBy('created_at', 'desc')->paginate(20);

        $dataCompany = Company::orderBy('name', 'DESC')->get();

        return view('user.index', [
            'title' => 'User',
            'data' => $data,
            'dataCompany' => $dataCompany
        ]);
    }

    public function create()
    {
        $dataCompany = Company::get();
        $dataUserAccess = UserAccess::get();
        return view('user.create', [
            'title' => 'User',
            'dataCompany' => $dataCompany,
            'dataUserAccess' => $dataUserAccess
        ]);
    }

    public function edit($id)
    {
        $dataCompany = Company::get();
        $data = User::where('id', $id)->first();
        $dataUserAccess = UserAccess::get();
        return view('user.edit', [
            'title' => 'User',
            'dataCompany' => $dataCompany,
            'data' => $data,
            'dataUserAccess' => $dataUserAccess
        ]);
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|string|max:100',
                'username' => 'required|string|unique:users,username',
                'password' => 'required|min:6',
                'divisi' => 'required|in:8,9',
            ];

            if ($request->divisi != 9) {
                $rules['company_id'] = 'required|exists:company,id';
            }

            $request->validate($rules);

            $data = [
                'divisi' => $request->divisi,
                'name' => $request->name,
                'username' => $request->username,
                'password' => bcrypt($request->password),
            ];

            if ($request->divisi != 9) {
                $data['company_id'] = $request->company_id;
            }

            User::create($data);

            return redirect('/user')->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $rules = [
                'name' => 'required|string|max:100',
                'username' => 'required|string|unique:users,username,' . $id,
                'divisi' => 'required|in:8,9',
            ];            

            if ($request->divisi != 9) {
                $rules['company_id'] = 'required|exists:company,id';
            }

            if ($request->filled('password')) {
                $rules['password'] = 'min:6|confirmed';
            }

            $request->validate($rules);

            $data = [
                'divisi' => $request->divisi,
                'name' => $request->name,
                'username' => $request->username,
            ];

            if ($request->divisi != 9) {
                $data['company_id'] = $request->company_id;
            } else {
                $data['company_id'] = null; 
            }

            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            User::where('id', $id)->update($data);

            return redirect('/user')->with('success', 'User berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            User::where('id', $id)->delete();
            return redirect('/user')->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
