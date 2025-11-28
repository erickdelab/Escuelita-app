<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Campo utilizado para login.
     */
    public function username()
    {
        return 'login_id';
    }

    /**
     * Definimos las credenciales personalizadas
     * Permite login por:
     * - Email (Admins)
     * - Número de Control (Alumnos)
     */
   protected function authenticated(Request $request, $user)
    {
        // 1. Si es ALUMNO, va directo a su dashboard
        if ($user->hasRole('alumno')) {
            return redirect()->route('student.dashboard');
        }

        // 2. Si es ADMIN o PROFESOR, va al home administrativo
        return redirect()->route('home');
    }

    /**
     * Validación del request
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login_id' => 'required|string',
            'password' => 'required|string',
        ]);
    }
}
