
#	Clondiag Project
#	R projects
#	Develop by:	Mirella Flores
#	Copyright : (c) Internationa Potato Center 

##############################################################################
####################			Inputs			 #############################
##############################################################################

	args 		<- commandArgs()
	file_org 	<- args[5]
	file_dir 	<- args[6]
	sizem 		<- as.numeric(args[7]) + 1
	proj_dir 	<- args[8]
	projt 	<- args[9]
	print(projt)
	setwd(file.path(file_dir,"result"))



##############################################################################
######### 			Image manipulation			 #############################
##############################################################################

	library(EBImage)
	library(spotSegmentation)
	library(mclust)
	library(stringr)

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

					# if (!is.na(rowcut) && !is.na(colcut)) {
						# chan1[] <- 0
						# chan1[rowcut, colcut[1]:colcut[length(colcut)]] <- 1
						# chan1[rowcut[1]:rowcut[length(rowcut)], colcut] <- 1
							# contour(z = t(chan1[nrow(chan1):1, ]), nlevels = 1, levels = 1, 
								# drawlabels = FALSE, col = "red", add = TRUE)
					# }
					
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
	
	
	#Getting standard desviation from specific negative controls
	
	I1 <- rowcut[10]:(rowcut[11] - 1)
	J1 <- colcut[1]:(colcut[2] - 1)
	spot1 <- s[I1, J1]
	min.b <- sd(as.vector(spot1))

	I1 <- rowcut[9]:(rowcut[10] - 1)
	J1 <- colcut[1]:(colcut[2] - 1)
	spot1 <- s[I1, J1]
	min.b <- c(min.b,sd(as.vector(spot1)))

	I1 <- rowcut[4]:(rowcut[5] - 1)
	J1 <- colcut[8]:(colcut[9] - 1)
	spot1 <- s[I1, J1]
	min.b <- c(min.b,sd(as.vector(spot1)))

	I1 <- rowcut[5]:(rowcut[6] - 1)
	J1 <- colcut[8]:(colcut[9] - 1)
	spot1 <- s[I1, J1]
	min.b <- c(min.b,sd(as.vector(spot1)))

	###8,4		1,9  #10,6	3,7

	if( projt == "sweetpotato3rditeration") {
	min.b <- NA
	I1 <- rowcut[7]:(rowcut[8] - 1)
	J1 <- colcut[3]:(colcut[4] - 1)
	spot1 <- s[I1, J1]
	min.b <- sd(as.vector(spot1))

	I1 <- rowcut[8]:(rowcut[9] - 1)
	J1 <- colcut[3]:(colcut[4] - 1)
	spot1 <- s[I1, J1]
	min.b <- c(min.b,sd(as.vector(spot1)))

	I1 <- rowcut[6]:(rowcut[7] - 1)
	J1 <- colcut[10]:(colcut[11] - 1)
	spot1 <- s[I1, J1]
	min.b <- c(min.b,sd(as.vector(spot1)))

	I1 <- rowcut[7]:(rowcut[8] - 1)
	J1 <- colcut[10]:(colcut[11] - 1)
	spot1 <- s[I1, J1]
	min.b <- c(min.b,sd(as.vector(spot1)))
	print(min.b )
	}
	# Getting the min of negative controls
	
	min.n 	<- min(min.b)
	#min.neg <- max(min.b[!is.na(min.b)]) #mean
	min.neg <- mean(min.b, na.rm=TRUE)
	if(min.neg < 0.02) {
	min.neg = 0.02 }
	# hallar los min de negativos 
	# Getting standard desviation from all spots 

	for (i in R) {
	
        I <- rowcut[i - 1]:(rowcut[i] - 1)

        for (j in C) {
		
            J <- colcut[j - 1]:(colcut[j] - 1)
			spot = s[I, J]
			result[i-1,j-1] = FALSE

			mask = thresh(spot, 15, 15, 0.00725) 				#mask = thresh(spot, 10, 10, 0.00725)
			mk3 = makeBrush(2, shape=c('disc'), step=FALSE)^2 	#change 3 by 2
			mk5 = makeBrush(5, shape='diamond', step=FALSE)^2
																#mask = dilate(erode(closing(mask, mk5), mk3), mk5)
			mask = closing(erode(dilate(mask, mk3), mk3), mk3)
			nobj = bwlabel(mask)
			areaobj = computeFeatures.shape(nobj)[,'s.area']
			###
			id = which(areaobj<30) # delete little  points # cuando regrese decidir si se qued ao no esto con el excel
			rm=rmObjects(nobj,id)
			areaobj = computeFeatures.shape(rm)[,'s.area']
			ecce = computeFeatures.moment (rm)[,'m.eccentricity']
			###
			
			#if (length(areaobj) == 1){
			
			desv.stnd[i-1,j-1] <- sd(as.vector(spot))
			#resultarea[i-1,j-1] <- areaobj
			ecce = min(ecce)
			if (is.numeric(ecce) && ecce < 0.5){
			#CHANGE desv.stnd 0.039 to 0.0.49, and areaobj/length(spot)>= 0.65 to 0.4
			if(desv.stnd[i-1,j-1] >=min.neg) {
			
					result[i-1,j-1] = TRUE
				}			
			}													# else if(areaobj/length(spot)>=0.5){
																	
																	# result[i-1,j-1] = 'MAY'
																# }
			#}
			  
																#idx=idx+1
		}
	}
		
		# Round to 3 digits desviatiion standard
		intensity 	=	round(desv.stnd,3)
		

