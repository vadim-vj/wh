#!/bin/bash

BUILD_PATH=../docs

if [ "$1" == "clean" ]; then
  rm $BUILD_PATH/*.html

else
  POSTS_PATH=posts
  POST_HTML_INTENDED=temp.html
  INTEND_PATTER='s/^/    /'

  . ./tags.sh

  for d in $POSTS_PATH/*; do
    if [ -d "$d" ]; then
      POST_MD=$d/index.md
      POST_HTML=$d/index.html
      POST_SETTINGS=$d/settings.sh
      GENERATED_HTML=$BUILD_PATH/`basename $d`.html

      if [ -s "$POST_HTML" ]; then
        sed "$INTEND_PATTER" $POST_HTML > $POST_HTML_INTENDED

      else
        if [ -s "$POST_MD" ]; then
          markdown $POST_MD | sed '/^$/d' | sed "$INTEND_PATTER" > $POST_HTML_INTENDED

        else
          continue
        fi
      fi

      sed "/<div id=\"content\">/r$POST_HTML_INTENDED" index.html > $GENERATED_HTML

      title=
      date=

      if [ -f "$POST_SETTINGS" ]; then
        . $d/settings.sh
      fi

      sed -i "s/####TITLE####/$title/" $GENERATED_HTML
      sed -i "s/####DATE####/`LC_TIME="C.UTF-8" date --date="$date" "+%a %d %b %Y, %R"`/" $GENERATED_HTML
    fi
  done

  rm $POST_HTML_INTENDED
fi

