<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;



class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($favourite)
    {
        //
        $user =  DB::table('users')
        ->select('users.id','users.name','users.image')
        ->join('reviews','reviewer_id','=','users.id')
        ->where(['business_account_id' => $favourite,])
        ->get();

       $success = Favourite::where('business_account_id', '=', $favourite)->get();

       return response()->json(["reviews" => $success, "user" => $user]);
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
            "deleted_status" => 0,
           ];
           
        $find = Favourite::where("business_id" , "=" ,$request->business_id)->where("user_id", $request->user_id)->first();
       //  return response()->json($find == null ? "nukk" : "not null");
       
        if($find == null){
            /*$to_user_id =  User::where('business_id', '=', $request->business_id)->get([
                "id"
               ]);
 $create_notification = Notification::updateOrCreate([
                  
                    "notifications" => "New Like -  business account just got a like",
                    "user_id" =>  $to_user_id,
                    "to_user_id" => auth()->user()->id,
                    "business_account_id" => $request->business_id,
                    "read" => "0",
                ]);*/

            $success = Favourite::updateOrCreate($data);
            return response()->json($success);
           
        } else{
          
            if($find->deleted_status == 0){
                $find->update(["deleted_status" => 1]);
                return response()->json(true);
            } else {
                $find->update(["deleted_status" => 0]);
                return response()->json(false);
            }
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
     * @param  \App\Models\Favourite  $favourite
     * @return \Illuminate\Http\Response
     */
    public function show(Favourite $favourite)
    {

       // $find =  Favourite::where("business_id" , '=', $request->business_id)->where("user_id", "=", auth()->user()->id,)->get();
      $favourite =  DB::table('business_accounts')
       ->select('*')
       ->join('favourites','business_id','=','business_account_id')
       ->where(['favourites.user_id' => auth()->user()->id,])
       ->where('deleted_status', '=', 0)
       ->get();
       
      // $favourite->orderBy("created_at", "DESC");
      // $find =  Favourite::where("user_id", "=", auth()->user()->id,)->get();
      $count = $favourite->count();
      if($count > 0){
        return response()->json($favourite);
        exit;
      } else {
        return response()->json($count);
      }
       
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Favourite  $favourite
     * @return \Illuminate\Http\Response
     */
    public function edit(Favourite $favourite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Favourite  $favourite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favourite $favourite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Favourite  $favourite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favourite $favourite)
    {
        //
    }

    public function confirmFav(Request $request){
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

        $find =  Favourite::where("business_id" , '=', $request->business_id)->where("user_id", $request->user_id)->where("deleted_status", 0)->count();
      
           if($find > 0){
            $success = true;
           } else{
            $success = false;
           }

           return response()->json($success);
    }

    public function showChats(){ 
        $favourite =  DB::table('business_accounts')
        ->select('*')
        ->join('favourites','business_id','=','business_account_id')
        ->where(['favourites.user_id' => auth()->user()->id,])
        ->get();

        $count = $favourite->count();
        if($count > 0){
            return response()->json($favourite);
            exit;
        } else {
            return response()->json($count);
         }
        


        }
}
