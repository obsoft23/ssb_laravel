<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\BusinessAccount;
use App\Models\Notification;
use App\Models\User;




class LikesController extends Controller
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
            'user_id' => 'required|int',
            'like' => 'int'
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
           if($validator->fails()) 
             {
             return response()->json($validator->errors(), 400);
           // return $validator->errors();
            exit();
           }

           $data = [
            "business_id" => $request->business_id,
            "user_id" => $request->user_id,
           ];

           $find =  Likes::where("business_id" , '=', $request->business_id)->where("user_id", $request->user_id)->count();
           $to_user_id =  User::where('business_id', '=', $request->business_id)->get([
            "id"
           ]);
          
            if($find == 0){
                $like = Likes::updateOrCreate($data);
            
                $total_likes =  Likes::where("business_id" , '=', $request->business_id)->count();
                $fetch_business_acc = BusinessAccount::where('business_account_id', '=', $request->business_id)->update(["likes" => $total_likes]);
               /* $create_notification = Notification::updateOrCreate([
                  
                    "notifications" => "New Like -  business account just got a like",
                    "user_id" =>  $to_user_id,
                    "to_user_id" => auth()->user()->id,
                    "business_account_id" => $request->business_id,
                    "read" => "0",
                ]);*/
             
                return response()->json([ "update_like_column_in_business_acc" => $fetch_business_acc]);
            } else {

                $delete_like =  Likes::where("business_id" , '=', $request->business_id)->where("user_id", $request->user_id)->delete();
                $total_likes =  Likes::where("business_id" , '=', $request->business_id)->count();
                $fetch_business_acc = BusinessAccount::where('business_account_id', '=', $request->business_id)->update(["likes" => $total_likes]);

              

            
               /* $create_notification = Notification::updateOrCreate([
                  
                    "notifications" => "New Like -  business account just got a like",
                    "user_id" =>  $to_user_id,
                    "to_user_id" => auth()->user()->id,
                    "business_account_id" => $request->business_id,
                    "read" => "0",
                ]);*/
             
                return response()->json([ "update_like_column_in_business_acc" => $fetch_business_acc, "delete_like" => $delete_like]);
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
     * @param  \App\Models\Likes  $likes
     * @return \Illuminate\Http\Response
     */
    public function show(Likes $likes, Request $request)
    {
        //
        $rules = [
            'business_id' => 'required|int',
            'user_id' => 'required|int',
           
        ];
    
            $validator = Validator::make($request->all(), $rules);
    
           if($validator->fails()) 
             {
             return response()->json($validator->errors(), 400);
           // return $validator->errors();
            exit();
           }

           $data = [
            "business_id" => $request->business_id,
            "user_id" => $request->user_id,
           ];

           $find =  Likes::where("business_id" , '=', $request->business_id)->where("user_id", $request->user_id)->count();

           if($find > 0){
            $success = true;
           } else{
            $success = false;
           }

           return response()->json($success);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Likes  $likes
     * @return \Illuminate\Http\Response
     */
    public function edit(Likes $likes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Likes  $likes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Likes $likes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Likes  $likes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Likes $likes)
    {
        //
    }

   
}
