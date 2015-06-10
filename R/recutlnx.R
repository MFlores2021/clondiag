#R projects
#Develop by: Mirella Flores
#Copyright: (c) Internationa Potato Center 
# source("http://bioconductor.org/biocLite.R")
# biocLite("EBImage")

 library(EBImage)

 args 		<- commandArgs()
file_org 	<- args[5]
file_dir 	<- args[6]
input		<-	file.path (file_dir,"thumbnail",file_org)

setwd(file_dir)

detect.obj=function(i){

	i=1-i

	if(colorMode(i)==0){
		colorMode(i)=Grayscale
		pth=thresh(i,6,6,0.00475) # filter 2: modify the morphological shape, solo i para grayscale, funciona: pth=thresh(i[,,1],2,2,0.00475) 
	} else{
		pth=thresh(i[,,1],6,6,0.00475) # filter 2: modify the morphological shape, solo i para grayscale, funciona: pth=thresh(i[,,1],2,2,0.00475) 
	}
	
	kern=makeBrush(7, shape='diamond', step=FALSE)^2 #makeBrush(7,shape='disc') tamanio de linea?

	#pf=closing(pth,kern)
	pf=opening(pth,kern)	
	pfh=fillHull(pf)
#conteo de objetos
	
	nobj=bwlabel(pfh)

#eliminacion de objetos insignificantes
	
	pp=computeFeatures.shape(nobj)[,'s.area']

	id = which(pp<500) # mas pekeños k 100
	rm=rmObjects(nobj,id)
	
	pp1=computeFeatures.shape(rm)[,'s.perimeter']
	id1 = which(pp1<100)     		#puntos menores que
	rm1=rmObjects(rm,id1)
	
	pp2=computeFeatures.shape(rm1)[,'s.perimeter']
	id2 = which(pp2>1000)
	rm2=rmObjects(rm1,id2)
	rm2=rm1
	
	if(max(rm2)==0){
		res='no se detectaron objetos'
		return(res)
	}else{
	
		#marcado de objetos reconocidos
		colorMode(rm2)=Grayscale

		sto=stackObjects(rm2,i)
		obj= paintObjects(rm2, i, col='red')
		#display(obj)
		#caracterizacion de objetos
		oc=ocontour(rm2)
		pp=computeFeatures.moment(rm2)[,c('m.cx','m.cy')]  #'g.x','g.y','g.s','g.p','g.pdm','g.pdsd')] #puntos de los obj reconocidos

		if(class(pp)=="numeric"){

			ch=pp[1:2]
			ch=round(ch)
			ptx=1
			res=ch 
			res=round(res,4)
			n=1			
			res=list(res,sto,ptx,n)
			
			return(res)			
		}
		else{
				
			ch=pp[,1:2]
			ch=round(ch)
			ptx=1
			res=cbind(ch) #,ch1,ch2)
			n=nrow(ch)
			res=list(res,sto,ptx,n)
			
			return(res)
		}
		
	}
	
	
}
imagen.pto.initial <- function(oc,pto2,ch,im,dimens,i,coord){
	
	pto = (oc[[1]][coord,])
	
	pto.min=min(pto[,i])
	pto.max=max(pto[,i])
	distn=(pto.max-pto.min)
	eje=pto2[i]-(ch-pto.min)
	
	dim.init <- dim(im)
	pto.real=eje*dim.init[i]/dimens
	distn.real=distn*dim.init[i]/dimens
	
	result=list(pto.real, distn.real)
	
	return(result)
}


image.coordenada<-function(img,vect,colMode){
	#analisis del objeto seleccionado
	
	dist=matrix(0,length(vect),11)
	go=1
	for(k in vect){
		#deteccion		

	if(colMode == FALSE){
		x=img[[1]][,,k]
		colorMode(x)=Grayscale
		pth1=thresh(x,15,15,0.005)
	} else{
		x=img[[1]][,,,k]
		pth1=thresh(x[,,1],15,15,0.005)
	}

		kern=makeBrush(13,shape='disc')
		pf1=closing(pth1,kern)
		pf1=fillHull(pf1)
		colorMode(pf1)=Grayscale
		ob1=bwlabel(pf1)
		oc=ocontour(pf1)
		ch=computeFeatures.moment(pf1)[,c('m.cx','m.cy')]
		ch=round(ch)
		
		h1 = which(oc[[1]][,2]==ch[2]) # devuelve la coordenada
		v1 = which(oc[[1]][,1]==ch[1])
		#contorno, punto medio, puntos altura, puntos ancho
		result=list(oc,ch,h1,v1)
		# x objeto
		return(result)
	}
}

