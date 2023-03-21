<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login () {

        // REQUISIÇÃO EMAIL E SENHA PARA LOGIN 
        $credentials = request()->validate([
            'email' => ['required', 'email'], 
            'password' => ['required'], 
        ]);

        
        $user = User::query()
        ->firstWhere('email', $credentials['email']);
        
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email.combination' => 'combinação de email ou senha inválidos'
            ]);
        }

        $token = $user->createToken(request()->userAgent())->plainTextToken;

        return response()->json(compact('token'));

    }

	public function logout(Request $request) {

        // DELETA TOKEN DE ACESSO
		$current_token = $request->user()->currentAccessToken();

		// Revoke the token that was used to authenticate the current request...
		if ($current_token)
			$current_token->delete();

		return response(null, 204);
	}
}
