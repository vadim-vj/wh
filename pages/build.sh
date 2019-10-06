#!/bin/bash

BUILD_PATH=../docs

if [ "$1" == "clean" ]; then
  rm $BUILD_PATH/*.html
  rm $BUILD_PATH/*.css
  rm $BUILD_PATH/*.js

else
  POSTS_PATH=posts
  POST_HTML_INTENDED=temp.html
  INTEND_PATTERN='s|^|    |'
  declare -A TITLES
  declare -A DATES
  declare -a GENERATED

  . ./tags.sh

  for d in $POSTS_PATH/*; do
    if [ -d "$d" ]; then
      POST_MD=$d/index.md
      POST_HTML=$d/index.html
      POST_SETTINGS=$d/settings.sh
      GENERATED_NAME=`basename $d`.html
      GENERATED_HTML=$BUILD_PATH/$GENERATED_NAME

      if [ -s "$POST_HTML" ]; then
        sed "$INTEND_PATTERN" $POST_HTML > $POST_HTML_INTENDED

      else
        if [ -s "$POST_MD" ]; then
          markdown $POST_MD | sed '/^$/d' | sed "$INTEND_PATTERN" > $POST_HTML_INTENDED

        else
          continue
        fi
      fi

      sed "/<div id=\"content\">/r$POST_HTML_INTENDED" index.html > $GENERATED_HTML

      title=
      date=


      if [ -f "$POST_SETTINGS" ]; then
        . $d/settings.sh

        if [ "$GENERATED_NAME" == "index.html" ]; then
          INDEX_FILE=$GENERATED_HTML
          INDEX_TITLE=$title

        else
          TITLES[$GENERATED_NAME]=$title
          DATES[$GENERATED_NAME]=$date
        fi
      fi

      sed -i "s|####TITLE####|$title|" $GENERATED_HTML
      sed -i "s|####DATE####|`[[ $date ]] && LC_TIME="C.UTF-8" date --date="$date" "+%a %d %b %Y, %R"`|" $GENERATED_HTML

      GENERATED+=($GENERATED_HTML)
    fi
  done

  # TODO: sort DATES

  truncate -s0 $POST_HTML_INTENDED
  for KEY in "${!DATES[@]}"; do
    echo "<li><a href=\"$KEY\">${TITLES[$KEY]}</a></li>" >> $POST_HTML_INTENDED
  done

  sed -i "$INTEND_PATTERN" $POST_HTML_INTENDED
  for FILE in "${GENERATED[@]}"; do
    sed -i "/<ul id=\"nav\">/r$POST_HTML_INTENDED" $FILE
    sed -i "s|####MAIN_TITLE####|$INDEX_TITLE|" $FILE
  done

  sed -i 's|^|  |' $POST_HTML_INTENDED
  sed -i "/<ul id=\"nav-main\">/r$POST_HTML_INTENDED" ${INDEX_FILE}

  rm $POST_HTML_INTENDED
  cp index.css index.js $BUILD_PATH/
fi
