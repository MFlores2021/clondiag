
#	Clondiag Project
#	R projects
#	Develop by:	Mirella Flores
#	Copyright : (c) Internationa Potato Center 
# 	Modified Nov 2016

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
	size_array 	<- as.numeric(args[7]) 
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
	
	#s_norm = normalize(s,ft=c(0,1))
	#s = medianFilter(s_norm, 5)  
	
	desv.stnd 	<- matrix(nrow = sizem-1, ncol = sizem-1)
	result 		<- matrix(nrow = sizem-1, ncol = sizem-1)
	area 		<- matrix(nrow = sizem-1, ncol = sizem-1)
	resultarea 	<- matrix(nrow = sizem-1, ncol = sizem-1)
	result.v	<- matrix(nrow = 225, ncol = 2)
	#desv.s 	<- matrix(nrow = sizem-1, ncol = sizem-1)	
	
	# Getting standard deviation from specific negative controls

	mydata = read.csv(file.path(proj_dir,"datavirus.csv"), header=T)

	neg		= c(which(mydata[,2] == "neg-2"), which(mydata[,2] == "neg-1"))
	min.b	= NA
	k1 = makeBrush(2, shape='disc')
	k2 = makeBrush(3, shape='disc')
	
	for (num in neg) {	
		
		I	=	num%%(sizem-1)
		J	=	sizem-(num/(sizem-1))
		J	=	trunc(J)
		
		if(I == 0) I = sizem-1 
			
		I1 <- rowcut[I]:(rowcut[I+1] - 1)
		J1 <- colcut[J]:(colcut[J+1] - 1) 
		spot1 <- s[I1, J1]

		spota= spot1/max(spot1)
		spota = dilate(spota, k2)
		spot1= erode(spota, k1)

		min.b <- c(min.b,sd(as.vector(spot1)))
	}
	
	# hallar los min de negativos 
	min.neg <- mean(min.b, na.rm=TRUE)
	aaa = (size_array*size_array) - (size_array-1)
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
			
			spota= spot/max(spot)
			spota = dilate(spota, k2)
			spot= erode(spota, k1)
			
			result.v[aaa,1] <-  sd(as.vector(spot))
			result.v[aaa,2] <-  FALSE
			
			ecce = min(ecce)
			if (is.numeric(ecce) && ecce < 0.5){
			
				if(result.v[aaa,1] >=min.neg) {
					result.v[aaa,2] <-  TRUE

				}			
			}	
			aaa = aaa - size_array			
		}
		aaa = aaa + (size_array*size_array) + 1
	}		

	# Round to 3 digits desviatiion standard
	result.v 	=	round(result.v,3)
	colnames(result.v) <- c("int", "bool");

	value = as.vector(result.v[,rev(seq_len(ncol(result.v )))])
	#	int = as.vector(intensity[,rev(seq_len(ncol(intensity)))])
	int = result.v[,1]


######### 			Graph 1			##########################################

	#Extract complete virus names
	virus  = as.vector(mydata[,2])
	result.v = cbind(result.v, cvirus=virus)  

	#Creating datatable from intensity and names 
	cplot = aggregate(int ~ virus , FUN = mean) 
	
	#Colors for bars type
	cplot$Colour="lightgray"
	cplot$Colour[cplot$value>=min.neg]				=	"#80B1D3"
	cplot$Colour[cplot$virus=="Biotin-Marke_2,5uM"]	=	"#FB8072"
	cplot$Colour[cplot$virus=="neg-1"]				=	"#FB8072"
	cplot$Colour[cplot$virus=="neg-2"]				=	"#FB8072"
	cplot$Colour[cplot$virus=="plant_18S"]			=	"#FB8072"
	cplot$Colour[cplot$virus=="Spotting_Puffer"]	=	"#FB8072" 
	cplot$Colour[cplot$virus=="SP-rbcL"]			=	"#FB8072"
	cplot$sort=1
	cplot$sort[cplot$virus=="Biotin-Marke_2,5uM"]	=	2
	cplot$sort[cplot$virus=="neg-1"]				=	3
	cplot$sort[cplot$virus=="neg-2"]				=	4
	cplot$sort[cplot$virus=="plant_18S"]			=	5
	cplot$sort[cplot$virus=="Spotting_Puffer"]	=	6 
	cplot$sort[cplot$virus=="SP-rbcL"]			=	7
	cplot$valor= min.neg
	#	cplot= cbind(cplot, svirus=mydata[,3])  

	write.table(cplot, file= file.path(file_dir,"result",paste(file_org,"-cplot.csv", sep='')), sep=",", row.names=F)

######### 			Graph 2			##########################################
	
	#Extract short virus names
	virus	= as.vector(mydata[,3])
	result.v = cbind(result.v, svirus=virus) 

	#Creating datatable from intensity and names 
	splot	= aggregate(int ~ virus , FUN = mean) 

	#Colors for bars type
	splot$Colour="lightgray"
	splot$Colour[splot$value>=min.neg]				=	"#80B1D3"
	splot$Colour[splot$virus=="Biotin-Marke_2,5uM"]	=	"#FB8072"
	splot$Colour[splot$virus=="neg-1"]				=	"#FB8072"
	splot$Colour[splot$virus=="neg-2"]				=	"#FB8072"
	splot$Colour[splot$virus=="plant_18S"]			=	"#FB8072"
	splot$Colour[splot$virus=="Spotting_Puffer"]	=	"#FB8072" 
	splot$Colour[splot$virus=="SP-rbcL"]			=	"#FB8072"
	splot$sort=1
	splot$sort[splot$virus=="Biotin-Marke_2,5uM"]	=	2
	splot$sort[splot$virus=="neg-1"]				=	3
	splot$sort[splot$virus=="neg-2"]				=	4
	splot$sort[splot$virus=="plant_18S"]			=	5
	splot$sort[splot$virus=="Spotting_Puffer"]	=	6 
	splot$sort[splot$virus=="SP-rbcL"]			=	7
	splot$valor= min.neg
		
	write.table(splot, file= file.path(file_dir,"result",paste(file_org,"-splot.csv", sep='')), sep=",", row.names=F)
	write.table(result.v, file= file.path(file_dir,"result",paste(file_org,"-desv.csv", sep='')), sep=",", row.names=F)

######### 			Table			##########################################

	#Filter positive control
	pos = result.v[result.v[,2] == 1 , ]
	tpos <- data.frame(name = pos[,4])
	tpos <- table(tpos)-1

	#Read total names
	ttvirus <- data.frame(name = result.v[,4])
	ttvirus <- table(ttvirus)

	fortable=merge(tpos,ttvirus,by.x = "tpos",by.y="ttvirus")
	write.table(fortable, file=paste(file_org,"-mm.csv", sep=''), sep=",", row.names=F)
