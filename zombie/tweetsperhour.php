<!doctype = html>
<html>
<form action = "index.php" method = "POST" name = "form1">
	Jobs:	<input type ="text" name="jobs" value ="<?php echo $_POST['jobs'] ?>"> (comma separated)<br><br>
	Date:	<input type="text" name="date" value ="<?php echo $_POST['date'] ?>"> (yyyy-mm-dd)<br><br>
	<input type="submit" value="Generate">
	<hr>
</form>
<?php
if (isset($_POST['jobs']) && isset($_POST['date'])){
$jobs = $_POST['jobs'];
$date = $_POST['date'];

$con = mysql_connect('sociotechnical.ischool.drexel.edu', 'tweeterfour', 'seniordesign');
mysql_select_db('twitteranalyze', $con);

  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  $rs = mysql_query( "select lower(text) as hashtag, count(*) as counter
		from hashtag_analyze
		where job_id in (".$jobs.")
		group by lower(text)
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