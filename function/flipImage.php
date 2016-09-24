<?php
	function flipImage($image, $vertical, $horizontal) {
		$w = imagesx($image);
		$h = imagesy($image);
		if (!$vertical && !$horizontal) return $image;
		$flipped = imagecreatetruecolor($w, $h);
		if ($vertical) {
		  for ($y=0; $y<$h; $y++) {
			imagecopy($flipped, $image, 0, $y, 0, $h - $y - 1, $w, 1);			
		  }
		}
		if ($horizontal) {
		  if ($vertical) {
			$image = $flipped;
			$flipped = imagecreatetruecolor($w, $h);
		  }
		  for ($x=0; $x<$w; $x++) {
			imagecopy($flipped, $image, $x, 0, $w - $x - 1, 0, 1, $h);
		  }
		}
		return $flipped;
}
?>