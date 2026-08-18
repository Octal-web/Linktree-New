<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class UsuariosController extends Controller
{
    public function login(): Response|HttpFoundationResponse
    {
        if (Auth::user()) {
            return Inertia::location(route('Manager.Home.index'));
        }

        return Inertia::render('Manager/Usuarios/login');
    }

    public function autenticar(LoginRequest $request): RedirectResponse
    {
        $data = $request->validated();
        try {
            if (Auth::attempt($data)) {
                $request->session()->regenerate();

                return redirect()->intended(route('manager/home'));
            }

            return back()->with('message', [
                'type' => 'error',
                'msg' => 'Credenciais inválidas.',
            ]);
        } catch (\Exception $e) {
            return back()->with('message', [
                'type' => 'error',
                'msg' => 'Erro interno ao realizar login.',
            ]);
        }
    }

    public function logout(Request $request): HttpFoundationResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Inertia::location(route('Manager.Usuarios.login'));
    }
}
