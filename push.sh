#!/bin/sh
set -e

vendor/bin/phpunit

(git push) || true

git pull

git add .


read -p " Enter commit message: " message
echo  " Your commit message is  $message !"

git commit -m " $message "

git push 

