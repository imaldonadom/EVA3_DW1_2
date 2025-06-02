<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'correo' => 'required|email',
            'clave' => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Datos inválidos',
                'detalles' => $validator->errors()
            ], 422);
        }

        $usuario = Usuario::where('correo', $request->correo)->first();

        if (!$usuario || !Hash::check($request->clave, $usuario->clave)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        $token = JWTAuth::fromUser($usuario);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'usuario' => $usuario
        ]);
    }
}
