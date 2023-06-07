#!/bin/bash

#################################$$$##########
#	start.sh
#	- launches a docker dash app for 
#	user $1
#	port $2
#   password $3
#   - record activity on usermon-dockers.txt

USERNAME=$1
USERPORT=$2
USERPASS=$3

# Check the number of arguments
if [ "$#" -ne 3 ]; then
    echo "Usage: $0 USERNAME USERPORT USERPASSWORD"
    exit 1
fi

export CSV_FILENAME_LOCAL="quota_local/"$USERNAME".csv"
export CSV_FILENAME_CRYO="quota_cryo/"$USERNAME".csv"

export APP_TITLE="Storage monitor: "$USERNAME
export HEADER_TEXT="Data plots: "$USERNAME
export REF_VAL_1=25000.0
export REF_VAL_2=1500000.0
export PORT=$USERPORT
export DOCKERNAME=$USERNAME
export DASH_USERNAME=$USERNAME
export DASH_PASSWORD=$USERPASS

# Check if a Docker container with the given name is already running
if docker ps --format '{{.Names}}' | grep -q "^$DOCKERNAME$"; then
    echo "A Docker container with the name $DOCKERNAME is already running."
    echo "Please check the input parameters. Exiting..."
    exit 1
fi


docker run --name $DOCKERNAME -d -p $PORT:$PORT -v "$(pwd)"/app:/app \
-e CSV_FILENAME_LOCAL \
-e CSV_FILENAME_CRYO \
-e APP_TITLE \
-e HEADER_TEXT -e PORT \
-e DASH_USERNAME \
-e DASH_PASSWORD \
--rm docker-dash-example-dev

## get the latest values from the CSV files
USERGB_CRYO=`tail -1 /root/Dockers/usermon/app/quota_cryo/"$USERNAME".csv | awk -F, '{print $2}'`
USERINODES_CRYO=`tail -1 /root/Dockers/usermon/app/quota_cryo/"$USERNAME".csv | awk -F, '{print $3}'`
USERGB_LOCAL=`tail -1 /root/Dockers/usermon/app/quota_local/"$USERNAME".csv | awk -F, '{print $2}'`
USERINODES_LOCAL=`tail -1 /root/Dockers/usermon/app/quota_local/"$USERNAME".csv | awk -F, '{print $3}'`


## stores the details on usermon_running.log
START_LOG="/root/Dockers/usermon/usermon_running.log"
original_line=$(grep "$USERNAME" "$START_LOG")
# Check if the user exists in the original CSV file
if [ -z "$original_line" ]; then
	echo "	User '$USERNAME' not found, adding it"
	echo $USERNAME","$USERPORT","$USERPASS","$USERPORT","$USERNAME","$USERGB_LOCAL","$USERINODES_LOCAL","$USERGB_CRYO","$USERINODES_CRYO >> $START_LOG
else
	echo "	Replacing '$USERNAME' record"
	sed -i "/${original_line//@/\\@}/d" $START_LOG
	echo $USERNAME","$USERPORT","$USERPASS","$USERPORT","$USERNAME","$USERGB_LOCAL","$USERINODES_LOCAL","$USERGB_CRYO","$USERINODES_CRYO >> $START_LOG
	echo "	Done"
fi





#~ echo ":"$USERNAME":"$USERPORT":"$USERPASS":"$USERGB_LOCAL":"$USERINODES_LOCAL":"$USERGB_CRYO":"$USERINODES_CRYO >> /home/admin/logs/usermon-dockers.txt
#~ echo "{ x:"$USERGB_LOCAL",  y:"$USERINODES_LOCAL", z:"$USERGB_CRYO",  name: \""$USERNAME"\"}," >> /home/admin/logs/bubbles_local.part
#~ echo "{ x:"$USERGB_CRYO",  y:"$USERINODES_CRYO", z:"$USERGB_LOCAL",  name: \""$USERNAME"\"}," >> /home/admin/logs/bubbles_cryo.part
#~ echo "<tr bgcolor=\"white\" align=\"center\"> <td width=\"50px\" >" $USERNAME "</td><td>"  $USERPORT "</td><td>"  $USERPASS "</td>" \
     #~ "<td> <a href=\"http://sirocco.sb.biophys.mpg.de:"$USERPORT\"">" $USERNAME " </a> </td>" \
     #~ "<td>"  $USERGB_LOCAL"</td><td>"  $USERINODES_LOCAL "</td><td>"  $USERGB_CRYO "</td><td>"  $USERINODES_CRYO "</td></tr>"  >> /home/admin/logs/bubbles_table.part

#docker run --name usermon -p 8090:8090 -v "$(pwd)"/app:/app --rm docker-dash-example-dev

