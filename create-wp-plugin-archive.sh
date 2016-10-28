#!/bin/sh

# Zip "Add Media Buttons" Wordpress Plugin, with latest tag name contained in filename.

cd add-media-buttons && zip -r ../wp-add-media-buttons-`git describe --abbrev=0`.zip .
