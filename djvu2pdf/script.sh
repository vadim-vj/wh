#!/bin/bash

f='sample.djvu'
pg=$(djvused -e 'n' $f)

for i in $(seq 1 $pg)
do
    djvu2hocr -p $i $f | sed 's/ocrx/ocr/g' > `printf "pg%04d.html" $i`
    ddjvu -format=tiff -page=$i $f `printf "pg%04d.tiff" $i`
done

pdfbeads -o ${f/djvu/pdf};

rm ./pg*.html ./pg*.tiff ./pg*.jbig2 ./pg*.sym ./pg*.jpg
