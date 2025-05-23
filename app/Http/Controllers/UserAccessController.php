<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Menu;
use App\Models\MenuAccess;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAccessController extends Controller
{
    public function index(Request $request)
    {
        $query = UserAccess::with('menuAccesses.menu');

        if ($request->name) {
            $query->whereHas('menuAccesses.menu', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        $data = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('useraccess.index', [
            'title' => 'User Access',
            'data' => $data
        ]);
    }

    public function create()
    {
        $dataMenu = Menu::get();
        return view('useraccess.create', [
            'title' => 'User Access',
            'dataMenu' => $dataMenu
        ]);
    }

    public function edit($id)
    {
        $data = UserAccess::where('id', $id)->first();
        $dataMenu = Menu::with(['menuAccesses' => function ($query) use ($id) {
            $query->where('useraccess_id', $id);
        }])
        ->whereHas('menuAccesses', function ($query) use ($id) {
            $query->where('useraccess_id', $id);
        })
        ->get();
        
        return view('useraccess.edit', [
            'title' => 'User Access',
            'data' => $data,
            'dataMenu' => $dataMenu
        ]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'name' => 'required|string',
            ]);

            $dataName = UserAccess::create([
                "name" => $request->name
            ]);

            if($dataName) {
                foreach ($request->permissions as $index => $permission) {
                    MenuAccess::create([
                        "useraccess_id" => $dataName->id,
                        "menu_id" => $index,
                        "is_view" => isset($permission['is_view']) ? true : false,
                        "is_create" => isset($permission['is_create']) ? true : false,
                        "is_update" => isset($permission['is_update']) ? true : false,
                        "is_delete" => isset($permission['is_delete']) ? true : false
                    ]);
                }
            }

            DB::commit();
            return redirect('/useraccess')->with('success', 'User Access berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'name' => 'required|string',
            ]);

            $dataName = UserAccess::where('id', $id)->update([
                "name" => $request->name
            ]);

            if($dataName) {
                foreach ($request->permissions as $index => $permission) {
                    $MenuAccess = MenuAccess::where('useraccess_id', $id)->where('menu_id', $index)->first();
                    if($MenuAccess) {
                        $MenuAccess->update([
                            "is_view" => isset($permission['is_view']) ? true : false,
                            "is_create" => isset($permission['is_create']) ? true : false,
                            "is_update" => isset($permission['is_update']) ? true : false,
                            "is_delete" => isset($permission['is_delete']) ? true : false
                        ]);
                    } else {
                        MenuAccess::create([
                            "useraccess_id" => $dataName->id,
                            "menu_id" => $index,
                            "is_view" => isset($permission['is_view']) ? true : false,
                            "is_create" => isset($permission['is_create']) ? true : false,
                            "is_update" => isset($permission['is_update']) ? true : false,
                            "is_delete" => isset($permission['is_delete']) ? true : false
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect('/useraccess')->with('success', 'User Access berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            DB::beginTransaction();
                MenuAccess::where('useraccess_id', $id)->delete();
                UserAccess::where('id', $id)->delete();
            DB::commit();
            return redirect('/useraccess')->with('success', 'UserAccess berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
