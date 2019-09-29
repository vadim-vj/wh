#!/bin/bash

BUILD_PATH=../docs

if [ "$1" == "clean" ]; then
  rm $BUILD_PATH/*.html

else
  POSTS_PATH=posts
  POST_HTML_INTENDED=temp.html
  INTEND_PATTER='s/^/    /'

  for d in $POSTS_PATH/*; do
    if [ -d "$d" ]; then
      POST_MD=$d/index.md
      POST_HTML=$d/index.html
      POST_JSON=$d/settings.json
      GENERATED_HTML=$BUILD_PATH/`basename $d`.html

      if [ -s $POST_HTML ]; then
        sed "$INTEND_PATTER" $POST_HTML > $POST_HTML_INTENDED

      else
        if [ -s $POST_MD ]; then
          markdown $POST_MD | sed '/^$/d' | sed "$INTEND_PATTER" > $POST_HTML_INTENDED

        else
          continue
        fi
      fi

      sed -e "/<div id=\"content\">/r$POST_HTML_INTENDED" index.html > $GENERATED_HTML
      sed -i "s/####TITLE####/`./jq -r '.title // empty' $POST_JSON`/" $GENERATED_HTML
      sed -i "s/####DATE####/`./jq -r '.date // empty' $POST_JSON`/" $GENERATED_HTML
    fi
  done

  rm $POST_HTML_INTENDED
fi

