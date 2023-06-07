#!/bin/bash

##########################################
#	getmmrepdata
#	- read last "X" points from mmrepquota
#	- copy results to quota_cryo and quota_local
#	Last update 22.05.2023
#	Juan.Castillo@biophys.mpg.de
########################################

USERNAME=$1

# Check the number of arguments
if [ "$#" -ne 1 ]; then
    echo "Usage: $0 USERNAME"
    exit 1
fi

fill_output_csv(){
	# fill up an APP CSV
	CSVIN=$1
	CSVOUT=$2
	tail -n 300 $CSVIN > temp.csv
	HEADER="date,GB,nfiles" # LOCAL header
	echo $HEADER >> $CSVOUT
	tail -n 300 temp.csv >> $CSVOUT
	rm temp.csv
}

fill_bubbles(){
	
	# fill up a bubbles file for APP plots
	USER=$1	
	CSVFILE=$2
	BUBBLES=$3
	new_z=$4
	
	# get USER values
	original_line=$(grep $USER $BUBBLES)
	new_values=$(tail -1 $CSVFILE)
	new_x=$(echo "$new_values" | awk -F',' '{print $2}')
	new_y=$(echo "$new_values" | awk -F',' '{print $3}')
	
	# check if there is already an entry, if yes, replace it
	if [ -z "$original_line" ]; then
		echo "	User '$USER' not found in bubbles, adding it"
		echo "{ x:"$new_x", y:"$new_y", z:"$new_z",  name: \""$USER"\"}," >> $BUBBLES
	else
		#echo "	Replacing '$USER' bubbles record"
		sed -i "/${original_line//@/\\@}/d" $BUBBLES
		echo "{ x:"$new_x", y:"$new_y", z:"$new_z",  name: \""$USER"\"}," >> $BUBBLES
		#echo "	Done"
	fi
		
}

fill_table(){
	
	USER=$1
	RUNLOG=$2
	TABLE=$3
	
	# get USER values
	original_line=$(grep $USER $TABLE)
	# get USERPORT and PASSWD from the runlog
	USERPORT=$(grep $USER $RUNLOG | awk -F, '{print $2}')
	USERPASS=$(grep $USER $RUNLOG | awk -F, '{print $3}')
	## get the latest values from the CSV files
	USERGB_CRYO=`tail -1 /root/Dockers/usermon/app/quota_cryo/"$USER".csv | awk -F, '{print $2}'`
	USERINODES_CRYO=`tail -1 /root/Dockers/usermon/app/quota_cryo/"$USER".csv | awk -F, '{print $3}'`
	USERGB_LOCAL=`tail -1 /root/Dockers/usermon/app/quota_local/"$USER".csv | awk -F, '{print $2}'`
	USERINODES_LOCAL=`tail -1 /root/Dockers/usermon/app/quota_local/"$USER".csv | awk -F, '{print $3}'`
	
	# check if there is already an entry, if yes, replace it
	if [ -z "$original_line" ]; then
		echo "	User '$USER' not found in table, adding it"
		echo "<tr bgcolor=\"white\" align=\"center\"> <td width=\"50px\">"$USER"</td><td>"$USERPORT "</td><td>" $USERPASS "</td><td> <a href=\"http://sirocco.sb.biophys.mpg.de:"$USERPORT\"">" $USER " </a> </td>" \
		"<td>"  $USERGB_LOCAL"</td><td>"  $USERINODES_LOCAL "</td><td>"  $USERGB_CRYO "</td><td>"  $USERINODES_CRYO "</td></tr>" >> $TABLE
	else
		#echo "	Replacing '$USER' table record"
		sed -i "/$USER/d" $TABLE
		#echo "	Line removed successfully."
		echo "<tr bgcolor=\"white\" align=\"center\"> <td width=\"50px\">"$USER"</td><td>"$USERPORT "</td><td>" $USERPASS "</td><td> <a href=\"http://sirocco.sb.biophys.mpg.de:"$USERPORT\"">" $USER " </a> </td>" \
		"<td>"  $USERGB_LOCAL"</td><td>"  $USERINODES_LOCAL "</td><td>"  $USERGB_CRYO "</td><td>"  $USERINODES_CRYO "</td></tr>" >> $TABLE
		#echo "	Done"
	fi

	
}


# CSV files
CSV_FILE_LOCAL="/home/admin/logs/mmrepquotas/"$USERNAME".csv"
CSV_FILE_CRYO="/cryo/sbdata/EM/projects/jucastil/mmrepquotas/"$USERNAME".csv"
OUTPUT_FILE_LOCAL="/root/Dockers/usermon/app/quota_local/"$USERNAME".csv"
OUTPUT_FILE_CRYO="/root/Dockers/usermon/app/quota_cryo/"$USERNAME".csv"
rm $OUTPUT_FILE_LOCAL
rm $OUTPUT_FILE_CRYO
touch $OUTPUT_FILE_LOCAL
touch $OUTPUT_FILE_CRYO

# debug
#echo "	CSV file LOCAL 	: " $CSV_FILE_LOCAL
#echo "	CSV file CRYO 	: " $CSV_FILE_CRYO
#echo "	Output file LOCAL 	: " $OUTPUT_FILE_LOCAL
#echo "	Output file CRYO 	: " $OUTPUT_FILE_CRYO

# fill the app CSV
fill_output_csv $CSV_FILE_LOCAL $OUTPUT_FILE_LOCAL
fill_output_csv $CSV_FILE_CRYO $OUTPUT_FILE_CRYO

# fill the web reference files
BUBBLES_LOCAL="/root/Dockers/usermon/bubbles_local.part"
BUBBLES_CRYO="/root/Dockers/usermon/bubbles_cryo.part"
BUBBLES_TABLE="/root/Dockers/usermon/bubbles_table.part"
RUN_LOG="/root/Dockers/usermon/usermon_running.log"
Z_LOCAL=`tail -1 /root/Dockers/usermon/app/quota_cryo/$USERNAME.csv | awk -F',' '{print $2}'`
Z_CRYO=`tail -1 /root/Dockers/usermon/app/quota_local/$USERNAME.csv | awk -F',' '{print $2}'`
fill_bubbles $USERNAME $OUTPUT_FILE_LOCAL $BUBBLES_LOCAL $Z_LOCAL
fill_bubbles $USERNAME $OUTPUT_FILE_CRYO $BUBBLES_CRYO $Z_CRYO
fill_table $USERNAME $RUN_LOG $BUBBLES_TABLE






