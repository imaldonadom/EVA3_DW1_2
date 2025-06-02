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
        // Validar datos
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

        // Obtener usuario
        $usuario = Usuario::where('correo', $request->correo)->first();

        if (!$usuario || !Hash::check($request->clave, $usuario->clave)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        // Generar token
        $token = JWTAuth::fromUser($usuario);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'usuario' => $usuario
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['mensaje' => 'Sesión cerrada correctamente']);
    }

    public function refresh()
    {
        return response()->json([
            'access_token' => auth()->refresh(),
            'token_type' => 'bearer',
        ]);
    }
}
