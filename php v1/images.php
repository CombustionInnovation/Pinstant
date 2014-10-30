<?php

	

	class images {
		
		
		public $folder = "/home/cbi/public_html/pinstantapp.com/uploads";
		
		
		function resizeImage($im, $newW, $newH) {
			
		 ini_set('memory_limit', '64M');     		 

		      		 

			$filename= $im;	
			$allowed_ext = array('jpg', 'JPG', 'jpeg', 'jpg');
			$file = explode(".", $filename);
			$file_ext = $file[1];
				if(in_array($file_ext, $allowed_ext ))
			{	

	
				$width = $newW;
				$height = $newH;
				header('Content-Type: image/jpeg');

				// Get new dimensions
				list($width_orig, $height_orig) = getimagesize($filename);

				$ratio_orig = $width_orig/$height_orig;

				if ($width/$height > $ratio_orig) {
  					 $width = $height*$ratio_orig;
				} else {
  					 $height = $width/$ratio_orig;
				}

				$image_p = imagecreatetruecolor($width, $height);
				$image = imagecreatefromjpeg($filename);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);


				imagejpeg($image_p, null, 100);
		      	
			}else{
				//$this->resizePNGImage($im,$newW,$newH);
			}       
		
		}
		
		
		
		function uploadImage($ip) {
			
			
			$folder = "/home/cbi/public_html/pinstantapp.com/uploads/";
 


			if (is_uploaded_file($_FILES['filename']['tmp_name'])){
 			
				if (move_uploaded_file($_FILES['filename']['tmp_name'], $folder.$_FILES ['filename'] ['name'])) {
						
					//this is a function i use to insert the image. put this in the users class. 				
				//	$user->insertImage("http://combustioninnovation.com/luis/pinstant/uploads/".$_FILES ['filename'] ['name'],$ip);
					
					$location = "http://pinstantapp.com/uploads/".$_FILES ['filename'] ['name'];
					$filename = $_FILES ['filename'] ['name'];
					
					$output = $location;
					$this -> resSaveImage("../uploads/".$filename,600,"");
    			}
				else {
   
    			}
			} 
			else {

			}



			return $output;
		}
		
		function deleteImage($pic) {
			
			$loc = $folder . $pic;
			unlink($loc);	
		}
		
		function watermarkImage($pic) {
			
			$im = imagecreatefromjpeg($pic);
			
			$stamp = imagecreatetruecolor(100, 70);
			imagefilledrectangle($stamp, 0, 0, 99, 69, 0x0000FF);
			imagefilledrectangle($stamp, 9, 9, 90, 60, 0xFFFFFF);
			$im = imagecreatefromjpeg($pic);
			imagestring($stamp, 5, 20, 20, 'GroupFlight', 0x0000FF);
			imagestring($stamp, 3, 20, 40, '(c) 2014', 0x0000FF);
			
			$margin_right = 10;
			$margin_bottom = 10;
			$sx = imagesx($stamp);
			$sy = imagesy($stamp);
			
			imagecopymerge($im, $stamp, imagesx($im) -$sx - $margin_right, imagesy($im) - $sy - $margin_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 50);
			
			imagepng($im, 'photo_stamp.png');
			imagedestroy($im);	
		}
		
		function resizeImageInServer($src){
			//Your Image
			$imgSrc = $src;

			//getting the image dimensions
			list($width, $height) = getimagesize($imgSrc);

			//saving the image into memory (for manipulation with GD Library)
			$myImage = imagecreatefromjpeg($imgSrc);

			// calculating the part of the image to use for thumbnail
			if ($width > $height) {
			  $y = 0;
			  $x = ($width - $height) / 2;
			  $smallestSide = $height;
			} else {
			  $x = 0;
			  $y = ($height - $width) / 2;
			  $smallestSide = $width;
			}

			// copying the part into thumbnail
			$thumbSize = 100;
			$thumb = imagecreatetruecolor($thumbSize, $thumbSize);
			imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);

			//final output
			header('Content-type: image/jpeg');
			imagejpeg($thumb);
		}
		
		
		function resSaveImage($im, $newW, $newH) {
			
		 ini_set('memory_limit', '64M');     		 

		      		 

			$filename= $im;	
	
				$width = $newW;
				$height = $newH;
				header('Content-Type: image/jpeg');

				// Get new dimensions
				list($width_orig, $height_orig) = getimagesize($filename);

				$ratio_orig = $width_orig/$height_orig;

				if ($width/$height > $ratio_orig) {
  					 $width = $height*$ratio_orig;
				} else {
  					 $height = $width/$ratio_orig;
				}

				$image_p = imagecreatetruecolor($width, $height);
				$image = imagecreatefromjpeg($filename);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);


				$jp = imagejpeg($image_p, $im, 100);
			
				imagedestroy($jp);
				
		   
		
		}
		
		
	}




?>