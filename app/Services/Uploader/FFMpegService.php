<?php


namespace App\Services\Uploader;


use FFMpeg\FFProbe;

class FFMpegService
{
    /**
     * @var FFProbe
     */
    private $ffprobe;

    public function __construct()
    {
        //dd(config('services.ffmpeg.ffprobe_path'));
        $this->ffprobe = FFProbe::create([
            'ffprobe.binaries' => config('services.ffmpeg.ffprobe_path')
        ]);
    }

    public function durationOf(string $path)
    {
        return (int)$this->ffprobe->format($path)->get('duration');
    }
}
