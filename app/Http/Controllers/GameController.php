<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\SeamlessSetting;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $data = Game::get();
        return view('game.index', [
            'title' => 'Game Lists',
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('game.create', [
            'title' => 'New Game'
        ]);
    }

    public function edit($id)
    {
        $data = Game::where('id', $id)->first();
        return view('game.edit', [
            'title' => 'New Game',
            'data' => $data
        ]);
    }   

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:game,name',
            ]); 
            
            Game::create([
                'name' => $request->name,
                'icon' => isset($request->icon) ? $request->icon : '',
                'status' => isset($request->status) ? 1 : 2
            ]);

            return redirect('/game')->with('success', 'Produk berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|unique:game,name,' . $id,       
            ]); 
           
            $game = Game::findOrFail($id);

            $game->update([
                'name' => $request->name,
                'icon' => isset($request->icon) ? $request->icon : '',
                'status' => isset($request->status) ? 1 : 2
            ]);

            return redirect('/game')->with('success', 'Data perusahaan berhasil diupdate');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            SeamlessSetting::where('game_id', $id)->delete();
            $game = Game::find($id);
            $game->delete();

            return redirect('/game')->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    private function generateRandomString($length = 30) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }   
}
