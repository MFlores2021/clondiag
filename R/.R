library(EBImage)
	setwd("/var/www/clondiag/thumbnail/")
	input <- "/var/www/clondiag/thumbnail/"
	im  <- readImage(input)
	chan11 <- channel(im, "green")
	chan11