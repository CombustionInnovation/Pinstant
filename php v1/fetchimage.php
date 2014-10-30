<?
//http://combustioninnovation.com/luis/pinstant/php/fetchimage.php?image&height&width
      $im = $_REQUEST['image'];
      $height = $_REQUEST['height'];
      $width = $_REQUEST['width'];
      
	require("images.php");
	$image = new Images();
	
	$image->resizeImage($im,$width,$height);
	
	
		 
		      	
		      	
		      	

?> 
