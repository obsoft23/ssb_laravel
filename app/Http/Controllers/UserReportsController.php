<?php

namespace App\Http\Controllers;

use App\Models\UserReports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\SupportMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;


class UserReportsController extends Controller
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
            'topic' => 'required|string',
            'description' => 'required|string',
            'reported_business_acc' => 'required|int',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), 400);
            exit();
        }
        //create account

        $user = User::find(1);

        $data = [
            "name" => auth()->user()->name,
            "email" => auth()->user()->email,
            "query_topic" => $request->topic,
            "query_description" => $request->description,
           
        ];

        $success = UserReports::create([
            "query_topic" => $request->topic,
            "query_description" => $request->description,
            "user_id" => auth()->user()->id,
            "business_account_id" =>  $request->reported_business_acc
        ]);

        $email = Mail::to($user)->send(new SupportMail($data));
        return response()->json($email, 200);
        if($email){
            return response()->json($email, 200);
        } else{
            return response()->json($email, 400);
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
     * @param  \App\Models\UserReports  $userReports
     * @return \Illuminate\Http\Response
     */
    public function show(UserReports $userReports)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserReports  $userReports
     * @return \Illuminate\Http\Response
     */
    public function edit(UserReports $userReports)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserReports  $userReports
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserReports $userReports)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserReports  $userReports
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserReports $userReports)
    {
        //
    }
}
