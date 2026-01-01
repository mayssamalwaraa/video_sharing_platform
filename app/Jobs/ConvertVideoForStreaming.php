<?php


namespace App\Jobs;

use App\Events\RealNotification;
use App\Models\Convertedvideo;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Video;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\FFProbe;
use FFMpeg\Filters\Video\VideoFilters;
use FFMpeg\Format\Video\WebM;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg ;


class ConvertVideoForStreaming implements ShouldQueue
{
    use Queueable;
    public $video;
    public $formate;
    public $vidoWidth; 
    public $vidoHeight; 
    public $names; 
    public $i;


    /**
     * Create a new job instance.
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     */
    protected function convertVideo($loopNumber){
        $this->formate = array(
            array(
                (new X264('aac','libx264'))->setKiloBitrate(4096),(new WebM('libvorbis','libvpx'))->setKiloBitrate(3000)
            ),
            array(
                (new X264('aac','libx264'))->setKiloBitrate(2048),(new WebM('libvorbis','libvpx'))->setKiloBitrate(2048)
            ),
            array(
                (new X264('aac','libx264'))->setKiloBitrate(750),(new WebM('libvorbis','libvpx'))->setKiloBitrate(750)
            ),
            array(
                (new X264('aac','libx264'))->setKiloBitrate(500),(new WebM('libvorbis','libvpx'))->setKiloBitrate(500)
            ),
            array(
                (new X264('aac','libx264'))->setKiloBitrate(300),(new WebM('libvorbis','libvpx'))->setKiloBitrate(300)
            )
        );
        $this->vidoWidth = array(1920,1280,854,640,426);
        $this->vidoHeight = array(1080,720,480,360,240);
        $this->names = array(
            array(
                '1080p-'.$this->getFileName($this->video->video_path,'.mp4'),'1080p-'.$this->getFileName($this->video->video_path,'.webm')
            ),
            array(
                '720p-'.$this->getFileName($this->video->video_path,'.mp4'),'720p-'.$this->getFileName($this->video->video_path,'.webm')
            ),
            array(
                '480p-'.$this->getFileName($this->video->video_path,'.mp4'),'480p-'.$this->getFileName($this->video->video_path,'.webm')
            ),
            array(
                '360p-'.$this->getFileName($this->video->video_path,'.mp4'),'360p-'.$this->getFileName($this->video->video_path,'.webm')
            ),
            array(
                '240p-'.$this->getFileName($this->video->video_path,'.mp4'),'240p-'.$this->getFileName($this->video->video_path,'.webm')
            ),
        );
        for($this->i = $loopNumber;$this->i<5;$this->i++){
            for($j=0;$j<2;$j++){
                FFMpeg::fromDisk($this->video->disk)
                ->open($this->video->video_path)
                ->addFilter(function(VideoFilters $filters){
                    $filters->resize(new Dimension($this->vidoWidth[$this->i],$this->vidoHeight[$this->i]));
                })
                ->export()
                ->toDisk('public')
                ->inFormat($this->formate[$this->i][$j])
                ->save($this->names[$this->i][$j]);

            }

        }


    }
    private function getFileName($filename,$type){
        return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename) .$type;  
    }
    public function handle(): void
    {
        
      $ffprobe = FFProbe::create();
      $video1=$ffprobe->streams(public_path('/storage//'.$this->video->video_path))->videos()->first();
      $width = $video1->get('width');
      $height = $video1->get('height');

      $media = FFMpeg::fromDisk($this->video->disk)
                ->open($this->video->video_path);
      $durationInSeconds = $media->getDurationinSeconds();
      $hours = floor($durationInSeconds/3600);
      $minutes= floor(($durationInSeconds/60)%60);
      $seconds=floor($durationInSeconds%60);
      $quality = 0;
    //   المقطع عرضي 
    if($width>$height){

        if(($width>=1920)&&($height >=1080)){
            $quality=1080;
            $this->convertVideo(0);
        }
        elseif(($width>=1280)&&($height >=720)&&($width<1920 && $height <1080)){
            $quality=720;
            $this->convertVideo(1);
        }
        elseif(($width>=854)&&($height >=480)&&($width<1280 && $height <720)){
            $quality=480;
            $this->convertVideo(2);
        }
        elseif(($width>=640)&&($height >=360)&&($width<854 && $height <480)){
            $quality=360;
            $this->convertVideo(3);
        }else{
            $quality=240;
            $this->convertVideo(4);
            
        }
    }
    // المقطع طولي
    elseif($height>$width){
        $this->video->update([
            'Longitudinal'=>true
        ]);
        if(($height>=1920)&&($width >=1080)){
            $quality=1080;
            $this->convertVideo(0);
        }
        elseif(($height>=1280)&&($width >=720)&&($height<1920 && $width <1080)){
            $quality=720;
            $this->convertVideo(1);
        }
        elseif(($height>=854)&&($width >=480)&&($height<1280 && $width <720)){
            $quality=480;
            $this->convertVideo(2);
        }
        elseif(($height>=640)&&($width >=360)&&($height<854 && $width <480)){
            $quality=360;
            $this->convertVideo(3);
        }else{
            $quality=240;
            $this->convertVideo(4);
            
        }
    }
    Storage::disk('public')->delete($this->video->video_path);

    $convertVideo = new Convertedvideo;

    for($i=0;$i<5;$i++){
        $convertVideo->{'mp4_Format_'.$this->vidoHeight[$i]}=$this->names[$i][0];
        $convertVideo->{'webm_Format_'.$this->vidoHeight[$i]}=$this->names[$i][1];


    }
    $convertVideo->video_id=$this->video->id;
    $convertVideo->save();
    $notification = new Notification();
    $notification->user_id = $this->video->user_id;
    $notification->notification = $this->video->title;
    $notification->save();
    $data = [
        'video_title'=>$this->video->title,
    ];
    event(new RealNotification($data));
    $this->video->update(
        [
            'processed'=>true,
            'hours'=>$hours,
            'minutes'=>$minutes,
            'seconds'=>$seconds,
            'quality'=>$quality,
        ]
    );


    }
}
// namespace App\Jobs;

