<?php

namespace App\Http\Controllers;

use App\Models\chats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ChatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\chats  $chats
     * @return \Illuminate\Http\Response
     */
    public function show(chats $chats, Request $request)
    {
        //
        $rules = [
            'from_user_id' => 'required|int',
            'to_user_id' => 'required|int',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) 
            {
            return response()->json($validator->errors(), 400);
            exit();
        }

       /* $find  = chats::where("to_user_id", $request->to_user_id)
              ->having('from_user_id',"=" ,$request->from_user_id)->Orwhere("to_user_id" , '=', $request->from_user_id)->having('from_user_id', "=" ,$request->to_user_id)->get();  conversations`.`from_user_id`*/
      
          $find = DB::select( DB::raw("SELECT * FROM chats WHERE `chats`.`from_user_id` = '$request->from_user_id' AND `chats`.`to_user_id` = '$request->to_user_id' OR `chats`.`to_user_id` = '$request->from_user_id' AND `chats`.`from_user_id` = '$request->to_user_id' ORDER BY  created_at ASC "));
         
            if($find){
                return response()->json($find,200);
                exit;
            }else {
                return response()->json($find,400);
                exit;
            }
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\chats  $chats
     * @return \Illuminate\Http\Response
     */
    public function edit(chats $chats)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\chats  $chats
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, chats $chats)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\chats  $chats
     * @return \Illuminate\Http\Response
     */
    public function destroy(chats $chats)
    {
        //
    }
}
