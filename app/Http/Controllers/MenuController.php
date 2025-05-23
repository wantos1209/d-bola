<?php

namespace App\Http\Controllers;

use App\Models\GroupMenu;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $data = Menu::get();
        return view('menu.index', [
            'title' => 'Menu',
            'data' => $data
        ]);
    }

    public function create()
    {
        $dataGroup = GroupMenu::get();
        return view('menu.create', [
            'title' => 'Menu',
            'dataGroup' => $dataGroup
        ]);
    }

    public function edit($id)
    {
        $dataGroup = GroupMenu::get();
        $data = Menu::where('id', $id)->first();
        return view('menu.edit', [
            'title' => 'Menu',
            'dataGroup' => $dataGroup,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'group_id' => 'required',
                'name' => 'required|string',
                'route' => 'required|string',
                'icon' => 'required|string',
            ]);

            Menu::create([
                'group_id' => $request->group_id,
                'name' => $request->name,
                'route' => $request->route,
                'icon' => $request->icon
            ]);

            Cache::forget('menus_sidebar');

            return redirect('/menu')->with('success', 'Menu berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'group_id' => 'required',
                'name' => 'required|string',
                'route' => 'required|string',
                'icon' => 'required|string',
            ]);
            
            Menu::where('id', $id)->update([
                'group_id' => $request->group_id,
                'name' => $request->name,
                'route' => $request->route,
                'icon' => $request->icon
            ]);

            Cache::forget('menus_sidebar');

            return redirect('/menu')->with('success', 'Menu berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            Menu::where('id', $id)->delete();
            Cache::forget('menus_sidebar');
            return redirect('/menu')->with('success', 'Menu berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
