<?


   namespace PHPVideoToolkit;

    include_once 'videokit/examples/includes/bootstrap.php';

	$video  = new Video('../videos/recTue_Aug_12_17_26_38_EDT_2014.mp4');

	$output_format = new VideoFormat();

	
	$output_format->setAudioCodec('aac')
				->setVideoCodec('h263p')
				->setVideoRotation(true)
				->setVideoDimensions(352,288)
				;
           
	
	 $process = $video->save('../videos/211w111211.mp4', $output_format);
 
?>