##############################################################################
#########			 Write results 				##############################
##############################################################################

	write.table(t(intensity), file= file.path(file_dir,"result",paste(file_org,"-int.csv", sep='')), sep=",", row.names=F)
	write.table(t(result), file= file.path(file_dir,"result",paste(file_org,"-pos.csv", sep='')), sep=",", row.names=F)
	#write.table(t(resultarea), file= file.path(file_dir,"result",paste(file_org,"-posarea.csv", sep='')), sep=",", row.names=F)


##############################################################################
######### 			Image stadistics graphs		 #############################
##############################################################################

	#Reading virus ubication excel file
	mydata2 = read.csv(file.path (proj_dir,"datavirus.csv"), header=T)

	#Extract short virus names
	virus   = as.vector(str_replace(as.vector(mydata2[,2]),"#.+",""))
	
	#Extract complete virus names
	cvirus  = as.vector(mydata2[,2])
	int     = as.vector(intensity[,rev(seq_len(ncol(intensity)))])
	
######### 			Graph 1			##########################################

	#Creating datatable from intensity and names 
	vplot   = aggregate(int ~ virus, FUN = mean) 
	vplotsd = aggregate(int ~ virus, FUN = sd) 
	
	#Creating png file for barplot	
	png(paste(file_org,"2.png"),width = 450, height = 300, bg='transparent')
	
	#Colors for bars type
	vplot$Colour="lightgrey"
	vplot$Colour[vplot$int>=min.neg]				=	"red"
	vplot$Colour[vplot$virus=="Biotin-Marke_2,5uM"]	=	"dodgerblue"
	vplot$Colour[vplot$virus=="neg-"]				=	"dodgerblue"
	vplot$Colour[vplot$virus=="plant_18S"]			=	"dodgerblue"
	vplot$Colour[vplot$virus=="Spotting_Puffer"]	=	"dodgerblue" 
	vplot$Colour[vplot$virus=="SP-rbcL"]			=	"dodgerblue"
	
	#Creating error bar function
	error.bar <- function(x, y, upper, lower=upper, length=0.1,...){
				if(length(x) != length(y) | length(y) !=length(lower) | length(lower) != length(upper))
				stop("vectors must be same length")
				arrows(x,y+upper, x, y-lower, angle=90, code=3, length=length,lty=2, ...)
	}

	#Plotting graph1
	barp 	= barplot(vplot$int,names=vplot$virus,las=2,border="black",ann=FALSE,axes=TRUE, col = vplot$Colour) 
																	#ifelse(vplot$int >= min.neg,'red','lightgrey')) #ifelse(vplot$virus = 3, "red", ifelse(vplot$int >= min.neg,"blue", "black"))
	error.bar(barp,vplot$int, 1.96*vplotsd$int/10)
	abline   (h=min.neg ,col="blue")
	title    (xlab = "",cex.lab = 1.8, font.lab = 20, main = "Plot by disease", cex.main = 1.8, font.main = 2)
	dev.off()
	

######### 			Graph 2			##########################################

	#Creating datatable from intensity and names 
	cvplot   = aggregate(int ~ cvirus, FUN = mean) 

	#Creating png file for barplot	
	png(paste(file_org,".png"),width = 950, height = 600, bg='transparent')

	#Colors for bars type
	cvplot$Colour="lightgrey"
	cvplot$Colour[cvplot$int>=min.neg]					=	"red"
	cvplot$Colour[cvplot$cvirus=="Biotin-Marke_2,5uM"]	=	"dodgerblue"
	cvplot$Colour[cvplot$cvirus=="neg-"]				=	"dodgerblue"
	cvplot$Colour[cvplot$cvirus=="plant_18S"]			=	"dodgerblue"
	cvplot$Colour[cvplot$cvirus=="Spotting_Puffer"]		=	"dodgerblue"
	cvplot$Colour[cvplot$cvirus=="SP-rbcL"]				=	"dodgerblue"

	#Plotting graph2
	barplot(cvplot$int,names=cvplot$cvirus,las=2,border="black",ann=FALSE,axes=TRUE, col = cvplot$Colour)  #ifelse(cvplot$int >= min.n,'red','lightgrey'))
	abline(h=min.neg ,col="blue")
	title(xlab = "",cex.lab = 1.8, font.lab = 20, main = "Plot by oligo", cex.main = 1.8, font.main = 2)
	dev.off()

# Return min neg value
min.neg