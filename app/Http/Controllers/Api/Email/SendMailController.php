<?php

namespace App\Http\Controllers\Api\Email;

date_default_timezone_set('America/Sao_Paulo');

use App\Models\Cliente;
use App\Mail\AperamMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class SendMailController extends Controller
{
    public function sendMail(Request $request)
    {
        try {

            $validate = Cliente::where('email', $request->email)->first();

            if (empty($validate)) {
                return response()->json([
                    'message' => 'E-mail não registrado no site.',
                    'error' => true
                ], 404);
            }

            Mail::to($validate->email)->send(new AperamMail(Crypt::encrypt($validate->id), $validate->name));

            return response()->json(['message' => 'Email enviado com sucesso'], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error' => true
            ], 400);
        }
    }

    public function verifyToken($token, $status = false)
    {
        try {
            $decryptToken = Crypt::decrypt($token);

            $response = Cliente::where('id', $decryptToken)->first('id');

            return $status == false ? ['statusCode' => 200] : $response;
        } catch (DecryptException  $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error' => true
            ], 400);
        }
    }

    public function changePassword(Request $request, $token)
    {
        $response = $this->verifyToken($token, true);

        if (!isset($response->id)) {
            return $response;
        }

        $cliente = Cliente::find($response->id);

        $cliente->update([
            'password' => Hash::make($request->password),
            'updated_at' => date('d-m-Y')
        ]);

        return response()->json([
            'message' => 'Senha alterada com sucesso!',
            'error' => false
        ], 200);
    }
}
