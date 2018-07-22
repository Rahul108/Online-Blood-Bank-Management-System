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

class NotificationController extends Controller
{
  public function notification_show($id, $action_id, $auth_user){
    $ntf = Notification::where('id','=',$id)
                         ->first();
    //echo $ntf->id;
    $ntf->seen = '1';
    $ntf->save();

    $req = RequestBlood::where('id','=',$action_id)
                         ->first();
    $user = User::orderBy('id')
                  ->get();
    $notification = Notification::orderBy('id','desc')
                                  ->get();

    return view('notification_details')->with('req',$req)
                                       ->with('users',$user)
                                       ->with('notf',$ntf)
                                       ->with('notification',$notification);
  }
}
