<!DOCTYPE HTML>
<html>
<head>
<title>SB Cloud Monitor</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script src="sorttable.js"></script>
<script>
		function myFunction() {
  			var input, filter, table, tr, td, i, txtValue;
  			input = document.getElementById("myInput");
  			filter = input.value.toUpperCase();
  			table = document.getElementById("myTable");
  			tr = table.getElementsByTagName("tr");
  			for (i = 0; i < tr.length; i++) {
    				td = tr[i].getElementsByTagName("td")[0];
    				if (td) {
      					txtValue = td.textContent || td.innerText;
      					if (txtValue.toUpperCase().indexOf(filter) > -1) {
        					tr[i].style.display = "";
      					} else {
        					tr[i].style.display = "none";
      					}
    				}       
  			}
		}
</script>	
<script>
window.onload = function () {
var chart = new CanvasJS.Chart("chartCloudSBDATA", {
    animationEnabled: true,
    zoomEnabled: true,
    theme: "light2",
    title:{
        text: "User Impact: LOCAL"
    },
    axisX: {
        title:"LOCAL size (G)",
        minimum: -10000,
        maximum: 150000,
        gridThickness: 1
    },
    axisY:{
		minimum: -200000,
		maximum: 4000000,
        title: "LOCAL total files"
    },
    data: [{
        type: "bubble",
        toolTipContent: "<b>Username: {name}</b><br/>LOCAL (G): {x} <br/> LOCAL (inodes): {y} <br/> CRYO (G): {z}",
        dataPoints: [

{ x:11531, y:440603, z:16370,  name: "ahagip"},
{ x:14, y:8229, z:1414,  name: "analtmey"},
{ x:134182, y:750592, z:92228,  name: "biintroi"},
{ x:35531, y:518368, z:29151,  name: "bomurphy"},
{ x:136, y:10659, z:193,  name: "chkunz"},
{ x:21929, y:1145026, z:262704,  name: "cryosprc"},
{ x:17560, y:636845, z:57055,  name: "diwu"},
{ x:27748, y:1306416, z:35783,  name: "eilaube"},
{ x:606, y:38851, z:7775,  name: "iskhusai"},
{ x:38739, y:1353481, z:97315,  name: "javonck"},
{ x:1, y:28, z:1,  name: "jawiefer"},
{ x:3690, y:51167, z:1,  name: "jesachwe"},
{ x:1, y:150, z:1484,  name: "joschill"},
{ x:29, y:1109, z:3215,  name: "jucastil"},
{ x:1, y:4, z:62935,  name: "kakayast"},
{ x:131637, y:2325664, z:83325,  name: "ledietri"},
{ x:255, y:5107, z:0,  name: "mabernha"},
{ x:44534, y:1135027, z:16469,  name: "macentol"},
{ x:1, y:1297, z:3,  name: "matuijte"},
{ x:28319, y:1494244, z:95425,  name: "mayin"},
{ x:29852, y:967248, z:72883,  name: "niklusch"},
{ x:73131, y:1772963, z:32,  name: "oeyildiz"},
{ x:116863, y:1597163, z:22849,  name: "olpfeil"},
{ x:7036, y:1492061, z:37092,  name: "paornela"},
{ x:4876, y:236738, z:12443,  name: "rakhera"},
{ x:14282, y:741358, z:38154,  name: "rasteinh"},
{ x:2179, y:31824, z:6199,  name: "retanigu"},
{ x:31937, y:505459, z:62077,  name: "samehlma"},
{ x:4063, y:174489, z:1,  name: "siprinz"},
{ x:18975, y:862040, z:37890,  name: "sischnei"},
{ x:8557, y:539775, z:35002,  name: "thgeweri"},
{ x:7663, y:944205, z:17858,  name: "vidubach"},
{ x:31339, y:3943834, z:3900,  name: "wekuehlb"},
{ x:32, y:147425, z:11108,  name: "yolee"},
{ x:1, y:23096, z:800,  name: "yvhellmi"},

  ]
    }]
});
chart.render();

}




</script>
</head>
<body>

<div align="center">
 <h1 >Dept. Structural Biology</h1>
 <img src="mpibp_logo_webnotext.gif" alt="MPIBP logo"></div>
 <div align="center"><H1><B>SB Online Monitor: User Impact</B></H1>
