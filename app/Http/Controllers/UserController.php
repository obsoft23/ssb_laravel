<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use App\Models\BusinessAccount;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;




class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $rules = [
            'email' => 'required|email',
            'password' => 'required|String'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('email', $request->email)->first();
     
            if($user && Hash::check($request->password, $user->password) ){
                $token = $user->createToken('personal access token')->plainTextToken;
                $response = [ 'user' => $user, 'token' => $token ];
                return response()->json($response, 200);
            } else {
                $error = ['message' => 'Incorrect Username or Password'];
                return response()->json($error, 400);
            }
        
        
       
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
        if ($request->hasFile('image')){  
           
        }  
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
     $response = [ "user" => auth()->user() ];
     //$response = [ auth()->user() ];
      return response()->json(auth()->user() );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        $rules = [
            'newPassword' => 'required|String|min:4',
            'id' => 'required|Int'
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), 400);
               // return $validator->errors();
            exit();
        }

        $user = User::find($request->id);
        $success = $user->update(["password" => Hash::make($request->newPassword)]);

        return response()->json(['success' => $success]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
        'name' => 'required|string',
        'bio' => 'required|string',
        'fullname' => 'required|string',
        'phone' => 'required|numeric',
       
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), 400);
            exit();
        }
       
        $user = User::find(auth()->user()->id);
        $success = $user->update(['name' => $request->name,  'bio' => $request->bio, 'fullname' => $request->fullname, 'phone' => $request->phone ]);

        return response()->json(['success' => $success]);
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function register(Request $request){
       

        //validate
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), 400);
            exit();
        }
        //create account

        $check = User::where('email', $request->email)->count();
        if($check == 0){
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
    
            $token = $user->createToken("personal access token")->plainTextToken;
    
            $response = ['user' => $user, 'token' => $token, 'status' => 200];

            //Mail::to($user)->send(new WelcomeMail($user));
    
            return response()->json($response);
          
        } else {
            $response = ['user' => "email already exits not authorized", 'status' => 500];
            return response()->json($response);
        }
           
        

    }


    public function updateImage(Request $request) {
        //'required|image:jpeg,png,jpg,gif,svg|max:2048'
      //  return response()->json(["request sent" => $request->file('image')->hashName() ]);
        

        $rules = [
        'image' => 'required|image:jpeg,png,jpg',
        'filename' => 'required|String'
        ];

        $validator = Validator::make($request->all(), $rules);

       if($validator->fails()) 
         {
         return response()->json($validator->errors(), 400);
       // return $validator->errors();
        exit();
       }


        $user = User::find(auth()->user()->id);
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $hashname =  $request->file('image')->hashName(); 

        $name = time(). $hashname;//.  '.'. $extension;
        $success = User::where(['id' => $user->id])->update(["image" => $name]);
        $file->storeAs('public/profilepictures/', $name,  ['disk' => 'local']);

        return response()->json( ["success"  => $success ] );
        
    }

    public function user_profile_picture($url){
        // return response()->json([ "image" => asset("public/profilepictures/". auth()->user()->image) ] );
        return response()->file(public_path("/storage/profilepictures/".$url));
    }


    public function upload_user(Request $request){
       // set_time_limit(600);
        $success = Excel::import(new UserImport, $request->file('users') );
        return response()->json($success);
    }

    public function getUserFewDetails($id){

        $find =  BusinessAccount::where('user_id', '=', $id)->count();
        if($find > 0){
            $list =  DB::table('business_accounts')
            ->select(   "business_accounts.business_account_id","business_accounts.business_name", "users.id", "users.email", "users.image", "business_accounts.acc_main_image", "users.name", "users.fullname", "users.has_professional_acc")
            ->join('users', 'business_accounts.user_id','=','users.id')
            ->where(['business_accounts.user_id' => $id])
            ->get();
    
           
            return response()->json($list);
        } else {
           $user = User::find($id);

            return response()->json([$user]);
        }


        
    }


    public function confirmId(){
       $business_id = auth()->user()->business_id;
        if($business_id != null){
            return response()->json(true);
        }

        return response()->json(false);
    }
}
//if($user && Hash::check($request->password, $user->password) 