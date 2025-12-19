<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Video;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Filters\Video\VideoFilters;
use FFMpeg\Format\Video\WebM;
use FFMpeg\Format\Video\X264;
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
                ->export()
                ->toDisk(env("FILESYSTEM_DISK"))
                ->inFormat($this->formate[$this->i][$j])
                ->addFilter(function(VideoFilters $filters){
                    $filters->resize(new Dimension($this->vidoWidth[$this->i],$this->vidoHeight[$this->i]));
                })
                ->save($this->names[$this->i][$j]);

            }

        }


    }
    private function getFileName($filename,$type){
        return preg_replace('/\\[^.\\s}{3,4}$/','',$filename).$type;
    }
    public function handle(): void
    {
        
      
    }
}
