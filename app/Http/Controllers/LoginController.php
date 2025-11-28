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

    public function username()
    {
        return 'login_id';
    }

    protected function credentials(Request $request)
    {
        $login = $request->input($this->username());

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } elseif (is_numeric($login)) {
            $field = 'n_control_link';
        } else {
            $field = 'n_trabajador_link';
        }

        return [
            $field => $login,
            'password' => $request->input('password'),
        ];
    }

    // ✅ LÓGICA DE REDIRECCIÓN CORREGIDA
    protected function authenticated(Request $request, $user)
    {
        // 1. Si es ALUMNO -> Portal Estudiante
        if ($user->hasRole('alumno')) {
            return redirect()->route('student.dashboard');
        }

        // 2. Si es PROFESOR (y no Admin) -> Portal Docente
        if ($user->hasRole('profesor') && !$user->hasRole('admin')) {
            return redirect()->route('teacher.dashboard');
        }

        // 3. Si es ADMIN o falla lo anterior -> Panel Admin
        return redirect()->route('home');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login_id' => 'required|string',
            'password' => 'required|string',
        ]);
    }
}