#setwd("/var/www/clondiag/R/temp")
args <- commandArgs()
file_org <- args[5]
file_dir <- args[7]
setwd(file.path(file_dir,"result"))
array1 = args[6]
arraynames = args[8]

png(paste(file_org,"2.png"),width = 750, height = 750, bg='transparent')
par(bg = "lightcyan", col.axis='black', bty='n', pch = 20,mgp=c(4.2,1,0))

array1 <- gsub(" ", "", array1)
array1 <- unlist(strsplit(array1, split="@"))
array1 <- gsub("#([0-9]-)?.*", "", array1,perl=TRUE)
array2 <- data.frame(name = array1)
array2 <- table(array2)-1
# for names
arraynames <- gsub(" ", "", arraynames)
arraynames <- unlist(strsplit(arraynames, split="@"))
arraynames <- gsub("#([0-9]-)?.*", "", arraynames)
arraynames2 <- data.frame(name =arraynames)
arraynames2=table(arraynames2)
arrayfinal=merge(array2,arraynames2,by.x = "array2",by.y="arraynames2")

write.table(arrayfinal, file=paste(file_org,"-mm.csv", sep=''), sep=",", row.names=F)

# plot(array2,col = rainbow(15), las=2, border="black",ann=FALSE,axes =TRUE)
# box()
# title(xlab = "Virus", cex.lab = 1.8, font.lab = 20, main = "Number of positive controls by virus", cex.main = 1.8, font.main = 2)
# dev.off() 