<br> 
<input type="button" style="background-color:lime; padding: 10px; border:none;" onClick="window.location ='http://sbdoc.sb.biophys.mpg.de/data/'" value="Back to main"/> 
<input type="button" style="background-color:yellow; padding: 10px; border:none;" onClick="window.location ='http://sbdoc.sb.biophys.mpg.de/storage/index_cryo.php'" value="Show CRYO bubbles"/>
<input type="text" style="height:35px; width:200px; font-family: Arial, Helvetica, sans-serif;" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name"></H1>


<h2>Last Update 2023-06-07-09h-30m</h2> 
<h2>Total Instances 35</h2>
 <br>


<div id="chartCloudSBDATA" style="height: 500px; width: 80%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<style>
		table { border-collapse: collapse; width: 100%;}
		th, td { text-align: right; padding: 8px; }
		tr:nth-child(even) {background-color: #f2f2f2;}
</style> 

<style>
	* {
  		box-sizing: border-box;
	  }

	  #myInput {
  		background-image: url('searchicon.png');
  		background-position: 10px 10px;
 		 background-repeat: no-repeat;
  		width: 100%;
  		font-size: 16px;
  		padding: 12px 20px 12px 40px;
  		border: 1px solid #ddd;
  		margin-bottom: 12px;
	  }

	  #myTable {
  		border-collapse: collapse;
  		width: 100%;
  		border: 1px solid #ddd;
  		font-size: 18px;
	  }

	  #myTable th, #myTable td {
  		text-align: right;
  		padding: 12px;
	  }

	  #myTable tr {
 		 border-bottom: 1px solid #ddd;
	  }

	  #myTable tr.header, #myTable tr:hover {
  		background-color: #f1f1f1;
	  }
</style>


<table class="sortable" id="myTable" style=" float: center; font-size:medium; border: 1px solid #e3e3e3; background-color: #f2f2f2; width: 80%; border-radius: 6px; -webkit-border-radius: 6px; -moz-border-radius: 6px; margin:0 10px; ">

