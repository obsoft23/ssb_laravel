<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;




class ConversationController extends Controller
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
    public function create(Request $request)
    {
        //
        $rules = [
            'business_id' => 'required|int',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) 
            {
            return response()->json($validator->errors(), 400);
        // return $validator->errors();
            exit();
        }


        $data = [
            "from_user_id"=>auth()->user()->id,
            "business_account_id"=>$request->business_id,
            "blocked" => 0,
            "holding_conversation_id" => Str::random(30),
        ];
      
            $success = Conversation::updateOrCreate([ 'business_account_id'   => $request->business_id], $data);
            if($success){
                return response()->json($success, 200);
            } else{
                return response()->json($success, 400);
                exit();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversation $conversation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conversation $conversation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversation $conversation)
    {
        //
    }

    public function chat_list(Request $request){

        $list =  DB::table('business_accounts')
        ->select('*')
        ->join('conversations','conversations.business_account_id','=','business_accounts.business_account_id')
        ->where(['conversations.from_user_id' => auth()->user()->id,])
        ->orderBy("conversations.updated_at", "desc")
        ->get();

        return response()->json($list);


    }
}
