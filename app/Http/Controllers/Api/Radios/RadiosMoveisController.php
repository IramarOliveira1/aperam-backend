<?php

namespace App\Http\Controllers\Api\Radios;

use App\Http\Controllers\Controller;
use App\Models\RadiosMoveis;
use Illuminate\Http\Request;

class RadiosMoveisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alls = RadiosMoveis::all();

        return response()->json([
            'data' => $alls,
            'error' => false
        ], 200);
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
            $save = RadiosMoveis::create($request->all());

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $filter = RadiosMoveis::where('patrimonio', $request->query('patrimonio'))
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

            $content = RadiosMoveis::find($id);
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
            RadiosMoveis::destroy($id);

            return response()->json([
                'message' => 'Rádio móvel excluido com sucesso! ',
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
