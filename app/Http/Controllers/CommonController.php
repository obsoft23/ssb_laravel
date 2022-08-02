<?php

namespace App\Http\Controllers;

use App\Models\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = DB::table('vocations')
        ->select('*')
        ->join('commons','commons.vocation_id','=','vocations.id')
       //->where(['commons.vocation_id' => "vocations.id",])
        ->get();
        return response()->json($data);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Common  $common
     * @return \Illuminate\Http\Response
     */
    public function show(Common $common)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Common  $common
     * @return \Illuminate\Http\Response
     */
    public function edit(Common $common)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Common  $common
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Common $common)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Common  $common
     * @return \Illuminate\Http\Response
     */
    public function destroy(Common $common)
    {
        //
    }
}
