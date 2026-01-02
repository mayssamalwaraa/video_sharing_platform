<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(){
        $someNotifications = Auth::user()->notifications->sortByDesc('created_at')->take(4);
        $items = array_values($someNotifications->toArray());
        return response()->json(['someNotifications'=>$someNotifications]);
    }
    public function allNotification(){
        $notifications = Auth::user()->notifications->sortByDesc('created_at');
        $title = 'جميع الإشعارات';
        return view('notifications.show',compact('notifications','title'));
    }
}
