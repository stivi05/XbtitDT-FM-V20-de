You need XBT rev 1983 to use this patch !!

here is a how to 

svn co -r 1983 http://xbt.googlecode.com/svn/trunk/xbt/misc xbt/misc

svn co -r 1983 http://xbt.googlecode.com/svn/trunk/xbt/Tracker xbt/Tracker

copy ( overwrite ) the 2 files in the folder CHANGED FILES FOR REV.1983 into Tracker folder

cd xbt/Tracker

./make.sh

cp xbt_tracker.conf.default xbt_tracker.conf

more info about how to install XBT 
http://websitecustomizers.net/index.php/topic,1198.0.html
