<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PreRegistration;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Route;
use SoapClient;
use App\History;
use App\Division;

class PreRegistrationController extends Controller
{

  //$GLOBALS['global_value'] = 0;
  public function primary_registration(){
    if(Auth::user()){
      return view('home');
    }
    else{
      $division = Division::orderBy('id')->get();
      return view('auth.pre_register')->with('div',$division);
    }
  }




  public function verify(Request $request){
    if(Auth::user()){
      return view('home');
    }
    else if($request->session()->has('key')){
        return view('auth.verify_msg');
    }
    else{
      return view('auth.pre_register');
    }
  }




  public function verify_and_proceed(Request $request){
    //echo $request->session()->get('key');
    $data = PreRegistration::where('id','=',$request->session()->get('key'))->get()->first();
    $nn = $request->verification_number;
    if($nn == $data->verification_no){
      //return view('auth.register');
      return redirect()->route('register_1')->with('data_show',$data);
    }
    else{
      return redirect()->route('verify')->with('messages','Verification number did not matched. Try Again !!!');
    }
  }




  public function store(Request $request){

    $check_number = PreRegistration::orderBy('id','desc')->get();
    $temp = 0;
    foreach($check_number as $nmb){
      if($nmb->mobile_no==$request->mobile_no){
        $temp=1;
        $request->session()->put('key',$nmb->id);
      }
      elseif($nmb->username == $request->username){
        return redirect()->route('pre_register');
      }
    }
    if($temp==1){
      return redirect()->route('verify')->with('messages','The Number has been used before! If u want to create account then enter the verification number! Else register with a new mobile number!! ');
    }
    else{

      $request->validate([
        'username' => 'required|max:150|unique:users',
        'mobile_no' => 'required|max:150|unique:users',
        'blood_group' => 'required|max:150',
        'location' => 'required|max:150',
      ]);

      $data = new PreRegistration;
      $data->username = $request->username;
      $data->mobile_no = $request->mobile_no;
      $data->blood_group = $request->blood_group;
      $data->location = $request->location;
      $data->verification_no = mt_rand(1000000,9999999);
      $data->save();

      $data1 = new User;
      $data1->id = $data->id;
      //$pp = $data1->id;
      $data1->username = $request->username;
      $data1->mobile_no = $request->mobile_no;
      $data1->blood_group = $request->blood_group;
      $data1->location = $request->location;
      $data1->verification_no = $data->verification_no;
      $data1->verification_info = '0';
      $data1->save();

      //$pp = $data1->id;
      $request->session()->put('key',$data->id);
      $request->session()->put('number',$data->mobile_no);

      $database_ver1 = PreRegistration::where('id','=',$data->id)->get()->first();
      //$database_ver1 = PreRegistration::orderBy('id','desc')->first();
      $database_ver2 = User::where('id','=',$data->id)->get()->first();


      /*

      // SMS API //
      // Bulk SMS //

      */


      if($database_ver2->id == $database_ver1->id){
        if($database_ver2->verification_info == '0'){
          return redirect()->route('verify')->with('database_info1',$database_ver2)->with('messages','Enter The verificaion Number');
        }
        else if($database_ver2->verification_info == '1'){
          return redirect()->route('login');
        }
        else{
          return redirect()->route('pre_register');
        }
      }
    }
}








  public function index(){
    	$data = User::orderBy('id','desc')->get();
      if(Auth::user()){
        return redirect()->route('home');
      }
      else{
          return view('welcome')->with('data',$data);
      }

  }






  public function final_reg(Request $request){
    $request->validate([
      'first_name' => 'required|string|max:255',
      'middle_name' => 'required|string|max:255',
      'last_name' => 'required|string|max:255',
      'nick_name' => 'required|string|max:255',
      'mobile_no' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:6|confirmed',
      'facebook_id' => 'required|string|max:255',
      'twitter_id' => 'required|string|max:255',
      'present_address' => 'required|string|max:255',
      'permanent_address' => 'required|string|max:255',
    ]);
    $data = User::where( 'id','=',$request->session()->get('key') )->get()->first();;
    $data->first_name = $request->first_name;
    $data->middle_name = $request->middle_name;
    $data->last_name = $request->last_name;
    $data->name = $data->first_name." ".$data->middle_name." ".$data->last_name;
    $data->nick_name = $request->nick_name;
    //$data->mobile_no = $request->mobile_no;
    $data->email = $request->email;
    $data->password = Hash::make($request->password);
    $data->facebook_id = $request->facebook_id;
    $data->twitter_id = $request->twitter_id;
    $data->present_address = $request->present_address;
    $data->permanent_address = $request->permanent_address;
    $data->verification_info = '1';
    $data->save();

    $request->session()->flush('key');

    return redirect()->route('login')->with('messages',' Your Registration has been completed!! ');

  }





  public function reg_control(Request $request){
    if(Auth::user()){
      return view('home');
    }
    else if($request->session()->has('key')){
        return view('auth.register');
    }
    else{
      return view('auth.pre_register');
    }
  }

  public function reg_control_real(Request $request){
    if(Auth::user()){
      return view('home');
    }
    else if($request->session()->has('key')){
        return view('auth.register');
    }
    else{
      return view('auth.pre_register');
    }
  }





  public function pass_reset_ver(Request $request){
    $number = $request->mobile_no;
    $data = User::where('mobile_no','=',$number)->get()->first();
    $data_prev = PreRegistration::where('mobile_no','=',$number)->get()->first();
    if($data->id){
      $rand = mt_rand(1000000,9999999);
      $data->verification_no = $rand;
      $data->save();
      $data_prev->verification_no = $rand;
      $data_prev->save();
      $request->session()->put('key',$data->id);


      /*

      // SMS API //
      // Bulk SMS //

      */


      return view('auth.passwords.verify');
    }
    else{
      return view('auth.passwords.email');
    }
  }



  public function verify_for_pass_change(Request $request){
    $number = $request->verification_number;
    $data = User::where( 'id','=',$request->session()->get('key') )->get()->first();
    if($number == $data->verification_no){
      return view('auth.passwords.reset');
    }
    else{
      return view('auth.passwords.verify');
    }
  }





  public function reset_pass(Request $request){
    $pass = $request->password;
    $data = User::where( 'id','=',$request->session()->get('key') )->get()->first();
    $data->password = Hash::make($pass);
    $data->save();
    $request->session()->flush('key');
    //return view('auth.login');
    return redirect()->route('login');
  }



  public function admin_view(){
    return view('auth.admin_checks');
  }

  public function admin_op_test(Request $request){
    $numb =$request->mobile_no;
    $data = User::where('mobile_no','=',$numb)->get()->first();
    echo $data->verification_no;
  }


}
