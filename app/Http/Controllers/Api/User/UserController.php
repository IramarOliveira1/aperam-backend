<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getAll = User::all();

        return response()->json(['data' => $getAll, 'error' => false], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $verifyEmail = User::where('email', $request->email)->first();

            if ($verifyEmail) {
                return response()->json([
                    'message' => 'Já existe uma conta com esse e-mail.',
                    'error' => true
                ], 400);
            }

            $save = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role ? $request->role : 'NORMAL',
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

    public function show($id)
    {
        $oneUser = User::where('id', $id)->first(['email', 'name', 'role']);

        if (is_null($oneUser)) {
            return response()->json([
                'message' => 'Cliente não encontrado.',
                'error' => true
            ], 404);
        }

        return response()->json($oneUser, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $validate =  Validator::make($request->all(), [
                'email' => [
                    Rule::unique('users', 'email')->ignore($id),
                ],
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'message' => $validate->errors(),
                    'error' => true
                ], 400);
            }

            $content = User::find($id);
            $content->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role ? $request->role : 'NORMAL',
                'updated_at' => now()
            ]);

            return response()->json([
                'data' => $content,
                'error' => false
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error' => true
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            User::destroy($id);

            return response()->json([
                'message' => 'Usuário excluido com sucesso! ',
                'error' => false
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error' => true
            ], 400);
        }
    }
}
