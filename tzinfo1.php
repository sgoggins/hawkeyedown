<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>TwitterZombie Info</title>
</head>
<body>

<h2>TwitterZombie</h2>

<?php
//
// Establish database connection
//

$server   = "127.0.0.1";
$username = "tweeter";
$password = "purple865monk";
$database = "twitterinblack";

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
$info_query = "SELECT tweet.job_id, job.state, description, COUNT(*) as tweets, query, since_id_str FROM job, tweet WHERE (job.job_id = tweet.job_id) AND (job.state > 0) GROUP BY job_id ORDER BY job_id";
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
    $job_count = $row['tweets'];
    echo("<tr>\n");
    echo("<td>Job ID: $job_id</td><td>Job State: $job_state</td><td>Since ID: $job_since_id</td><td>Tweets: $job_count</td><td>Description: $job_description</td><td>Query: $job_query</td>\n"); 
	echo("</tr>\n");
 
}

echo("</table>\n");

$epoch_min = floor(time()/60); // minutes since the Unix Epoch (January 1 1970 00:00:00 GMT)
echo("<br>Zombie time: $epoch_min\n");
?>

</body>
</html>
