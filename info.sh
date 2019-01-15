#!/bin/bash
for file in *.mp4; do
  basename=`basename $file`
  mediainfo $file --Output=HTML > "_info_"$basename".info.html"
done
