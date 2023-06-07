#!/bin/bash

##########################################
#	getuserlist.sh
#	- read cryousers
#	- read quotausers
#	- create intersection lists
#	Last update 22.05.2023
#	Juan.Castillo@biophys.mpg.de
########################################


#!/bin/bash

# File paths
cryo_file="/cryo/sbdata/EM/projects/jucastil/cryousers.txt"
quota_file="/home/admin/bin/quotausers.txt"
cryo_only_file="cryoonly.txt"
quota_only_file="quotaonly.txt"
both_file="both.txt"

# Read usernames from cryousers.txt into an array
readarray -t cryo_users < "$cryo_file"

# Read usernames from quotausers.txt into an array
readarray -t quota_users < "$quota_file"

# Initialize arrays for cryo-only, quota-only, and common users
declare -a cryo_only
declare -a quota_only
declare -a both

# Find cryo-only users
for user in "${cryo_users[@]}"; do
    if ! grep -q "^$user$" "$quota_file"; then
        cryo_only+=("$user")
    else
        both+=("$user")
    fi
done

# Find quota-only users
for user in "${quota_users[@]}"; do
    if ! grep -q "^$user$" "$cryo_file"; then
        quota_only+=("$user")
    fi
done

# Write cryo-only users to cryoonly.txt
printf "%s\n" "${cryo_only[@]}" > "$cryo_only_file"

# Write quota-only users to quotaonly.txt
printf "%s\n" "${quota_only[@]}" > "$quota_only_file"

# Write common users to both.txt
printf "%s\n" "${both[@]}" > "$both_file"

echo "Operation completed successfully."


