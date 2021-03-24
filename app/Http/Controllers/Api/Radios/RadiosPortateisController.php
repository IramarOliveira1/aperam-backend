<?php

namespace App\Http\Controllers\Api\Radios;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\RadiosPortateis;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class RadiosPortateisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alls = RadiosPortateis::all();

        return response()->json([
            'data' => $alls,
            'error' => false
        ], 200);
    }

    public function uploadFile($request)
    {
        if ($request->hasFile('imagem')) {
            if ($request->file('imagem')->isValid()) {

                $request->validate([
                    'imagem' => 'mimes:jpeg,png|max:2048',
                ]);

                $extension = $request->imagem->extension();

                $path = $request->imagem->storeAs('/upload', Str::random(15) . "." . $extension);

                $url = Storage::url($path);

                return $url;
            }
        }
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
            $save = RadiosPortateis::create([
                'patrimonio' => $request->patrimonio,
                'radio_modelo' => $request->radio_modelo,
                'numero_serie' => $request->numero_serie,
                'regiao' => $request->regiao,
                'responsavel' => $request->responsavel,
                'instalacao' => $request->instalacao,
                'imagem' => $this->uploadFile($request),
            ]);

            return response()->json([
                'data' => $save,
                'error' => false
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'error' => true
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

            $content = RadiosPortateis::find($id);
            $content->update($request->all());

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
            RadiosPortateis::destroy($id);

            return response()->json([
                'message' => 'Rádio portáteis excluido com sucesso! ',
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
