<?php

namespace App\Http\Controllers\Api\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

            $updateField = [
                'nome' => $request->name,
                'email' => $request->email,
                'senha' => $request->password
            ];

            $validate = Validator::make($updateField, [
                'nome' => 'required',
                'email' => 'required|email|unique:clientes',
                'senha' => 'required'
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'message' => $validate->errors()->messages(),
                    'error' => true
                ], 400);
            }

            $cryptography = Hash::make($request->password);

            $save = Cliente::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $cryptography
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
}
