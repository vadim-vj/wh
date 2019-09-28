#!/bin/bash

POSTS_PATH=posts
BUILD_PATH=../docs

for d in $POSTS_PATH/*; do
  if [ -d "$d" ]; then
    POST_HTML=$d/index.html
    POST_HTML_INTENDED=temp.html
    POST_JSON=$d/settings.json
    GENERATED_HTML=$BUILD_PATH/`basename $d`.html

    sed 's/^/    /' $POST_HTML > $POST_HTML_INTENDED
    sed -e "/<div id=\"content\">/r$POST_HTML_INTENDED" index.html > $GENERATED_HTML
    sed -i "s/####TITLE####/`./jq -r '.title // empty' $POST_JSON`/" $GENERATED_HTML
    sed -i "s/####DATE####/`./jq -r '.date // empty' $POST_JSON`/" $GENERATED_HTML

    rm $POST_HTML_INTENDED
  fi
done
