<?php

namespace App\Http\Controllers\Api\Radios;

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
        $getAlls = RadiosPortateis::all()->map(function ($item) {
            $item->imagem = Storage::url('') . $item->imagem;
            return $item;
        });

        return response()->json([
            'data' => $getAlls,
            'error' => false
        ], 200);
    }

    public function uploadImage($request)
    {
        if ($request->hasFile('imagem')) {
            if ($request->file('imagem')->isValid()) {

                $request->validate([
                    'imagem' => 'mimes:jpeg,jpg,png|max:2048',
                ]);

                $path = $request->file('imagem')->store('upload');

                return $path;
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
                'imagem' => $this->uploadImage($request)
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

            Storage::delete($content->imagem);

            $content->update([
                'patrimonio' => $request->patrimonio,
                'radio_modelo' => $request->radio_modelo,
                'numero_serie' => $request->numero_serie,
                'regiao' => $request->regiao,
                'responsavel' => $request->responsavel,
                'instalacao' => $request->instalacao,
                'imagem' => $this->uploadImage($request),
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

            $pathImage = RadiosPortateis::where('id', $id)->first(['id', 'imagem']);

            Storage::delete($pathImage->imagem);

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
