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
use App\Notification;

class SuggestPersonController extends Controller
{
    public function suggest_form($id){
      $data = RequestBlood::where('id','=',$id)->get()->first();
      $find_user = User::where('mobile_no','=',$data->req_by)->get()->first();
      $notification = Notification::orderBy('id','desc')
                                    ->get();
      $user = User::orderBy('id')
                    ->get();
      return view('suggest')->with('data',$data)
                            ->with('user',$find_user)
                            ->with('notification',$notification)
                            ->with('users',$user);
    }

    public function suggest_confirm(Request $request,$id){
      $data = RequestBlood::where('id','=',$id)->get()->first();
      $data_chk = SuggestPerson::where('request_id','=',$id)->orderBy('id','desc')->get();

      foreach ($data_chk as $ff) {
        if( ($ff->suggested_name==$request->name) && ($ff->suggested_mobile_no==$request->mobile_no) && ($ff->suggested_by==Auth::user()->mobile_no) && ($ff->location==$request->location) ){
          $notification = Notification::orderBy('id','desc')
                                        ->get();
          $user = User::orderBy('id')
                        ->get();
          return redirect()->route('request_in_my_area')
                          ->with('notification',$notification)
                          ->with('users',$user);
        }
        else if($ff->suggested_mobile_no==$request->mobile_no){
          $data = RequestBlood::where('id','=',$id)->get()->first();
          $find_user = User::where('mobile_no','=',$data->req_by)->get()->first();
          $notification = Notification::orderBy('id','desc')
                                        ->get();
          $user = User::orderBy('id')
                        ->get();
          return view('suggest')->with('data',$data)
                                ->with('user',$find_user)
                                ->with('notification',$notification)
                                ->with('users',$user);
        }
        else{
          continue;
        }
      }

      $numb = $data->status_info;
      $numb++;
      $data->status_info = $numb;
      $data->save();

      $row = new SuggestPerson;
      $row->mobile_no = $data->req_by;
      $row->suggested_name = $request->name;
      $row->suggested_mobile_no = $request->mobile_no;
      $row->request_id = $id;
      $row->suggested_by = Auth::user()->mobile_no;
      $row->location = $request->location;

      $row->save();

      $show = SuggestPerson::where('request_id','=',$id)->get()->first();


      /*

      // SMS API //
      // Bulk SMS //

      */

            $history = new History;
            $history->user_oth = Auth::user()->mobile_no;
            $history->action = 'Suggested';
            $history->user_to_whom = $data->req_by;
            $history->request_id = $id;
            $history->save();


            $notification = new Notification;
            $notification->auth_user = Auth::user()->id;
            $notification->action = 'Suggested';
            $notification->action_id = $id;

            $find_user = User::where('mobile_no','=',$data->req_by)
                                    ->get()
                                    ->first();

            $notification->user_whom = $find_user->id;
            $notification->for_location = Auth::user()->location;
            $notification->seen = '0';
            $notification->save();

            $notification = Notification::orderBy('id','desc')
                                          ->get();
            $user = User::orderBy('id')
                          ->get();

        return redirect()->route('request_in_my_area')->with('notification',$notification)
                                                      ->with('users',$user);
    }

    public function show_suggest_list($id){
      $data_from_request = RequestBlood::where('id','=',$id)->get()->first();
      $data_from_suggest = SuggestPerson::where('request_id','=',$id)->orderBy('id','desc')->get();
      $data_from_user = User::orderBy('id','desc')->get();
      $notification = Notification::orderBy('id','desc')
                                    ->get();
      $user = User::orderBy('id')
                    ->get();
      return view('suggest_list')->with('data_req',$data_from_request)
                                 ->with('data_sugg',$data_from_suggest)
                                 ->with('data_user',$data_from_user)
                                 ->with('notification',$notification)
                                 ->with('users',$user);
    }


    public function suggest_form_for_notification($id, $id_nt){
      $data = RequestBlood::where('id','=',$id)->get()->first();
      $find_user = User::where('mobile_no','=',$data->req_by)->get()->first();
      $notification = Notification::orderBy('id','desc')
                                    ->get();
      $user = User::orderBy('id')
                    ->get();
      $ntf = Notification::where('id','=',$id_nt)
                           ->first();

      return view('suggest_for_notification')->with('data',$data)
                            ->with('user',$find_user)
                            ->with('notification',$notification)
                            ->with('notf',$ntf)
                            ->with('users',$user);
    }


    public function suggest_confirm_for_notification(Request $request,$id,$id_nt,$action_id,$auth_user){
      $data = RequestBlood::where('id','=',$id)->get()->first();
      $data_chk = SuggestPerson::where('request_id','=',$id)->orderBy('id','desc')->get();

      foreach ($data_chk as $ff) {
        if( ($ff->suggested_name==$request->name) && ($ff->suggested_mobile_no==$request->mobile_no) && ($ff->suggested_by==Auth::user()->mobile_no) && ($ff->location==$request->location) ){
          $notification = Notification::orderBy('id','desc')
                                        ->get();
          $user = User::orderBy('id')
                        ->get();
          return redirect()->route('request_in_my_area')
                          ->with('notification',$notification)
                          ->with('users',$user);
        }
        else if($ff->suggested_mobile_no==$request->mobile_no){
          $data = RequestBlood::where('id','=',$id)->get()->first();
          $find_user = User::where('mobile_no','=',$data->req_by)->get()->first();
          $notification = Notification::orderBy('id','desc')
                                        ->get();
          $user = User::orderBy('id')
                        ->get();
          return view('suggest')->with('data',$data)
                                ->with('user',$find_user)
                                ->with('notification',$notification)
                                ->with('users',$user);
        }
        else{
          continue;
        }
      }

      $numb = $data->status_info;
      $numb++;
      $data->status_info = $numb;
      $data->save();

      $row = new SuggestPerson;
      $row->mobile_no = $data->req_by;
      $row->suggested_name = $request->name;
      $row->suggested_mobile_no = $request->mobile_no;
      $row->request_id = $id;
      $row->suggested_by = Auth::user()->mobile_no;
      $row->location = $request->location;

      $row->save();

      $show = SuggestPerson::where('request_id','=',$id)->get()->first();


      /*

      // SMS API //
      // Bulk SMS //

      */

            $history = new History;
            $history->user_oth = Auth::user()->mobile_no;
            $history->action = 'Suggested';
            $history->user_to_whom = $data->req_by;
            $history->request_id = $id;
            $history->save();


            $notification = new Notification;
            $notification->auth_user = Auth::user()->id;
            $notification->action = 'Suggested';
            $notification->action_id = $id;

            $find_user = User::where('mobile_no','=',$data->req_by)
                                    ->get()
                                    ->first();

            $notification->user_whom = $find_user->id;
            $notification->for_location = Auth::user()->location;
            $notification->seen = '0';
            $notification->save();

            $notification = Notification::orderBy('id','desc')
                                          ->get();
            $user = User::orderBy('id')
                          ->get();

            $ntf = Notification::where('id','=',$id_nt)
                                 ->first();

           $req = RequestBlood::where('id','=',$action_id)
                                ->first();

        return view('notification_details')->with('notification',$notification)
                                                      ->with('req',$req)
                                                      ->with('notf',$ntf)
                                                      ->with('users',$user);
    }

}
