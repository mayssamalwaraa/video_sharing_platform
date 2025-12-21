<?php

namespace App\Http\Controllers;

use App\Jobs\ConvertVideoForStreaming;
use App\Models\Convertedvideo;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoContoller extends Controller
{
    public $video;
    public function __construct(Video $video)
    {
        $this->video = $video;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Auth::user()->videos->sortByDesc('created_at');
        $title = 'آخر الفيديوهات المرفوعة';
        return view('videos.my-videos',compact('videos','title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('videos.uploader');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'image'=>'image|required',
            'video'=>'required',

        ]);
        $randomPath =  Str::random(16);
        $videoPath = $randomPath. '.'.$request->video->getClientOriginalExtension();
        $imagePath = $randomPath. '.'.$request->image->getClientOriginalExtension();
        

        $request->video->storeAs('/',$videoPath,'public');
        $request->image->storeAs('/',$imagePath,'public');

        $video = Video::create([
            'disk'=>'public',
            'video_path'=>$videoPath,
            'image_path'=>$imagePath,
            'title'=>$request->title,
            'user_id'=>Auth::id(),
        ]);
        ConvertVideoForStreaming::dispatch($video);
        return redirect()->back()->with('success','سيكون مقطع الفيديو متوفر في أقرب فرصة عندما ننتهي من معالجته');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $video = $this->video::findOrFail($id);
        $convertedVideos =Convertedvideo::where('video_id',$id)->get();

        foreach($convertedVideos as $convertedVideo){
            Storage::delete([
                $convertedVideo->mp4_Format_240,
                $convertedVideo->mp4_Format_360,
                $convertedVideo->mp4_Format_480,
                $convertedVideo->mp4_Format_720,
                $convertedVideo->mp4_Format_1080,
                $convertedVideo->webm_Format_240,
                $convertedVideo->webm_Format_360,
                $convertedVideo->webm_Format_480,
                $convertedVideo->webm_Format_720,
                $convertedVideo->webm_Format_1080,
                $video->image_path

            ]);
            $video->delete();
            return back()->with('success','تم حذف مقطع الفيديو بنجاح');
        }
    }
}