<br><br>
<h2>Tabulated values. Click on the column to order. Colour code: First step indicates >0.5M, each gradient step +1M until a max of 4M </h2>
<br><br>
<th>User</th> <th>Port</th> <th>Password </th> <th>Link</th> <th>LOCAL (G)</th> <th>LOCAL (nfiles)</th> <th> CRYO (G)</th> <th> CRYO (nfiles)</th>  
<tr bgcolor="white" align="center"> <td width="50px">ahagip</td><td>8110 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8110"> ahagip  </a> </td> <td> 11531</td><td> 440603 </td><td> 16370 </td><td> 1230013 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">analtmey</td><td>8120 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8120"> analtmey  </a> </td> <td> 14</td><td> 8229 </td><td> 1414 </td><td> 148422 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">biintroi</td><td>8130 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8130"> biintroi  </a> </td> <td> 134182</td><td> 750592 </td><td> 92228 </td><td> 8746081 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">bomurphy</td><td>8140 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8140"> bomurphy  </a> </td> <td> 35531</td><td> 518368 </td><td> 29151 </td><td> 1584524 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">chkunz</td><td>8150 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8150"> chkunz  </a> </td> <td> 136</td><td> 10659 </td><td> 193 </td><td> 20233 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">cryosprc</td><td>8160 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8160"> cryosprc  </a> </td> <td> 21929</td><td> 1145026 </td><td> 262704 </td><td> 17655532 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">diwu</td><td>8170 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8170"> diwu  </a> </td> <td> 17560</td><td> 636845 </td><td> 57055 </td><td> 1450430 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">eilaube</td><td>8180 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8180"> eilaube  </a> </td> <td> 27748</td><td> 1306416 </td><td> 35783 </td><td> 1408750 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">iskhusai</td><td>8190 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8190"> iskhusai  </a> </td> <td> 606</td><td> 38851 </td><td> 7775 </td><td> 1763675 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">javonck</td><td>8200 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8200"> javonck  </a> </td> <td> 38739</td><td> 1353481 </td><td> 97315 </td><td> 11897362 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">jawiefer</td><td>8210 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8210"> jawiefer  </a> </td> <td> 1</td><td> 28 </td><td> 1 </td><td> 2442 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">jesachwe</td><td>8220 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8220"> jesachwe  </a> </td> <td> 3690</td><td> 51167 </td><td> 1 </td><td> 2 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">joschill</td><td>8230 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8230"> joschill  </a> </td> <td> 1</td><td> 150 </td><td> 1484 </td><td> 146328 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">jucastil</td><td>8240 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8240"> jucastil  </a> </td> <td> 29</td><td> 1109 </td><td> 3215 </td><td> 67187 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">kakayast</td><td>8250 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8250"> kakayast  </a> </td> <td> 1</td><td> 4 </td><td> 62935 </td><td> 88630 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">ledietri</td><td>8260 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8260"> ledietri  </a> </td> <td> 131637</td><td> 2325664 </td><td> 83325 </td><td> 999296 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">mabernha</td><td>8270 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8270"> mabernha  </a> </td> <td> 255</td><td> 5107 </td><td> 0 </td><td> 1 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">macentol</td><td>8280 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8280"> macentol  </a> </td> <td> 44534</td><td> 1135027 </td><td> 16469 </td><td> 1147421 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">matuijte</td><td>8290 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8290"> matuijte  </a> </td> <td> 1</td><td> 1297 </td><td> 3 </td><td> 9 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">mayin</td><td>8300 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8300"> mayin  </a> </td> <td> 28319</td><td> 1494244 </td><td> 95425 </td><td> 6799221 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">niklusch</td><td>8310 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8310"> niklusch  </a> </td> <td> 29852</td><td> 967248 </td><td> 72883 </td><td> 7878733 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">oeyildiz</td><td>8320 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8320"> oeyildiz  </a> </td> <td> 73131</td><td> 1772963 </td><td> 32 </td><td> 4252 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">olpfeil</td><td>8330 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8330"> olpfeil  </a> </td> <td> 116863</td><td> 1597163 </td><td> 22849 </td><td> 1326512 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">paornela</td><td>8340 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8340"> paornela  </a> </td> <td> 7036</td><td> 1492061 </td><td> 37092 </td><td> 2056752 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">rakhera</td><td>8350 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8350"> rakhera  </a> </td> <td> 4876</td><td> 236738 </td><td> 12443 </td><td> 1176919 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">rasteinh</td><td>8360 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8360"> rasteinh  </a> </td> <td> 14282</td><td> 741358 </td><td> 38154 </td><td> 4799577 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">retanigu</td><td>8370 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8370"> retanigu  </a> </td> <td> 2179</td><td> 31824 </td><td> 6199 </td><td> 954306 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">samehlma</td><td>8380 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8380"> samehlma  </a> </td> <td> 31937</td><td> 505459 </td><td> 62077 </td><td> 3484902 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">siprinz</td><td>8390 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8390"> siprinz  </a> </td> <td> 4063</td><td> 174489 </td><td> 1 </td><td> 2 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">sischnei</td><td>8400 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8400"> sischnei  </a> </td> <td> 18975</td><td> 862040 </td><td> 37890 </td><td> 3720919 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">thgeweri</td><td>8410 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8410"> thgeweri  </a> </td> <td> 8557</td><td> 539775 </td><td> 35002 </td><td> 1262431 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">vidubach</td><td>8420 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8420"> vidubach  </a> </td> <td> 7663</td><td> 944205 </td><td> 17858 </td><td> 6647676 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">wekuehlb</td><td>8430 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8430"> wekuehlb  </a> </td> <td> 31339</td><td> 3943834 </td><td> 3900 </td><td> 827166 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">yolee</td><td>8440 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8440"> yolee  </a> </td> <td> 32</td><td> 147425 </td><td> 11108 </td><td> 250701 </td></tr>
<tr bgcolor="white" align="center"> <td width="50px">yvhellmi</td><td>8450 </td><td> BIOLBIOL </td><td> <a href="http://sirocco.sb.biophys.mpg.de:8450"> yvhellmi  </a> </td> <td> 1</td><td> 23096 </td><td> 800 </td><td> 141279 </td></tr>
 
</table><br><br><br><br><br>
<hr><br><br><br></DIV>
</body></html>

