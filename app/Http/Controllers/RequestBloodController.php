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
use App\AcceptRequest;
use App\SuggestPerson;
use App\History;
use App\Division;
use App\Notification;

class RequestBloodController extends Controller
{
    public function show_form(){
      if(Auth::user()){
        $data = User::where('id','=',Auth::user()->id)->first();
        $division = Division::orderBy('id')->get();
        $notification = Notification::orderBy('id','desc')
                                      ->get();
        $user = User::orderBy('id')
                      ->get();
        return view('request_blood')->with('data',$data)
                                    ->with('div',$division)
                                    ->with('notification',$notification)
                                    ->with('users',$user);
      }
      else{
        return view('login');
      }
    }


    public function request_blood(Request $request){
      $row = RequestBlood::orderBy('id','desc')->get();
      $data = new RequestBlood;

      $data->blood_group = $request->blood_group_req;
      $data->area = $request->location_to_find;
      $data->urgency = $request->reason;
      $data->within = $request->reason_dateline;
      $data->place_of_donation = $request->donation_place;
      $data->req_info = 0;
      $data->contact = $request->mobile_no;
      $data->status_info = 0;
      $data->req_by = Auth::user()->mobile_no;
      $data->save();

      $grab_id  = RequestBlood::where('req_by','=' , Auth::user()->mobile_no)
                                                           ->orderBy('id','desc')
                                                           ->get()
                                                           ->first();

      $history = new History;
      $history->user_oth = Auth::user()->mobile_no;
      $history->action = 'Requested';
      $history->user_to_whom = 'all';
      $history->request_id = $grab_id->id;
      $history->save();

      $user_to_notify = User::where('location','=',Auth::user()->location)
                              ->orderBy('id')
                              ->get();

      foreach ($user_to_notify as $m_user) {
        if($m_user->id != Auth::user()->id){
          $notification = new Notification;
          $notification->auth_user = Auth::user()->id;
          $notification->action = 'Requested';
          $notification->action_id = $grab_id->id;
          $notification->user_whom = $m_user->id;
          $notification->for_location = Auth::user()->location;
          $notification->seen = '0';
          $notification->save();
        }
      }

      $data_pass = RequestBlood::where('req_by','=' , Auth::user()->mobile_no)->orderBy('id','desc')->get();

      $notification = Notification::orderBy('id','desc')
                                    ->get();
      $user = User::orderBy('id')
                    ->get();

      return redirect()->route('home')
                      ->with('data_show',$data_pass)
                      ->with('notification',$notification)
                      ->with('users',$user);
    }

    public function request_in_my_area(){
      $data_pass = RequestBlood::where('area','=' , Auth::user()->location)
                                 ->orderBy('id','desc')
                                 ->get();

      $data_pass_2 = User::orderBy('id','desc')
                           ->get();

      $data_pass_3 = AcceptRequest::where('mobile_no','=',Auth::user()->mobile_no)
                                    ->orderBy('id','desc')
                                    ->get();

      $notification = Notification::orderBy('id','desc')
                                    ->get();

      $user = User::orderBy('id')
                    ->get();

      return view('request_in_area')->with('data_show',$data_pass)
                                    ->with('data_show_2',$data_pass_2)
                                    ->with('data_show_3',$data_pass_3)
                                    ->with('notification',$notification)
                                    ->with('users',$user);

    }

    public function change_location(){
      $data = User::where('id','=',Auth::user()->id)->first();
      $division = Division::orderBy('id')->get();
      $notification = Notification::orderBy('id','desc')
                                    ->get();
      $user = User::orderBy('id')
                    ->get();
      return view('change_location')->with('data',$data)
                                    ->with('div',$division)
                                    ->with('notification',$notification)
                                    ->with('users',$user);
    }

    public function change_location_done(Request $request){
      $data = User::where('id','=',Auth::user()->id)->first();
      $data->location = $request->location;
      $data->save();

      $data11 = RequestBlood::where('req_by','=' , Auth::user()->mobile_no)->orderBy('id','desc')->get();
      $notification = Notification::orderBy('id','desc')
                                    ->get();
      $user = User::orderBy('id')
                    ->get();
      return redirect()->route('home')
                       ->with('data_show',$data11)
                       ->with('notification',$notification)
                       ->with('users',$user);
    }
}
