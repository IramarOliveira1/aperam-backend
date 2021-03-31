<?php

namespace App\Http\Controllers\Api\Radios;

use Illuminate\Http\Request;
use App\Models\RadiosPortateis;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RadiosPortateisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getAll = RadiosPortateis::all()->map(function ($item) {
            $item->imagem = Storage::url('') . $item->imagem;
            return $item;
        });

        return response()->json([
            'data' => $getAll,
            'error' => false
        ], 200);
    }

    public function uploadImage($request)
    {
        if ($request->hasFile('imagem')) {
            if ($request->file('imagem')->isValid()) {

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

            $validator = Validator::make($request->all(), [
                'imagem' => 'mimes:jpeg,jpg,png|max:2048',
            ], [
                'imagem.mimes' => 'A imagem deve ser um arquivo do tipo: jpeg, jpg, png',
                'imagem.max' => 'A imagem não pode ser maior que 2 MB.'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $save = RadiosPortateis::create([
                'patrimonio' => $request->patrimonio,
                'radio_modelo' => $request->radio_modelo,
                'numero_serie' => $request->numero_serie,
                'regiao' => $request->regiao,
                'responsavel' => $request->responsavel,
                'departamento' => $request->departamento,
                'instalacao' => $request->instalacao,
                'imagem' => $this->uploadImage($request)
            ]);

            return response()->json([
                'data' => $save,
                'url' => Storage::url('') . $save->imagem,
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $filter = RadiosPortateis::where('patrimonio', $request->query('patrimonio'))
            ->orWhere('numero_serie', $request->query('numero_serie'))
            ->get();

        if ($filter->isEmpty()) {
            return response()->json([
                'message' => 'Nenhum dado encontrado!'
            ], 404);
        }

        return response()->json($filter, 200);
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

            if ($request->hasFile('imagem')) {

                Storage::delete($content->imagem);

                $content->update([
                    'imagem' => $this->uploadImage($request),
                ]);
            }

            $content->update([
                'patrimonio' => $request->patrimonio,
                'radio_modelo' => $request->radio_modelo,
                'numero_serie' => $request->numero_serie,
                'regiao' => $request->regiao,
                'responsavel' => $request->responsavel,
                'departamento' => $request->departamento,
                'instalacao' => $request->instalacao,
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
