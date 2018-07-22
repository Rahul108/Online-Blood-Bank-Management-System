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

class HistoryController extends Controller
{
    public function show_history(){
      $data_pass = RequestBlood::where('area','=' , Auth::user()->present_address)
                                ->orderBy('id','desc')
                                ->get();
      $data_pass_2 = User::orderBy('id','desc')
                           ->get();
      $data_pass_3 = AcceptRequest::where('mobile_no','=',Auth::user()->mobile_no)
                                    ->orderBy('id','desc')
                                    ->get();
      $history = History::orderBy('id','desc')
                          ->get();
      $user = User::orderBy('id','desc')
                    ->get();


      $notification = Notification::orderBy('id','desc')
                                    ->get();
      $users = User::orderBy('id')
                    ->get();
      return view('history')->with('data_show',$data_pass)
                            ->with('data_show_2',$data_pass_2)
                            ->with('data_show_3',$data_pass_3)
                            ->with('history',$history)
                            ->with('user',$user)
                            ->with('notification',$notification)
                            ->with('users',$users);
    }
}
