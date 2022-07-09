<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\VocationImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Vocations;



class VocationsController extends Controller
{
    //

    public function vocations(Request $request){
        $success = Excel::import(new VocationImport, $request->file('vocations') );
        return response()->json($success);
    }

    public function getVocations(Request $request){
        $vocations = Vocations::all();
        return response()->json($vocations);
        
    }
}
