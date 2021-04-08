<?php

namespace App\Http\Controllers\Api\Utils;

use App\Http\Controllers\Controller;
use App\Models\RadiosMoveis;
use App\Models\RadiosPortateis;

class GenericController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $radios_portable = RadiosPortateis::all()->count();

        $radios_mobile = RadiosMoveis::all()->count();

        return response()->json([
            'Portable_count' => $radios_portable,
            'Mobile_count' => $radios_mobile,
            'Generic_Radios' => $this->OrderByRadios(),
            'error' => false
        ], 200);
    }

    public function OrderByRadios()
    {
        $radios_portable = RadiosPortateis::orderBy('id', 'DESC')->get()->take(5);

        $radios_mobile = RadiosMoveis::orderBy('id', 'DESC')->get()->take(5);

        return ['Portable' => $radios_portable, 'Mobile' => $radios_mobile];
    }
}
