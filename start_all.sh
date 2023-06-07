#!/bin/bash

# Check the number of arguments
if [ "$#" -ne 1 ]; then
    echo "Usage: $0 USERFILE.txt"
    exit 1
fi

start=`date +%s`
echo " ----------------------------------------"
echo "  "`date +%Y-%m-%d%t%H:%M` ": start_all STARTED "
echo " ----------------------------------------"


startport=8100;
for i in `cat /root/Dockers/usermon/both.txt`; do 
	startport=$((startport+10))
	#echo $i " " $startport; 
	./start.sh $i $startport BIOLBIOL
done

end=`date +%s`
runtime=$((end-start))
echo "  "`date +%Y-%m-%d%t%H:%M` ": Runtime (in seconds) : " $runtime
echo " -----------------------------------------------------------------"
echo "  "`date +%Y-%m-%d%t%H:%M` ": getmmrepdata_both FINISHED "
echo " -----------------------------------------------------------------"
