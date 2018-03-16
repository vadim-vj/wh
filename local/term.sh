#!/bin/bash
curr_path=$(pwd)
new_path=${curr_path#/media/vadim/a467ab96-1580-4d46-a478-8768794a3e05/public_html/}

if [[ ! $curr_path -ef $new_path ]]; then
  cd ~/Projects/$new_path
fi

exec /bin/bash
