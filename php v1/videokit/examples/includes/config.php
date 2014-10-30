<?php

    try
    {
        $config = new \PHPVideoToolkit\Config(array(
            'temp_directory'              => '/tmp',
            'ffmpeg'                      => '/usr/local/bin/ffmpeg',
            'ffprobe'                     => '/usr/local/bin/ffprobe',
            'yamdi'                       => '/usr/local/bin/yamdi',
            'qtfaststart'                 => '/usr/local/bin/qt-faststart',
            'gif_transcoder'              => 'php',
            'gif_transcoder_convert_use_dither'    => false,
            'gif_transcoder_convert_use_coalesce'  => false,
            'gif_transcoder_convert_use_map'       => false,
            'convert'                     => '/usr/local/bin/convert',
            'gifsicle'                    => '/usr/local/bin/gifsicle',
            'php_exec_infinite_timelimit' => true,
            'cache_driver'                => 'InTempDirectory',
        ), true);
    }
    catch(\PHPVideoToolkit\Exception $e)
    {
        echo '<h1>Config set errors</h1>';
        \PHPVideoToolkit\Trace::vars($e);
        exit;
    }

    $example_video_path = BASE.'examples/media/BigBuckBunny_320x180.mp4';
    $example_audio_path = BASE.'examples/media/Ballad_of_the_Sneak.mp3';
    
