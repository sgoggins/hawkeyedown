<!doctype = html>
<!-- Authors 
Mike Litwa
 -->
<html>
<?php
include("header.php");
?>

<form action = "mention.php" method = "POST" name = "form1">
	Jobs:	<input type ="text" name="jobs" value ="<?php echo $_POST['jobs'] ?>"> (comma separated)<br><br>
	<input type="submit" value="Generate">
	<hr>
</form>
<?php
if (isset($_POST['jobs'])){
$jobs = $_POST['jobs'];
$title = "Top Mentions for jobs ".$jobs;

$con = mysql_connect('sociotechnical.ischool.drexel.edu', 'tweeterfour', 'seniordesign');
mysql_select_db('twitteranalyze', $con);

  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  $rs = mysql_query( "select screen_name as name, count(*) as counter
		from mention_analyze
		where job_id in (".$jobs.")
		group by screen_name
		order by counter DESC
		limit 25");
	$rows= array();
	while($row = mysql_fetch_assoc($rs))
	{
		$rows[] = $row;
		//echo $row['hashtag']." ".$row['counter']." <br>";
	}

  
		
 include("display.php");
  
}
?>
</html>