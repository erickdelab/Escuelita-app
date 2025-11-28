<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 1. Mostrar el formulario
    public function show()
    {
        return view('auth.passwords.change');
    }

    // 2. Procesar el cambio
    public function update(Request $request)
    {
        // Validaciones
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed', // 'confirmed' busca new_password_confirmation
        ]);

        $user = Auth::user();

        // Verificar que la contraseña actual sea correcta
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        // Actualizar contraseña
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', '¡Contraseña actualizada correctamente!');
    }
}