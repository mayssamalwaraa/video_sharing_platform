<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MainContoller extends Controller
{
    public function index(){
        $date = Carbon::today()->subDays(7);
        $title = 'الفيديوهات الأكثر مشاهدة هذا الأسبوع';
        $videos = Video::join('views','videos.id','=','views.video_id')
                  ->orderBy('views.views_number','Desc')
                  ->where('videos.created_at','>=',$date)
                  ->take(16)
                  ->get('videos.*');
        return view('main',compact('title','videos'));
    }
    public function channelVideos(User $channel){
        $videos = Video::where('user_id',$channel->id)->get();
        $title = 'جميع الفيديوهات الخاصة بالقناة'.$channel->name;
        return view('videos.my-videos',compact('videos','title'));
    }
}
