<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Notification;





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
            'to_user_id' => 'required|int',
            'business_id' => 'required|int',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) 
            {
            return response()->json($validator->errors(), 400);
        // return $validator->errors(); [ 
              //  'business_account_id'   => $request->business_id, "from_user_id" => auth()->user()->id  ]
            exit();
        }

            $success = Conversation::updateOrCreate(
                [   'to_user_id' => $request->to_user_id ,"from_user_id" => $request->from_user_id],  
                 [
                "from_user_id"=> auth()->user()->id,
                "to_user_id" => $request->to_user_id,
                "business_account_id"=> $request->business_id,
                "blocked" => 0,
                "read" => 0,
                "holding_conversation_id" => Str::random(30),
            ]);
        
            if(auth()->user()->business_id != null){
                $success = Conversation::updateOrCreate(
                    [   'from_user_id'   =>   $request->to_user_id , "to_user_id" =>$request->from_user_id, ],  
                     [
                    "from_user_id"=>  $request->to_user_id,
                    "to_user_id" => auth()->user()->id,
                    "business_account_id"=> auth()->user()->business_id,
                    "blocked" => 0,
                    "read" => 0,
                    "holding_conversation_id" => Str::random(30),
                ]);
            } else {
                $success = Conversation::updateOrCreate(
                    [   'from_user_id'   =>   $request->to_user_id , "to_user_id" =>$request->from_user_id, ],  
                     [
                    "from_user_id"=>  $request->to_user_id,
                    "to_user_id" => auth()->user()->id,
                    "business_account_id"=>  $request->business_id,
                    "blocked" => 0,
                    "read" => 0,
                    "holding_conversation_id" => Str::random(30),
                ]);
            }

           
            if($success){

               /* $create_notification = Notification::updateOrCreate([
                    "notifications" => "Conversation -  new conversation iniated with you.",
                    "user_id" => auth()->user()->id,
                    "business_account_id" => $request->business_id,
                    "read" => "0",
                ]);*/

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

        $rules = [
            'from_user_id' => 'required|int',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) 
            {
            return response()->json($validator->errors(), 400);
        // return $validator->errors();
            exit();
        }
        $from_user_id = (int)$request->from_user_id;
       //WHERE  `conversations`.`from_user_id` = auth()->user()->id,  `business_accounts`.`business_account_id`
       /*  $find = DB::select( DB::raw("SELECT * FROM conversations WHERE `conversations`.`from_user_id` = $from_user_id OR `conversations`.`business_account_id` = $from_user_id INNER JOIN  `business_accounts` ON    `conversations`.`business_account_id` =  $from_user_id  ORDER BY  `conversations`.`created_at` DESC ")); AND `conversations`.`from_user_id` = '$request->to_user_id'

       $find = DB::select( DB::raw("SELECT * FROM conversations INNER JOIN business_accounts ON `conversations`.`business_account_id =  `business_accounts`.`business_account_id INNER JOIN users ON `conversations`.`business_account_id =  `business_accounts`.`business_account_id` WHERE `conversations`.`from_user_id` = $from_user_id OR WHERE `conversations`.`to_user_id` = $from_user_id   ORDER BY  created_at DESC "));



       return response()->json($find);*/





        $list =  DB::table('conversations')
        ->select(  "conversations.from_user_id", "conversations.to_user_id", "conversations.holding_conversation_id", "conversations.read", "conversations.blocked", "conversations.most_recent_message", "conversations.business_account_id","business_accounts.business_name", "users.id", "users.email", "users.image", "business_accounts.acc_main_image", "users.name", "users.fullname", "users.has_professional_acc",  "conversations.created_at", "conversations.updated_at")
        ->join('business_accounts','conversations.business_account_id','=','business_accounts.business_account_id')
        ->leftjoin('users', 'users.id','=','conversations.to_user_id')
        ->where(['conversations.to_user_id' => $from_user_id])
        ->OrWhere(['conversations.from_user_id' => $from_user_id])
        ->orderBy("conversations.updated_at", "desc")
        ->get();

       
        return response()->json($list);

    }

    public function update_read(Request $request){ 
        $rules = [
            'chat_id' => 'required',
            'user_id' => 'required|int',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) 
            {
            return response()->json($validator->errors(), 400);
        // return $validator->errors();
            exit();
        }
         
        if($request->user_id == auth()->user()->id){
            $success = Conversation::where('holding_conversation_id','=', $request->chat_id)->update(["read" => '1']);
            if($success){
                return response()->json($success, 200);
            } else {
                return response()->json($success, 400);
            }
        }
       
    }
}
