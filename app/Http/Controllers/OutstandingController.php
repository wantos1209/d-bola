<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Outstanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutstandingController extends Controller
{
    public function index($username = "")
    {
        $data = Outstanding::select('username', 
        DB::raw('SUM(nominal) as nominal'), 
        DB::raw('COUNT(username) as totalinvoice'))
        ->groupBy('username')
        ->get();

        $dataDetail = [];
        if($username) {
            $dataDetail = Outstanding::where('username', $username)->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->get();
        }
        
        return view('outstanding.index', [
            'title' => 'Outstanding',
            'title2' => 'Detail Outstanding',
            'data' => $data,
            'dataDetail' => $dataDetail
        ]);
    }

    public function create()
    {
        return view('outstanding.create', [
            'title' => 'Outstanding',
        ]);
    }

    public function edit($id)
    {
        $data = Outstanding::where('id', $id)->first();
        return view('outstanding.edit', [
            'title' => 'Outstanding',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
            ]);

            Outstanding::create([
                'name' => $request->name,
            ]);

            return redirect('/outstanding')->with('success', 'Menu berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string',
            ]);
            
            Outstanding::where('id', $id)->update([
                'name' => $request->name,
            ]);

            return redirect('/outstanding')->with('success', 'Menu berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            Outstanding::where('id', $id)->delete();
            return redirect('/outstanding')->with('success', 'Menu berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
