<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;




class ReviewController extends Controller
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
                "review" => 'required|string',  
                
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
           if($validator->fails()) 
             {
             return response()->json($validator->errors(), 400);
           // return $validator->errors(); "rating" => 'required|int',
            exit();
           }

           $data = [
            "business_account_id" => $request->business_id,
            "reviewer_id" => $request->user_id,
            "review" => $request->review,
            "rating" => $request->rating,
           ];
           
           $success= Review::create($data);
           if($success){
           /* $create_notification = Notification::updateOrCreate([
               // [ "notifications" => "Welcome to Vivagram - New User Welcome Notification ",],
                "notifications" => "New Review added -  $request->review",
                "user_id" => auth()->user()->id,
                "business_account_id" => $request->business_id,
                "read" => "0",
            ]);*/
        
            return response()->json(true,200);
           } else{
            return response()->json(false,400);
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
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
      /*  $user =  DB::table('users')
        ->select('users.id','users.name','users.image')
        ->join('reviews','reviewer_id','=','users.id')
        ->where(['business_account_id' => $id,])
     
        ->get();*/
        $id = (int) $id;
        $user =  DB::table('users')
        ->select('users.id','users.name','users.image')
        ->join('reviews','reviewer_id','=','users.id')
        ->where(['business_account_id' => $id,])
        ->orderBy('created_at', 'DESC')->get();

       $success = Review::where('business_account_id', '=', $id)->get();
      
       return response()->json(["reviews" => $success, "user" => $user]);


    }

    public function show_some($id){
         $id = (int) $id;
         $user =  DB::table('users')
        ->select('users.id','users.name','users.image')
        ->join('reviews','reviewer_id','=','users.id')
        ->where(['business_account_id' => $id,])
        ->orderBy('created_at', 'DESC')->get();


       $success = Review::where('business_account_id', '=', $id)->get();

       return response()->json(["reviews" => $success, "user" => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $rules = [
            'business_id' => 'required|int',
            'user_id' => 'required|int',
            'review_id' => 'required|int',
            
        ];

        $validator = Validator::make($request->all(), $rules);

       if($validator->fails()) 
         {
         return response()->json($validator->errors(), 400);
       // return $validator->errors();
        exit();
       }
     
            $delete_review =  Review::where("id" , '=', $request->review_id)->where("reviewer_id", auth()->user()->id)->delete();
        return response()->json(["delete_review" => $delete_review]);
       

       
    }

    
}
