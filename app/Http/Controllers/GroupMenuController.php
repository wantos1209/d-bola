<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\GroupMenu;
use Illuminate\Http\Request;

class GroupMenuController extends Controller
{
    public function index(Request $request)
    {
        $data = GroupMenu::get();
        return view('groupmenu.index', [
            'title' => 'Group Menu',
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('groupmenu.create', [
            'title' => 'Group Menu',
        ]);
    }

    public function edit($id)
    {
        $data = GroupMenu::where('id', $id)->first();
        return view('groupmenu.edit', [
            'title' => 'Group Menu',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
            ]);

            GroupMenu::create([
                'name' => $request->name,
            ]);

            return redirect('/groupmenu')->with('success', 'Menu berhasil ditambahkan');
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
            
            GroupMenu::where('id', $id)->update([
                'name' => $request->name,
            ]);

            return redirect('/groupmenu')->with('success', 'Menu berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            GroupMenu::where('id', $id)->delete();
            return redirect('/groupmenu')->with('success', 'Menu berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
