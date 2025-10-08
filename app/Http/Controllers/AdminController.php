<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.index');
    }

    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasFile('logo')) {
            // Remove logo anterior se existir
            if (Storage::disk('public')->exists('logo.png')) {
                Storage::disk('public')->delete('logo.png');
            }

            // Salva nova logo
            $file = $request->file('logo');
            $filename = 'logo.png';
            $path = $file->storeAs('', $filename, 'public');

            return redirect()->back()->with('success', 'Logo atualizada com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao fazer upload da logo.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Logout realizado com sucesso!');
    }
}
