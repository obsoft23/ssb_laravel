<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CategoryImport;
use Maatwebsite\Excel\Facades\Excel;


class CategoryController extends Controller
{
    //

    public function index(Request $request){
     $success = Excel::import(new CategoryImport, $request->file('category_file') );
     return response()->json($success);
     exit();
    }
}
