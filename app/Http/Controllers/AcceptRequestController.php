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
use App\History;
use App\Notification;

class AcceptRequestController extends Controller
{
    public function accept_verify($id){

      $mod = RequestBlood::where('id','=',$id)
                           ->get()
                           ->first();
      $data_chk = AcceptRequest::where('request_id','=',$id)
                                 ->orderBy('id','desc')
                                 ->get();

      foreach($data_chk as $ff){
        if( ($ff->mobile_no == Auth::user()->mobile_no) && ($ff->request_id == $mod->id) && ($ff->accepted_by == $mod->contact) ){
          $notification = Notification::orderBy('id','desc')
                                        ->get();
          $user = User::orderBy('id')
                        ->get();
          return redirect()->route('request_in_my_area')
                           ->with('notification',$notification)
                           ->with('users',$user);
        }
      }

      $numb =  $mod->req_info;
      $numb++;
      $mod->req_info = $numb;
      $mod->save();


      $data_acpt = new AcceptRequest;
      $data_acpt -> mobile_no = Auth::user() -> mobile_no ;
      $data_acpt -> request_id = $mod -> id ;
      $data_acpt -> accepted_by = $mod -> contact;
      $data_acpt -> save();


      $notification = new Notification;
      $notification->auth_user = Auth::user()->id;
      $notification->action = 'Accepted';
      $notification->action_id = $mod->id;

      $find_user = User::where('mobile_no','=',$mod->req_by)
                              ->get()
                              ->first();

      $notification->user_whom = $find_user->id;
      $notification->for_location = Auth::user()->location;
      $notification->seen = '0';
      $notification->save();

      /*

      // SMS API //
      // Bulk SMS //

      */


            $history = new History;
            $history->user_oth = Auth::user()->mobile_no;
            $history->action = 'Accepted';
            $history->user_to_whom = $mod->req_by;
            $history->request_id = $mod->id;
            $history->save();

            $notification = Notification::orderBy('id','desc')
                                          ->get();
            $user = User::orderBy('id')
                          ->get();

      return redirect()->route('request_in_my_area')
                        ->with('notification',$notification)
                        ->with('users',$user);
    }

    public function show_accept_list($id){
      $data_from_request = RequestBlood::where('id','=',$id)->get()->first();
      $data_from_acpt = AcceptRequest::where('request_id','=',$id)->orderBy('id','desc')->get();
      $data_from_user = User::orderBy('id','desc')->get();

      $notification = Notification::orderBy('id','desc')
                                    ->get();
      $user = User::orderBy('id')
                    ->get();

      return view('accepted_list')->with('data_req',$data_from_request)
                                  ->with('data_acpt',$data_from_acpt)
                                  ->with('data_user',$data_from_user)
                                  ->with('notification',$notification)
                                  ->with('users',$user);
    }


    public function accept_verify_for_notification($id,$id_nt,$action_id,$auth_user){

      $mod = RequestBlood::where('id','=',$id)
                           ->get()
                           ->first();
      $data_chk = AcceptRequest::where('request_id','=',$id)
                                 ->orderBy('id','desc')
                                 ->get();

      foreach($data_chk as $ff){
        if( ($ff->mobile_no == Auth::user()->mobile_no) && ($ff->request_id == $mod->id) && ($ff->accepted_by == $mod->contact) ){
          $notification = Notification::orderBy('id','desc')
                                        ->get();
          $user = User::orderBy('id')
                        ->get();
          return redirect()->route('request_in_my_area')
                           ->with('notification',$notification)
                           ->with('users',$user);
        }
      }

      $numb =  $mod->req_info;
      $numb++;
      $mod->req_info = $numb;
      $mod->save();


      $data_acpt = new AcceptRequest;
      $data_acpt -> mobile_no = Auth::user() -> mobile_no ;
      $data_acpt -> request_id = $mod -> id ;
      $data_acpt -> accepted_by = $mod -> contact;
      $data_acpt -> save();


      $notification = new Notification;
      $notification->auth_user = Auth::user()->id;
      $notification->action = 'Accepted';
      $notification->action_id = $mod->id;

      $find_user = User::where('mobile_no','=',$mod->req_by)
                              ->get()
                              ->first();

      $notification->user_whom = $find_user->id;
      $notification->for_location = Auth::user()->location;
      $notification->seen = '0';
      $notification->save();

      /*

      // SMS API //
      // Bulk SMS //

      */

            $history = new History;
            $history->user_oth = Auth::user()->mobile_no;
            $history->action = 'Accepted';
            $history->user_to_whom = $mod->req_by;
            $history->request_id = $mod->id;
            $history->save();

            $notification = Notification::orderBy('id','desc')
                                          ->get();

            $user = User::orderBy('id')
                          ->get();

            $req = RequestBlood::where('id','=',$action_id)
                                 ->first();

            $ntf = Notification::where('id','=',$id_nt)
                                 ->first();

      return view('notification_details')->with('notification',$notification)
                                          ->with('notf',$ntf)
                                          ->with('req',$req)
                                          ->with('users',$user);
    }
}
