<?php

namespace App\Http\Controllers\Api\Cliente;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $verifyEmail = Cliente::where('email', $request->email)->first();

            if ($verifyEmail) {
                return response()->json([
                    'message' => 'Já existe uma conta com esse e-mail.',
                    'error' => true
                ], 400);
            }

            $save = Cliente::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'data' => $save,
                'error' => false
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th,
                'error' => true
            ], 400);
        }
    }

    public function retrieveOne($id)
    {
        $oneClient = Cliente::where('id', $id)->first(['email', 'name']);

        if (is_null($oneClient)) {
            return response()->json([
                'message' => 'Cliente não encontrado.',
                'error' => true
            ], 404);
        }

        return response()->json($oneClient, 200);
    }
}
