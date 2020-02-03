#!/bin/bash

ext=djvu
f=./sample.$ext
file_dir=$(dirname "$1")
file_name=$(basename "$1" ".$ext")

cp "$1" $f

pg=$(djvused -e 'n' $f)

for i in $(seq 1 $pg)
do
    djvu2hocr -p $i $f | sed 's/ocrx/ocr/g' > `printf "pg%04d.html" $i`
    ddjvu -format=tiff -page=$i $f `printf "pg%04d.tiff" $i`
done

pdfbeads -o ${f/djvu/pdf};

rm -f ./pg*.html ./pg*.tiff ./pg*.jbig2 ./pg*.sym ./pg*.jpg

cp ./sample.pdf "$file_dir/$file_name.pdf"
gio trash "$1"
