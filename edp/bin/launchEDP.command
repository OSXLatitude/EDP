#!/bin/sh
printf "\e[8;15;75;t"
cd "`dirname "$0"`"
clear
sudo killall php
sudo ../php -S 127.0.0.1:11250 -t /Extra/EDP/bin/html &
sleep 1;
sudo php launch.php