// use App\Models\Convertedvideo;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Foundation\Queue\Queueable;
// use App\Models\Video;
// use FFMpeg\Coordinate\Dimension;
// use FFMpeg\FFProbe;
// use FFMpeg\Filters\Video\VideoFilters;
// use FFMpeg\Format\Video\WebM;
// use FFMpeg\Format\Video\X264;
// use Illuminate\Support\Facades\Storage;
// use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg ;


// class ConvertVideoForStreaming implements ShouldQueue
// {
//     use Queueable;
//     public $video;
//     public $formate;
//     public $vidoWidth; 
//     public $vidoHeight; 
//     public $names; 
//     public $i;


//     /**
//      * Create a new job instance.
//      */
//     public function __construct(Video $video)
//     {
//         $this->video = $video;
//     }

//     /**
//      * Execute the job.
//      */
//     protected function convertVideo($loopNumber){
//         $this->formate = array(
//             array(
//                 (new X264('aac','libx264'))->setKiloBitrate(4096),(new WebM('libvorbis','libvpx'))->setKiloBitrate(3000)
//             ),
//             array(
//                 (new X264('aac','libx264'))->setKiloBitrate(2048),(new WebM('libvorbis','libvpx'))->setKiloBitrate(2048)
//             ),
//             array(
//                 (new X264('aac','libx264'))->setKiloBitrate(750),(new WebM('libvorbis','libvpx'))->setKiloBitrate(750)
//             ),
//             array(
//                 (new X264('aac','libx264'))->setKiloBitrate(500),(new WebM('libvorbis','libvpx'))->setKiloBitrate(500)
//             ),
//             array(
//                 (new X264('aac','libx264'))->setKiloBitrate(300),(new WebM('libvorbis','libvpx'))->setKiloBitrate(300)
//             )
//         );
//         $this->vidoWidth = array(1920,1280,854,640,426);
//         $this->vidoHeight = array(1080,720,480,360,240);
//         $this->names = array(
//             array(
//                 '1080p-'.$this->getFileName($this->video->video_path,'.mp4'),'1080p-'.$this->getFileName($this->video->video_path,'.webm')
//             ),
//             array(
//                 '720p-'.$this->getFileName($this->video->video_path,'.mp4'),'720p-'.$this->getFileName($this->video->video_path,'.webm')
//             ),
//             array(
//                 '480p-'.$this->getFileName($this->video->video_path,'.mp4'),'480p-'.$this->getFileName($this->video->video_path,'.webm')
//             ),
//             array(
//                 '360p-'.$this->getFileName($this->video->video_path,'.mp4'),'360p-'.$this->getFileName($this->video->video_path,'.webm')
//             ),
//             array(
//                 '240p-'.$this->getFileName($this->video->video_path,'.mp4'),'240p-'.$this->getFileName($this->video->video_path,'.webm')
//             ),
//         );
//         for($this->i = $loopNumber;$this->i<5;$this->i++){
//             for($j=0;$j<2;$j++){
//                 FFMpeg::fromDisk($this->video->disk)
//                 ->open($this->video->video_path)
//                 ->addFilter(function(VideoFilters $filters){
//                     $filters->resize(new Dimension($this->vidoWidth[$this->i],$this->vidoHeight[$this->i]));
//                 })
//                 ->export()
//                 ->toDisk(env('FILESYSTEM_DISK'))
//                 ->inFormat($this->formate[$this->i][$j])
//                 ->save($this->names[$this->i][$j]);

