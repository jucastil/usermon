#!/bin/bash

start=`date +%s`
echo " ----------------------------------------"
echo "  "`date +%Y-%m-%d%t%H:%M` ": getmmrepdata_both STARTED "
echo " ----------------------------------------"


for i in `cat /root/Dockers/usermon/both.txt`; do /root/Dockers/usermon/getmmrepdata.sh $i; done
#for i in `cat /root/Dockers/usermon/both.txt`; do echo $i; done

tput setaf 1;
echo "	Removing previous webs"
rm -rf /root/Dockers/usermon/web/index.php
rm -rf /root/Dockers/usermon/web/index_cryo.php
tput sgr0;

# build index.php and index_cryo.php
cat /root/Dockers/usermon/web/header_local.part >> /root/Dockers/usermon/web/index.php
cat /root/Dockers/usermon/bubbles_local.part  >> /root/Dockers/usermon/web/index.php
cat /root/Dockers/usermon/web/center_local.part >> /root/Dockers/usermon/web/index.php
cat /root/Dockers/usermon/bubbles_table.part  >> /root/Dockers/usermon/web/index.php
cat /root/Dockers/usermon/web/tail_local.part >> /root/Dockers/usermon/web/index.php

cat /root/Dockers/usermon/web/header_cryo.part >> /root/Dockers/usermon/web/index_cryo.php
cat /root/Dockers/usermon/bubbles_cryo.part  >> /root/Dockers/usermon/web/index_cryo.php
cat /root/Dockers/usermon/web/center_cryo.part >> /root/Dockers/usermon/web/index_cryo.php
cat /root/Dockers/usermon/bubbles_table.part  >> /root/Dockers/usermon/web/index_cryo.php
cat /root/Dockers/usermon/web/tail_cryo.part >> /root/Dockers/usermon/web/index_cryo.php

DATE=`date +%Y-%m-%d-%Hh-%Mm`
VLENGTH=`wc -l /root/Dockers/usermon/usermon_running.log | awk '{print $1}'`
sed -i "s|<h2>Last Update</h2>|<h2>Last Update ${DATE}</h2> |" /root/Dockers/usermon/web/index.php
sed -i "s|<h2>Total Instances</h2>|<h2>Total Instances ${VLENGTH}</h2>|" /root/Dockers/usermon/web/index.php
sed -i "s|<h2>Last Update</h2>|<h2>Last Update ${DATE}</h2> |" /root/Dockers/usermon/web/index_cryo.php
sed -i "s|<h2>Total Instances</h2>|<h2>Total Instances ${VLENGTH}</h2>|" /root/Dockers/usermon/web/index_cryo.php

scp /root/Dockers/usermon/web/index.php sbgamma:/var/www/html/storage/
scp /root/Dockers/usermon/web/index_cryo.php sbgamma:/var/www/html/storage/

end=`date +%s`
runtime=$((end-start))
echo "  "`date +%Y-%m-%d%t%H:%M` ": Runtime (in seconds) : " $runtime
echo " -----------------------------------------------------------------"
echo "  "`date +%Y-%m-%d%t%H:%M` ": getmmrepdata_both FINISHED "
echo " -----------------------------------------------------------------"
