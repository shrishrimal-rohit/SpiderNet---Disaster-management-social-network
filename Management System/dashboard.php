<?phpecho "123"; exit;$servername = 'localhost';$username = 'root';$password = 'root';$dbname = 'cmpe281proj';$mysqli = new mysqli($servername, $username, $password, $dbname);if($mysqli->connect_error){    die("Connection failed: ". $mysqli->connect_error);}//for pie chart$query = "SELECT instance_name,num_user FROM instance";$qresult= mysqli_query($mysqli,$query);// print_r($qresult);// echo "<br>";// $row = $qresult->fetch_assoc();// print_r($row);// echo "<br>";// echo "<br>";//get dns of police department$query4dnsOfPolice = "SELECT dns from instance where instance_name = 'sanJosePoliceDepartment'";$qresult4dnsOfPolice = mysqli_query($mysqli, $query4dnsOfPolice); $res4dnsOfPolice = $qresult4dnsOfPolice->fetch_assoc();//for the first line chart//SELECT count(*) from activity where instance_id = 1 and year = 2014$res = array();for ($i = 0; $i < 4; $i++) {	$res[$i][0] = 2014 + $i;	for ($j = 1; $j < 4; $j++) {		$query = "SELECT count(*) from activity where instance_id = " . $j . " and year = ". ($i+2014);		// print_r($query);		// echo "<br>";		$tempRes = mysqli_query($mysqli, $query);		// print_r($tempRes);		// echo "<br>";		$toInt = $tempRes->fetch_assoc()['count(*)'];		// print_r($toInt);		// echo "<br>";		$res[$i][$j] = (int)$toInt;	}}array_unshift($res, array('Year', 'San Jose Police Department', 'San Jose State University', 'San Jose Central Hospital'));//print_r($res);$res = json_encode($res);// while ($res = $qresult->fetch_assoc()) {//     $results[] = $res;// }// $line_chart_data = array();// foreach ($results as $result) {//     $line_chart_data[] = array($result['instance_name'],(int)$result['num_user']);    // }// $line_chart_data = json_encode($line_chart_data);// echo $line_chart_data;// mysqli_free_result($qresult);// mysqli_close($mysqli);?><?php 		//$url="http://localhost/action/message/sendFromSocket";    // $params = array(    //     'message'=> 'TEST' . $datestr,    //     'ossn_ts'=> '1510628890',    //     'ossn_token'=> 'ecef7bdfbe3a429316bba0a492f6a988',    //     'to'=> 3,    // );    $url="http://" . $res4dnsOfPolice['dns'] . "/action/query/online_total";    $curl = curl_init();	curl_setopt($curl, CURLOPT_URL, $url);	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);	curl_setopt($curl, CURLOPT_HEADER, false);	$data = curl_exec($curl);	curl_close($curl);    // $params = array(    //     'email'=> 'hunter.hsieh@sjsu.edu',    // );    // $curl = curl_init($url);    // curl_setopt($curl, CURLOPT_POST, true);    // curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));    // $rsp = curl_exec($curl);    // $info = curl_getinfo($curl);        // curl_close($curl);    //$cookie='PHPSESSID=4b362199f00eb6345fb1280fd9706609';    // $curl = curl_init();    // curl_setopt($curl, CURLOPT_URL, $url);    // //curl_setopt($curl, CURLOPT_COOKIE, $cookie);    // curl_setopt($curl, CURLOPT_POST, true);    // curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));    // $rsp = curl_exec($curl);    // curl_close($curl); //http://localhost/action/message/sendFromSocket?ossn_ts=1510628890&ossn_token=ecef7bdfbe3a429316bba0a492f6a988 ?><html>  <head>    <!--Load the AJAX API-->    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>    <!-- <script> src = "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"</script> -->    <script type="text/javascript">      // Load the Visualization API and the piechart package.      google.charts.load('current', {'packages':['corechart']});      // Set a callback to run when the Google Visualization API is loaded.      google.charts.setOnLoadCallback(drawChart);      // Callback that creates and populates a data table,       // instantiates the pie chart, passes in the data and      // draws it      function drawChart() {      // Create the data table.      var data = new google.visualization.arrayToDataTable([      				['Community', 'Users'],      				<?php       				while ($row = mysqli_fetch_array($qresult)) {      					echo "['".$row["instance_name"]."',".$row["num_user"]."],";      				}      				?>      			]);      // Set chart options      var options = {'title':'Number of Users',                     'width':500,                     'height':300};      // Instantiate and draw our chart, passing in some options.      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));      chart.draw(data, options);    }    </script>    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>    <script type="text/javascript">      google.charts.load('current', {'packages':['corechart']});      google.charts.setOnLoadCallback(drawChart);      function drawChart() {        var data = google.visualization.arrayToDataTable(<?php echo $res?>);                var options = {          title: 'User Activities',          curveType: 'function',          legend: { position: 'bottom' }        };        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));        chart.draw(data, options);      }    </script>    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>    <script type="text/javascript">      google.charts.load('current', {'packages':['corechart']});      google.charts.setOnLoadCallback(drawChart);      function drawChart() {        var data = google.visualization.arrayToDataTable([          ['Task', 'Number of person on line'],          ['Online',     <?php echo (int)$data ?>],          ['Offline',      5],        ]);        var options = {          title: 'San Jose Police Department'        };        var chart = new google.visualization.PieChart(document.getElementById('piechart'));        chart.draw(data, options);      }    </script>        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>    <script type="text/javascript">      google.charts.load('current', {'packages':['corechart']});      google.charts.setOnLoadCallback(drawChart);      function drawChart() {        var data = google.visualization.arrayToDataTable([          ['Year', 'San Jose Police Department', 'San Jose State University', 'San Jose Central Hospital'],                    ['2014',  5,      7, 12],          ['2015',  8,       6, 11],          ['2016',  12,      14, 8],          ['2017',  10,      5, 15],        ]);        var options = {          title: 'Message Amount',          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},          vAxis: {minValue: 0}        };        var chart = new google.visualization.AreaChart(document.getElementById('message'));        chart.draw(data, options);      }    </script>    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>    <script type="text/javascript">      google.charts.load('current', {'packages':['corechart']});      google.charts.setOnLoadCallback(drawChart);      function drawChart() {        var data = google.visualization.arrayToDataTable([          ['Task', 'Number of person online'],          ['Online',     2],          ['Offline',      2],        ]);        var options = {          title: 'San Jose State University'        };        var chart = new google.visualization.PieChart(document.getElementById('sjsu'));        chart.draw(data, options);      }    </script>    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>    <script type="text/javascript">      google.charts.load('current', {'packages':['corechart']});      google.charts.setOnLoadCallback(drawChart);      function drawChart() {        var data = google.visualization.arrayToDataTable([          ['Task', 'Number of person on line'],          ['Online',     2],          ['Offline',      4],        ]);        var options = {          title: 'San Jose Central Hospital'        };        var chart = new google.visualization.PieChart(document.getElementById('hospital'));        chart.draw(data, options);      }    </script>  </head><title>DASHBOARD</title><h1>DASHBOARD</h1>  <body>    <div id="message" style="width: 1300px; height: 300px"></div>	      <table class="list">      <tr>        <th>          <div id="curve_chart" style="width: 700px; height: 300px"></div>        </th>        <th>          <div id="chart_div" style="width:500; height:300">      </tr>    <table class="list">      <tr>        <th>          <div id="piechart" style="width: 400px; height: 300px;"></div>        </th>        <th>          <div id="sjsu" style="width: 400px; height: 300px;"></div>        </th>        <th>          <div id="hospital" style="width: 400px; height: 300px;"></div>        </th>      </tr>      </body></html>