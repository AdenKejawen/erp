#!/bin/sh
#################################################################
# Author Muhammad Surya Ihsanuddin								#
# Email	: mutofiyah@gmail.com									#
# Blog	: http://adenkejawen.com 								#
#																#
# Dilarang merubah source code tanpa sepengetahuan author		#
#################################################################

#Bash Script untuk compress javascript dan css khusus symfony

#param YUI COMPRESSOR LOCATION
#param DIRECTORY TO COMPRESS
#param SAVE DIRECTORY
ROOT=$2
JARPATH=$1
COPYPATH=$3
#Hapus direktori lama dan buat direktori baru
if [ -d $COPYPATH ]
then
	rm -rf $COPYPATH
fi
mkdir $COPYPATH
#Copy semua folder dalam root
for dir in $(ls $ROOT);
do
	echo "Copy $ROOT/$dir To $COPYPATH/$dir"
	cp -R --dereference "$ROOT/$dir" "$COPYPATH"
done
#Starting Compressiong Javascript
echo "Compressing Javascript"
for file in $(find $COPYPATH -name "*.js");
do
	echo "Compressing $file"
	java -jar $JARPATH --type js -o $file $file
done
#Starting Compressiong CSS
echo "Compressing CSS"
for file in $(find $COPYPATH -name "*.css");
do
	echo "Compressing $file"
	java -jar $JARPATH --type css -o $file $file
done
