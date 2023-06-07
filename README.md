# Usermon : a docker swarm to monitor users
A serie of scripts that produce a functional swarm with as many ``docker-dash-example-dev`` dockers as users and two php webs.<br>
The webs (``index.php`` and ``index_cryo.php``) contain an overview of all the swarm.

# Configuration
- Build the **docker-dash-example-dev** image. Run the script ``build.sh``. <br>
Note that specific requirements are taken from ``app/requirements.txt``  
- Create the user lists. Run the script ``getuserlists.sh``. <br>
It reads the next "precollected" user lists.<br>
``cryo_file="/cryo/sbdata/EM/projects/jucastil/cryousers.txt"`` <br>
``quota_file="/home/admin/bin/quotausers.txt"``<br>
The output are 3 txt files: <br>
``cryo_only_file="cryoonly.txt"`` Users with only a cryo account<br>
``quota_only_file="quotaonly.txt"`` Users with only a local account<br>
``both_file="both.txt"`` Users with accounts on both places<br>
<br>

# Running and stopping
You can run an instance per user or start a swarm with all the instances at the same time.
- ``start.sh USERNAME PORT PASSWORD`` will create a docker named USERNAME runninng on local PORT protected by PASSWORD
- ``start_all.sh userlist.txt`` will create as many dockers as names in userlist.txt. <br>
The ports will be assigned sequentially. All will have the same password (hardcoded in the script). <br>
To kill all the swarm you can run ``kill_all.sh``.

# Data source
The script ``getmmrepdata.sh USERNAME`` will read the CSV files from the local and cryo storages for USERNAME. <br>

The result is written on three files: <br>
- ``app/quota_local/USERNAME.csv`` where an entry is added for the local storage 
- ``app/quota_cryo/USERNAME.csv`` does the same for the cryo storage
- a USERNAME entry on the "bubble part" files is replaced or added. <br>

The script ``getmmrepdata_all.sh`` will do the same for all users on ``both.txt`` and generate two php files: <br>
- ``index.php`` with a bubble plot and a table with LOCAL username stats
- ``index-cryo.php`` with a bubble plot and a table with CRYO username stats
