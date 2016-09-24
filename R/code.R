
#	Clondiag Project
#	R projects
#	Develop by:	Mirella Flores
#	Copyright : (c) Internationa Potato Center 

##############################################################################
######### 			Image manipulation			 #############################
##############################################################################

	library(EBImage)
	library(spotSegmentation)
	library(mclust)
	library(stringr)


	args 		<- commandArgs()
	file_org 	<- args[5]
	file_dir 	<- args[6]
	sizem 		<- as.numeric(args[7]) + 1
	proj_dir 	<- args[8]
	projt 	<- args[9]
	
	setwd(file.path(file_dir,"result"))

	# paths 
	input		<-	file.path (file_dir,"thumbnail",file_org)
	output		<-	file.path (file_dir,"result",file_org)
	
	# Read image
	im 			<-  readImage(input)
	
	# Extract channels
	chan1 		<- 	imageData(channel(im, mode="red"))
	chan2 		<- 	imageData(channel(im, mode="green"))
	signal 		<- 	chan1 + chan2
	signal 		<- 	t(signal)
					#plotBlockImage(signal) 	### draw R

	# Numero de grillas col x rows
	colcut 		= floor(seq(1,nrow(signal)-1,length=sizem))
	rowcut 		= floor(seq(1,ncol(signal)-1,length=sizem))
	
	# Write little image for easy processing
	writeImage(chan1,output, quality = 100)

	# Initializing variables
	m 			<- length(rowcut)
	n 			<- length(colcut)
	s 			<- chan1 + chan2
	R 			<- NULL
	C 			<- NULL
	R 			<- if (is.null(R)) 2:m    else R + 1
	C 			<- if (is.null(C)) 2:n    else C + 1
	desv.stnd 	<- matrix(nrow = sizem-1, ncol = sizem-1)
	result 		<- matrix(nrow = sizem-1, ncol = sizem-1)
	area 		<- matrix(nrow = sizem-1, ncol = sizem-1)
	resultarea 	<- matrix(nrow = sizem-1, ncol = sizem-1)
	
	
	# Getting standard deviation from specific negative controls
	# 3rd iteration: 7,3 8,3 6,10 7,10
	
	mydata2 = read.csv(file.path(proj_dir,"datavirus.csv"), header=T)
	neg		= which(mydata2[,2] == "neg-")
	min.b	= NA
	
	for (num in neg) {	
		
		I	=	num%%(sizem-1)
		J	=	sizem-(num/(sizem-1))
		J	=	trunc(J)
		
		if(I == 0) I = sizem-1 
			
		I1 <- rowcut[I]:(rowcut[I+1] - 1)
		J1 <- colcut[J]:(colcut[J+1] - 1)
		spot1 <- s[I1, J1]
		min.b <- c(min.b,sd(as.vector(spot1)))
	}
	
	# hallar los min de negativos 
	min.neg <- mean(min.b, na.rm=TRUE)

	if(min.neg < 0.02) min.neg = 0.02 
	
	# Getting standard desviation from all spots 

	for (i in R) {
	
        I <- rowcut[i - 1]:(rowcut[i] - 1)

        for (j in C) {
		
            J <- colcut[j - 1]:(colcut[j] - 1)
			spot = s[I, J]
			result[i-1,j-1] = FALSE

			mask = thresh(spot, 15, 15, 0.00725) 				
			mk3 = makeBrush(2, shape=c('disc'), step=FALSE)^2 	
			mk5 = makeBrush(5, shape='diamond', step=FALSE)^2
																
			mask = closing(erode(dilate(mask, mk3), mk3), mk3)
			nobj = bwlabel(mask)
			areaobj = computeFeatures.shape(nobj)[,'s.area']
			###
			id = which(areaobj<30) 
			rm=rmObjects(nobj,id)
			areaobj = computeFeatures.shape(rm)[,'s.area']
			ecce = computeFeatures.moment (rm)[,'m.eccentricity']
			###
			
			desv.stnd[i-1,j-1] <- sd(as.vector(spot))

			ecce = min(ecce)
			if (is.numeric(ecce) && ecce < 0.5){
			
				if(desv.stnd[i-1,j-1] >=min.neg) {
			
					result[i-1,j-1] = TRUE
				}			
			}				
		}
	}		
		# Round to 3 digits desviatiion standard
	intensity 	=	round(desv.stnd,3)
	
	write.table(t(intensity), file= file.path(file_dir,"result",paste(file_org,"-int.csv", sep='')), sep=",", row.names=F)
	write.table(t(result), file= file.path(file_dir,"result",paste(file_org,"-pos.csv", sep='')), sep=",", row.names=F)
	
	int = as.vector(intensity[,rev(seq_len(ncol(intensity)))])
	
######### 			Graph 1			##########################################

	#Extract complete virus names
	virus  = as.vector(mydata2[,2])
	
	#Creating datatable from intensity and names 
	cplot = aggregate(int ~ virus , FUN = mean) 
	
	#Colors for bars type
	cplot$Colour="lightgray"
	cplot$Colour[cplot$int>=min.neg]				=	"#80B1D3"
	cplot$Colour[cplot$virus=="Biotin-Marke_2,5uM"]	=	"#FB8072"
	cplot$Colour[cplot$virus=="neg-"]				=	"#FB8072"
	cplot$Colour[cplot$virus=="plant_18S"]			=	"#FB8072"
	cplot$Colour[cplot$virus=="Spotting_Puffer"]	=	"#FB8072" 
	cplot$Colour[cplot$virus=="SP-rbcL"]			=	"#FB8072"
	cplot$valor= min.neg
	
	write.table(cplot, file= file.path(file_dir,"result",paste(file_org,"-cplot.csv", sep='')), sep=",", row.names=F)

######### 			Graph 2			##########################################
	
	#Extract short virus names
	virus	= as.vector(str_replace(as.vector(mydata2[,2]),"#.+",""))
	splot	= aggregate(int ~ virus , FUN = mean) 
	
	#Colors for bars type
	splot$Colour="lightgray"
	splot$Colour[splot$int>=min.neg]				=	"#80B1D3"
	splot$Colour[splot$virus=="Biotin-Marke_2,5uM"]	=	"#FB8072"
	splot$Colour[splot$virus=="neg-"]				=	"#FB8072"
	splot$Colour[splot$virus=="plant_18S"]			=	"#FB8072"
	splot$Colour[splot$virus=="Spotting_Puffer"]	=	"#FB8072" 
	splot$Colour[splot$virus=="SP-rbcL"]			=	"#FB8072"
	splot$valor= min.neg
		
	write.table(splot, file= file.path(file_dir,"result",paste(file_org,"-splot.csv", sep='')), sep=",", row.names=F)

