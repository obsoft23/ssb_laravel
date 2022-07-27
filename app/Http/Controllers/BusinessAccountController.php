<?php

namespace App\Http\Controllers;

use App\Imports\BusinessAccountImport;
use App\Models\BusinessAccount;
use App\Models\BusinessAccountImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Vocations;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Maatwebsite\Excel\Facades\Excel;

class BusinessAccountController extends Controller
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
         //validate  "house_no"=> 'required|string',
         $rules = [

        "business_name" => 'required|string:max:35',
        "business_descripition"=> 'required|string',
        "opening_time"=> 'required',
        "closing_time"=> 'required',
        "email"=> 'required|string',
        "phone"=> 'required|string',
        "business_sub_category"=> 'required|string',
        "full_address"=> 'required|string',
        "postal_code"=> 'required|string',
        "city_or_town"=> 'required|string',
        "county_locality"=> 'required|string',
        "country_nation"=> 'required|string',
        "latitude"=> 'required',
        "longtitude"=> 'required',
        "active_days"=> 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), 400);
           // return $validator->errors();
            exit();
        }
        //create account
            $user = auth()->user()->id;
            
        $find_user = User::find(auth()->user()->id);
        $zero = 0;
        if($find_user->has_professional_acc == $zero){
            $data = [
                "user_id" => $user,
                "business_name" => $request->business_name,
                "business_descripition"=> $request->business_descripition,
                "opening_time"=> date("H:i", strtotime($request->opening_time)),
                "closing_time"=> date("H:i", strtotime($request->closing_time)),
                "email"=> auth()->user()->email,
                "phone"=> $request->phone,
                "business_sub_category"=> $request->business_sub_category,
                "full_address"=> $request->full_address,
                "house_no"=> $request->house_no,
                "postal_code"=> $request->postal_code,
                "city_or_town"=> $request->city_or_town,
                "county_locality"=> $request->county_locality,
                "country_nation"=> $request->country_nation,
                "latitude"=> $request->latitude,
                "longtitude"=> $request->longtitude,
                "active_days"=> $request->active_days,
        
            ];
            $business_user = BusinessAccount::create($data); 
            $find_user = User::find(auth()->user()->id);
            $value = '1';
            $update_professional_status = $find_user->update(["has_professional_acc" => $value]);
          
          

            
            if($update_professional_status == true){
                $update_professional_status = 1;
                $update_users_business_id_column = $find_user->update(["business_id" => $business_user->id]);
                $response = [ 'business_user_id' => $business_user->id, "has_professional_acc" => $update_professional_status, "account_status"=> "Account succesffuly created", "update_users_business_id_column" => $update_users_business_id_column ];

                return response()->json($response);
                exit();
            } else{

            }
            
        } else{
            $response = [ 'message' => "account already exists" ];
            return response()->json($response, 400);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       //
        $business_profile = BusinessAccount::where('business_account_id', '=', $id)->get();
        $images = BusinessAccountImage::where('business_id', '=', $id)->get(["image_name", "image_order_index"]);

        return response()->json(["profile" => $business_profile, "images" => $images]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function fetchBusinessPhotos(Request $request, $business_id){
       // return response()->json(["here is the business_id" => $business_id ]);
       $images = BusinessAccountImage::where('business_id', '=', $business_id)->get(["image_name", "image_order_index"]);
     
       return response()->json($images);
    }


    public function business_profile_pictures($url){
        // return response()->json([ "image" => asset("public/profilepictures/". auth()->user()->image) ] );
        return response()->file(public_path("/storage/business_images/".$url));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      //  return response()->json([$id ]);
      $rules = [
        'business_id' => 'required|int',
        'index' => 'required|int'
        ];

        $validator = Validator::make($request->all(), $rules);

       if($validator->fails()) 
         {
         return response()->json($validator->errors(), 400);
       // return $validator->errors();
        exit();
       }

       $image = BusinessAccountImage::where('business_id', '=', $request->business_id)->where( "image_order_index", '=', $request->index)->delete();

     //  $delete =  $image->delete();
     
       return response()->json(["success" => $image]);

    }

   

    public function managePhotos(Request $request) {
        //'required|image:jpeg,png,jpg,gif,svg|max:2048'
      // return response()->json(["request sent" => $request->file('image') ]);
      // return response()->json(["request sent" => $request->business_id ]);
      
        

        $rules = [
        'image' => 'required|image:jpeg,png,jpg',
        'filename' => 'required|String',
        'index' => 'required|int',
        'business_id' => 'required|int'
        ];

        $validator = Validator::make($request->all(), $rules);

       if($validator->fails()) 
         {
         return response()->json($validator->errors(), 400);
        exit();
       }
       if($request->index  > 4){
        return response()->json("upload not authorised");
        exit();
       }

        $file = $request->file('image');
        $hashname =  $request->file('image')->hashName(); 
        $name = time(). $hashname;
       
        $images = BusinessAccountImage::where('business_id', '=', auth()->user()->business_id)->get(["business_id"]);
        $count = $images->count();
        
      // return response()->json($images);
     
       
        if($count <= 4 ){
           
           if($count != 0){
              
            //  $images = $request->index;
              $user = auth()->user()->business_id;
              if($user == $request->business_id){
                $success = BusinessAccountImage::where('business_id', '=', auth()->user()->business_id)->where( "image_order_index", '=', $request->index)->update(array('image_name' => $name));
               

                if($success == 0) {
                 $success =    BusinessAccountImage::create(
 
                     [
                         "business_id" => $request->business_id,
                         "image_name" => $name,
                         "image_order_index" => $request->index,
                 
                     ],
                 );

                        if($request->index == 1){
                            $update_acc_image_name = BusinessAccount::where('business_account_id', '=', auth()->user()->business_id)->update(["acc_main_image" => $name]);
                        }
                 
                
                }

                if($request->index == 1){
                $update_acc_image_name = BusinessAccount::where('business_account_id', '=', auth()->user()->business_id)->update(["acc_main_image" => $name]);
               }

                $file->storeAs('public/business_images/', $name,   ['disk' => 'local'] );
                return response()->json( ["sucessfully_updated"  => $success, 'acc_image' => $update_acc_image_name ] );
                exit();  
              }/* else {
               // return response()->json("Fef");

               $success = BusinessAccountImage::where('business_id', '=', $request->business_id)->where( "image_order_index", '=', $request->index)->update(array('image_name' => $name));
               if($success == 0) {
                $success =    BusinessAccountImage::create(

                    [
                        "business_id" => $request->business_id,
                        "image_name" => $name,
                        "image_order_index" => $request->index,
                
                    ],
                );
               }
                $file->storeAs('public/business_images/', $name,   ['disk' => 'local'] );
                return response()->json( ["sucessfully_updated"  => $success ] );
                exit();
               
              }*/
             // return response()->json($images);
                 
           } else {
            $success =    BusinessAccountImage::create(

                [
                    "business_id" => $request->business_id,
                    "image_name" => $name,
                    "image_order_index" => $request->index,
            
                ],
            );
            if($request->index == 1){
                $update_acc_image_name = BusinessAccount::where('business_account_id', '=', auth()->user()->business_id)->update(["acc_main_image" => $name]);
              }

            $file->storeAs('public/business_images/', $name,   ['disk' => 'local'] );
            return response()->json( ["sucessfully_updated"  => $success , "acc_updated" => $update_acc_image_name] );
            exit();   
           }
           
        }
       
        
    }

    public function active_days(Request $request){
        $rules = [
            "active_days"=> 'array|required',
            'business_id'=> 'int|required'
            ];


        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), 400);
           // return $validator->errors();
            exit();
        }

        $success = BusinessAccount::where('business_account_id', '=', auth()->user()->business_id)->update(array('active_days' => $request->active_days,));

        return response()->json(["success" => $success]);

    }
    

    public function update_address(Request $request){
        $rules = [
            "business_id" => 'int|required',
            "full_address"=> 'string',
            "postal_code"=> 'string',
            "city_or_town"=> 'required|string',
            "county_locality"=> 'string',
            "country_nation"=> 'required|string',
            "latitude"=> 'required',
            "longtitude"=> 'required',
            ];


        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), 400);
           // return $validator->errors();
            exit();
        }

        $data = [
            "full_address"=> $request->full_address,
            "house_no"=> $request->house_no,
            "postal_code"=> $request->postal_code,
            "city_or_town"=> $request->city_or_town,
            "county_locality"=> $request->county_locality,
            "country_nation"=> $request->country_nation,
            "latitude"=> $request->latitude,
            "longtitude"=> $request->longtitude,
        ];
       
        $success = BusinessAccount::where('business_account_id', '=', auth()->user()->business_id)->update($data);

        return response()->json(["success" => $success]);
    }

    public function update_details(Request $request){

        $rules = [
            "business_descripition"=> 'string',
            "phone"=> 'required|string',
            "business_sub_category"=> 'required|string',
            "business_id" => 'required|int'
            ];


        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), 400);
           // return $validator->errors();
            exit();
        }
        $vocation_id = Vocations::where('vocations', '=', $request->sub_category)->get(["id"]);
        
        $data = [
            "business_descripition"=> $request->business_descripition,
            "phone"=> $request->phone,
            "vocation_id"=> $vocation_id,
            "business_sub_category"=> $request->business_sub_category,
        ];
        

        $success = BusinessAccount::where('business_account_id', '=', auth()->user()->business_id)->update($data);

        return response()->json(["success" => $success]);

    }

    

    public function getVocations(Request $request){

        $rules = [
            "country"=> 'required|string',
            "town" => 'required|string',
            "sub_category"=> 'required|string',
            
        ];


        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), 400);
           // return $validator->errors();
            exit();
        }

        $category = $request->sub_category;
        
       // $business_profiles = BusinessAccount::where('business_sub_category', '=', $category)->where("city_or_town", '=', $request->town)->get();
        $business_profiles = BusinessAccount::where('business_sub_category', '=', $category)->get();
       
        if($business_profiles->count() < 1){
            return response()->json(["success" => 0]);
           exit();
        }

        return response()->json($business_profiles);
        exit();

    }


    public function upload_business_acc(Request $request){
          // set_time_limit(600);
          $success = Excel::import(new BusinessAccountImport, $request->file('business') );
          return response()->json($success);
    }

    public function update_hours(Request $request){
      //  return response()->json(auth()->user()->business_id);
        $rules = [
            "opening_time"=> 'required',
            "closing_time"=> 'required',
            "business_id" => 'required|int'
        ];


        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), 400);
           // return $validator->errors();
            exit();
        }

        $data = [
            "opening_time"=> date("H:i", strtotime($request->opening_time)),
            "closing_time"=> date("H:i", strtotime($request->closing_time)),      
        ];
      //  return response()->json($data);

        $success = BusinessAccount::where('business_account_id', '=', auth()->user()->business_id)->update($data);

        return response()->json(["success" => $success]);

    }
}
