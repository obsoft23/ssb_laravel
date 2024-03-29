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
        $vocations = Vocations::where('is_available', 1)->orderBy('created_at', 'DESC')->get();
        if($vocations){
            return response()->json($vocations, 200);
        } else {
            return response()->json($vocations, 403);
        }
       
        
    }

    public function vocation_photo($url){
        return response()->file(public_path("/storage/app_pictures/".$url));
        exit();
    }

   
}