imagen.distance <- function(oc,i,coord){
	
	pto = (oc[[1]][coord,])
	
	pto.min=min(pto[,i])
	pto.max=max(pto[,i])
	distn=(pto.max-pto.min)
	
	return(distn)
}
pto.inicio.matriz<- function(oc,i,coord){
	
	pto = (oc[[1]][coord,])
	pto.min=min(pto[,i])

	return(pto.min)
}
image.crop <-function(i0){

	im = readImage(i0)
	out <- file.path ("thumbnail","output.jpg")
	
	# dimen <- dim(im)
	
	# if (dimen[2]>600 || dimen[1]>600){
		# writeImage(resize(im,600),out)
	# }
	# else out=i0
	    writeImage(resize(im,600),out )
	if (file.exists(out)){
	i = readImage(out)
	
	colMode = FALSE
	if(colorMode(i)==2){
	colMode = TRUE
	}
	# call to main function for detect objects
	object = detect.obj(i)

	# for display image: display(morp[[2]])

	n=object[[4]]
	imgcrop = FALSE
	dimens <- dim(i)
	tfn = "convert"

	if(n > 1){
		k=1
		puntosx	=	NULL
		puntosy	=	NULL
		wid		=	NULL
		for(k in 1:n){
			
			xy <- object[[1]][k,c('m.cx','m.cy')] #devuelve los puntos centrales de cada obj
			
			# get initial points in objects in image resized
			resu <-image.coordenada(object[2],vect=(k),colMode) #devuelve varios valores de imagen
			
			#resu: puntos contorno,,...,puntos altura
			ejex <-imagen.distance(resu[[1]][1],1,resu[[3]])
			ejey <-imagen.distance(resu[[1]][1],2,resu[[4]])
		
			x0 <-pto.inicio.matriz(resu[[1]][1],1,resu[[3]])
			y0 <-pto.inicio.matriz(resu[[1]][1],2,resu[[4]])
			
			# only for look for labels for size

			if (ejex != 0 && ejey != 0){
		
				if (round(ejey/ejex) ==2){
				
					xi=imagen.pto.initial(resu[[1]][1],xy,resu[[2]][1],i,dimens[1],1,resu[[3]])
					yi=imagen.pto.initial(resu[[1]][1],xy,resu[[2]][2],i,dimens[2],2,resu[[4]])				
					
					puntosxi = as.numeric(xi[[1]][1])
					puntosyi = as.numeric(yi[[1]][1])
					wid = c(wid,xi[[2]][1])
					
				}
				else if(round(ejex/ejey)==1){
					xi=imagen.pto.initial(resu[[1]][1],xy,resu[[2]][1],i,dimens[1],1,resu[[3]])
					yi=imagen.pto.initial(resu[[1]][1],xy,resu[[2]][2],i,dimens[2],2,resu[[4]])
					puntosx = c(puntosx,as.numeric(xi[[1]][1] ))
					puntosy = c(puntosy,as.numeric(yi[[1]][1] ))
					wid = c(wid,xi[[2]][1])
					
				}
				
			}
			
			k=k+1
		}
		outimage <- file.path ("thumbnail",file_org)
		outimagex <- file.path ("thumbnail",paste("x",file_org,sep=''))
		#convert -crop WxH {+-}x{+-}y {%} {!} input output
		wid=mean(wid)
		X=puntosxi-(wid*1.32)
		Y=puntosyi-(wid*1.2)
		W=max(puntosx)-X+wid*1.05 #*0.95
		H=max(puntosy)-Y+wid*2.2
		
		if (X<0) X=0
		if (Y<0) Y=0 
		#system2(tfn,args=paste("-crop",paste(W,"x",H,"+",X,"+",Y,sep=''), out, outimage, sep = " "), stdout = TRUE) #file.path ("thumbnail","output.jpg")

		#imgcrop = TRUE
		imgcrop = c(W,H,X,Y)
	}
	else {
	imgcrop = FALSE

			}
	}
	return (imgcrop)
	#if(file.exists(file.path ('thumbnail','output.jpg'))) file.remove(file.path ('thumbnail','output.jpg'))
}

a=NULL
a=image.crop(input)
a


