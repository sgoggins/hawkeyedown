<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>TwitterZombie Info</title>
</head>
<body>

<h2>TwitterZombie - by job ID</h2>

<?php
//
// Establish database connection
//

$target_cnt = 70; // Target 70 tweets per min.

// "includes" connection info
include('db_connect_info.txt');

// Connect to server
$db_connection = mysql_connect($server, $username, $password);
if (!$db_connection) {
    die('*** Error: could not connect to database: ' . mysql_error() . "\n");
}

// Select database (schema)
$db_select_result = mysql_select_db($database);
if (!$db_select_result) {
    die('*** Error: could not select database: ' . mysql_error() . "\n");
}

//
// Get info
//
$info_query = "SELECT *, last_count/state as tpm, (last_count/1)-$target_cnt as cnt_error FROM job WHERE job.state > 0 ORDER BY job_id ASC";
$info_result = mysql_query($info_query);
if (!$info_result) {
    die('*** Error: could not fetch jobs: ' . mysql_error() . "\n");
}

//
// Iterate through jobs
//
echo("<table border=\"1\" bgcolor=\"#66cc00\">\n");

while ($row = mysql_fetch_assoc($info_result)) {
	// Get job parameters
    $job_id = $row['job_id'];
    $job_state = $row['state'];
    $job_query = $row['query'];
    $job_since_id = $row['since_id_str'];
    $job_description = $row['description'];
    $last_count = $row['last_count'];
    $last_run = $row['last_run'];
    $tpm = $row['tpm'];
    $error = $row['cnt_error'];
    
    if ($last_count == 0) {
    	$rec_state = "NA";
    } else {
    	$rec_state = floor($target_cnt/$tpm);
    	if ($rec_state < 1 ) $rec_state = 1;
    }
    
    echo("<tr>\n");
    echo("<td>Job ID: $job_id</td><td>Last tweet count: $last_count</td><td>Error: $error</td><td>Job State: $job_state</td><td>Recommended State: $rec_state</td><td>TPM: $tpm</td><td>Last run: $last_run</td><td>Description: $job_description</td><td>Query: $job_query</td><td>Since ID: $job_since_id</td>\n"); 
	echo("</tr>\n");
 
}

echo("</table>\n");

$epoch_min = floor(time()/60); // minutes since the Unix Epoch (January 1 1970 00:00:00 GMT)
echo("<br>Zombie time: $epoch_min\n");
?>

</body>
</html>
