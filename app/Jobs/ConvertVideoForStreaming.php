<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Video;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg ;


class ConvertVideoForStreaming implements ShouldQueue
{
    use Queueable;
    public $video;
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
    public function handle(): void
    {
        
        $lowbitrateFormat = (new X264('aac','libx264'))->setKiloBitrate(500);
        $low2_bitrateFormat = (new X264('aac','libx264'))->setKiloBitrate(900);
        $mediumbitrateFormat = (new X264('aac','libx264'))->setKiloBitrate(1500);
        $highbitrateFormat = (new X264('aac','libx264'))->setKiloBitrate(3000);

        $convertedName = '240-'.$this->video->video_path;
        $convertedName_360 = '360-'.$this->video->video_path;
        $convertedName_480 = '480-'.$this->video->video_path;
        $convertedName_720 = '720-'.$this->video->video_path;

        FFMpeg::fromDisk($this->video->disk)
                        ->open($this->video->video_path)
                        ->addFilter(function($filters){
                            $filters->resize(new Dimension(426,240));
                        })
                        ->export()
                        ->toDisk('public')
                        ->inFormat($lowbitrateFormat)
                        ->save($convertedName)
                        // 360 
                        ->addFilter(function($filters){
                            $filters->resize(new Dimension(640,360));
                        })
                        ->export()
                        ->toDisk('public')
                        ->inFormat($low2_bitrateFormat)
                        ->save($convertedName_360)

                        // 480
                        ->addFilter(function($filters){
                            $filters->resize(new Dimension(854,480));
                        })
                        ->export()
                        ->toDisk('public')
                        ->inFormat($mediumbitrateFormat)
                        ->save($convertedName_480)
                        // 720
                        ->addFilter(function($filters){
                            $filters->resize(new Dimension(1280,720));
                        })
                        ->export()
                        ->toDisk('public')
                        ->inFormat($highbitrateFormat)
                        ->save($convertedName_720);
    }
}
