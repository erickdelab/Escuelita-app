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

    // 1. Definimos que el campo del formulario HTML se llama 'login_id'
    public function username()
    {
        return 'login_id';
    }

    // 2. Sobrescribimos este método para buscar en la columna correcta según el dato ingresado
    protected function credentials(Request $request)
    {
        $login = $request->input($this->username());

        // A. Si es un correo electrónico, buscamos en 'email'
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } 
        // B. Si es numérico (ej. 19222128), asumimos que es Alumno -> 'n_control_link'
        elseif (is_numeric($login)) {
            $field = 'n_control_link';
        } 
        // C. Si no es correo ni número (ej. CAMOTO1), es Profesor -> 'n_trabajador_link'
        else {
            $field = 'n_trabajador_link';
        }

        return [
            $field => $login,
            'password' => $request->input('password'),
        ];
    }

    // 3. Tu lógica de redirección (se mantiene igual)
    protected function authenticated(Request $request, $user)
    {
        if ($user->hasRole('alumno')) {
            return redirect()->route('student.dashboard');
        }
        return redirect()->route('home');
    }
    
    // 4. Validación (se mantiene igual)
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login_id' => 'required|string',
            'password' => 'required|string',
        ]);
    }
}