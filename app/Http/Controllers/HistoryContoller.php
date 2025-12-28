<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryContoller extends Controller
{
    public function index(){
        $user = User::findOrFail(Auth::user()->id);        
        $videos = $user->videoInHistory()->get();
        $title = 'سجل المشاهدة';
        return view('history.index',compact('videos','title'));

    }
    public function destroy($id){
        Auth::user()->videoInHistory()->wherePivot('id',$id)->detach();
        return back()->with('success','تم حذف مقطع الفيديو من السجل بنجاح');
    }
    public function destroyAll(){
        Auth::user()->videoInHistory()->detach();
        return back()->with('success','تم حذف  السجل بنجاح');
    }
}
