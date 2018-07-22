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
use Image;
use App\RequestBlood;
use App\History;
use App\Notification;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = RequestBlood::where('req_by','=' , Auth::user()->mobile_no)->orderBy('id','desc')->get();
        $notification = Notification::orderBy('id','desc')
                                      ->get();
        $user = User::orderBy('id')
                      ->get();
        return view('home')->with('data_show',$data)
                           ->with('notification',$notification)
                           ->with('users',$user);
    }

    public function user_edit(){
      if(Auth::user()){
        $notification = Notification::orderBy('id','desc')
                                      ->get();
        $user = User::orderBy('id')
                      ->get();
        return view('user_edit')->with('notification',$notification)
                                ->with('users',$user);
      }
      else{
        return view('login');
      }
    }

    public function user_edit_done(Request $request){
      $req_id = Auth::user()->id;
      $row = User::where('id','=',$req_id)->get()->first();

      $row->first_name = $request->first_name;
      $row->middle_name = $request->middle_name;
      $row->last_name = $request->last_name;
      $row->email = $request->email;
      $row->password = Hash::make($request->password);
      $row->height = $request->height;
      $row->weight = $request->weight;
      $row->gender = $request->gender;
      $row->facebook_id = $request->facebook_id;
      $row->twitter_id = $request->twitter_id;
      $row->mobile_no = $request->mobile_no;
      $row->present_address = $request->present_address;
      $row->permanent_address = $request->permanent_address;

      $row->save();

      $notification = Notification::orderBy('id','desc')
                                    ->get();
      $user = User::orderBy('id')
                    ->get();
      return redirect()->route('profile_show',$row->username)->with('notification',$notification)
                                                              ->with('users',$user);

    }

    public function profile_show($username){
      if(Auth::user()){
        $notification = Notification::orderBy('id','desc')
                                      ->get();
        $user = User::orderBy('id')
                      ->get();
        return view('profile',array('user'=>Auth::user()) )->with('notification',$notification)
                                                           ->with('users',$user);
      }
      else{
        $notification = Notification::orderBy('id','desc')
                                      ->get();
        $user = User::orderBy('id')
                      ->get();
        return view('profile')->with('notification',$notification)
                              ->with('users',$user);
      }
    }

    public function update_avatar(Request $request){
      if($request->hasFile('avatar')){
        $avatar = $request->file('avatar');
        $filename = time().".".$avatar->getClientOriginalExtension();
        Image::make($avatar)
               ->resize(300,300)
               ->save( public_path('/uploads/avatars/' .$filename) );

        $user = Auth::user();
        $user->avatar = $filename;
        $user->save();
      }

      $notification = Notification::orderBy('id','desc')
                                    ->get();
      $user = User::orderBy('id')
                    ->get();
      return view('profile',array('user'=>Auth::user()) )->with('notification',$notification)
                                                         ->with('users',$user);
    }
}