//             }

//         }


//     }
//     private function getFileName($filename,$type){
//         return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename) .$type;   
//     }
//     public function handle(): void
//     {
        
//       $ffprobe = FFProbe::create();
//       $video1=$ffprobe->streams(storage_path('/storage//'.$this->video->video_path))->videos()->first();
//       $width = $video1->get('width');
//       $height = $video1->get('height');

//       $media = FFMpeg::fromDisk($this->video->disk)
//                 ->open($this->video->video_path);
//       $durationInSeconds = $media->getDurationinSeconds();
//       $hours = floor($durationInSeconds/3600);
//       $minutes= floor(($durationInSeconds/60)%60);
//       $seconds=floor($durationInSeconds%60);
//       $quality = 0;
//     //   المقطع عرضي 
//     if($width>$height){

//         if(($width>=1920)&&($height >=1080)){
//             $quality=1080;
//             $this->convertVideo(0);
//         }
//         elseif(($width>=1280)&&($height >=720)&&($width<1920 && $height <1080)){
//             $quality=720;
//             $this->convertVideo(1);
//         }
//         elseif(($width>=854)&&($height >=480)&&($width<1280 && $height <720)){
//             $quality=480;
//             $this->convertVideo(2);
//         }
//         elseif(($width>=640)&&($height >=360)&&($width<854 && $height <480)){
//             $quality=360;
//             $this->convertVideo(3);
//         }else{
//             $quality=240;
//             $this->convertVideo(4);
            
//         }
//     }
//     // المقطع طولي
//     elseif($height>$width){
//         $this->video->update([
//             'Longitudinal'=>true
//         ]);
//         if(($height>=1920)&&($width >=1080)){
//             $quality=1080;
//             $this->convertVideo(0);
//         }
//         elseif(($height>=1280)&&($width >=720)&&($height<1920 && $width <1080)){
//             $quality=720;
//             $this->convertVideo(1);
//         }
//         elseif(($height>=854)&&($width >=480)&&($height<1280 && $width <720)){
//             $quality=480;
//             $this->convertVideo(2);
//         }
//         elseif(($height>=640)&&($width >=360)&&($height<854 && $width <480)){
//             $quality=360;
//             $this->convertVideo(3);
//         }else{
//             $quality=240;
//             $this->convertVideo(4);
            
//         }
//     }
//     Storage::disk('public')->delete($this->video->video_path);

//     $convertVideo = new Convertedvideo;

//     for($i=0;$i<5;$i++){
//         $convertVideo->{'mp4_Format_'.$this->vidoHeight[$i]}=$this->names[$i][0];
//         $convertVideo->{'webm_Format_'.$this->vidoHeight[$i]}=$this->names[$i][1];


//     }
//     $convertVideo->video_id=$this->video->id;
//     $convertVideo->save();
//     $this->video->update(
//         [
//             'processed'=>true,
//             'hours'=>$hours,
//             'minutes'=>$minutes,
//             'seconds'=>$seconds,
//             'quality'=>$quality,
//         ]
//     );


//     }
// }
