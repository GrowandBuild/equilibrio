<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    /**
     * Exibe perfil do usuário
     */
    public function index()
    {
        $usuario = auth()->user();
        $usuarioXp = $usuario->xp;
        $emblemas = $usuario->conquistas()->with('emblema')->get();
        
        return view('perfil.index', compact('usuario', 'usuarioXp', 'emblemas'));
    }

    /**
     * Atualiza informações do perfil
     */
    public function update(Request $request)
    {
        $usuario = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'biografia' => 'nullable|string|max:500',
            'foto' => 'nullable|image|max:2048|mimes:jpg,jpeg,png',
        ]);

        // Upload de foto
        if ($request->hasFile('foto')) {
            // Remove foto antiga se existir
            if ($usuario->foto) {
                Storage::disk('public')->delete($usuario->foto);
            }

            $path = $request->file('foto')->store('fotos-perfil', 'public');
            $validated['foto'] = $path;
        }

        $usuario->update($validated);

        return redirect()->route('perfil.index')
            ->with('success', 'Perfil atualizado com sucesso! ✨');
    }

    /**
     * Atualiza senha
     */
    public function atualizarSenha(Request $request)
    {
        $validated = $request->validate([
            'senha_atual' => 'required',
            'senha_nova' => 'required|min:8|confirmed',
        ]);

        $usuario = auth()->user();

        // Verifica senha atual
        if (!Hash::check($validated['senha_atual'], $usuario->password)) {
            return back()->withErrors(['senha_atual' => 'Senha atual incorreta.']);
        }

        $usuario->update([
            'password' => Hash::make($validated['senha_nova']),
        ]);

        return redirect()->route('perfil.index')
            ->with('success', 'Senha atualizada com sucesso! 🔐');
    }

    /**
     * Remove foto
     */
    public function removerFoto()
    {
        $usuario = auth()->user();

        if ($usuario->foto) {
            Storage::disk('public')->delete($usuario->foto);
            $usuario->update(['foto' => null]);
        }

        return redirect()->route('perfil.index')
            ->with('success', 'Foto removida com sucesso!');
    }
}

