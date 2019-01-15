#!/bin/sh
for dir in *; do
    if [ -d "${dir}" ]; then
        echo "$dir"
        cd "$dir"
        for file in *.mp4; do 
            target=`basename "$file" ".mp4"`
            echo "$file"
            ffmpeg -i "$file" -y -vf  "thumbnail,scale=640:360" -frames:v 1 $target.png
            mediainfo "$file" --Output=HTML > $target".info.html"
        done
        cd ".."
    fi
done