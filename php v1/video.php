<?php

	class Videos {
		
		function thumbnail($video){


			$frame = 4;
			$movie = $video;

			$milliseconds = round(microtime(true) * 10);
			$thumbnail = '../thumbnails/'.$milliseconds.'.png';

				$mov = new ffmpeg_movie($movie);
			
				$frame = $mov->getFrame($frame);
				
					if ($frame) {
						$gd_image = $frame->toGDImage();
					
						if ($gd_image) {
							$size = [imagesx($gd_image),imagesy($gd_image)];
							if($size[0]< $size[1] || $size[0] > $size[1])
							{
								$rotate = imagerotate($gd_image, -90, 0);
								imagepng($rotate, $thumbnail);
								imagedestroy($gd_image);
								imagedestroy($rotate);
							}
							else
							{
								imagepng($gd_image, $thumbnail);
								imagedestroy($gd_image);
							}
							
							$path = "http://pinstantapp.com/thumbnails/".$milliseconds.'.png';
							return $path;
							
							
								
						}
					} 
			}
		
	}



?>