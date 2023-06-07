#!/bin/bash

##########################################
#	getmmrepdata
#	- read last "X" points from mmrepquota
#	- copy results to quota_cryo and quota_local
#	Last update 22.05.2023
#	Juan.Castillo@biophys.mpg.de
########################################

# Set the name of the CSV files
CSV_FILE_LOCAL="/home/admin/logs/mmrepquotas/jawong.csv"
CSV_FILE_CRYO="/cryo/sbdata/EM/projects/jucastil/mmrepquotas/jwong.csv"

# Set the name of the output file
OUTPUT_FILE_LOCAL="/root/Dockers/usermon/app/quota_local/jawong.csv"
OUTPUT_FILE_CRYO="/root/Dockers/usermon/app/quota_cryo/jawong.csv"

rm $OUTPUT_FILE_LOCAL
rm $OUTPUT_FILE_CRYO

touch $OUTPUT_FILE_LOCAL
touch $OUTPUT_FILE_CRYO

# Get the last 300 lines of the CSV file and write them to a temporary file
tail -n 35 $CSV_FILE_LOCAL > temp.csv
# LOCAL header
HEADER="date,GB,nfiles"
echo $HEADER >> $OUTPUT_FILE_LOCAL
tail -n 35 temp.csv >> $OUTPUT_FILE_LOCAL
rm temp.csv

# Get the last 300 lines of the CSV file and write them to a temporary file
tail -n 350 $CSV_FILE_CRYO > temp.csv
# CRYO header (it's the same!)
HEADER="date,GB,nfiles"
echo $HEADER > $OUTPUT_FILE_CRYO
tail -n 35 temp.csv >> $OUTPUT_FILE_CRYO
rm temp.csv
