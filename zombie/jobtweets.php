<!doctype = html>
<html>
<?php
include("header.php");
?>

<form action = "mentiondate.php" method = "POST" name = "form1">
	Jobs:	<input type ="text" name="jobs" value ="<?php echo $_POST['jobs'] ?>"> (comma separated)<br><br>
	Start Date:	<input type="text" name="s_date" value ="<?php echo $_POST['s_date'] ?>"> (yyyy-mm-dd)<br><br>
	End Date:	<input type="text" name="e_date" value ="<?php echo $_POST['e_date'] ?>"> (yyyy-mm-dd)<br><br>
	<input type="submit" value="Generate">
	<hr>
</form>
<?php
if (isset($_POST['jobs'])&&isset($_POST['s_date'])&&isset($_POST['e_date'])){
$jobs = $_POST['jobs'];
$date = $_POST['s_date'];
$date = $_POST['e_date'];
$title = "Tweets per day for jobs ".$jobs." between ".$s_date." and ".$e_date;

$con = mysql_connect('sociotechnical.ischool.drexel.edu', 'tweeterfour', 'seniordesign');
mysql_select_db('twitteranalyze', $con);

if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  $arrayjobs = split($jobs,',');
  $data = array();
  foreach ($arrayjobs as $job){
	$rs = mysql_query( 'select A.date as adate,B.count as counter from (select date, job_id from Tweet_Stats_Dim
		where date >= "'.$s_date.'"
		and date <= "'.$e_date.'") as A left outer join (select date, job_id, count from Tweet_Stats_Dim where job_id in ('.$job.')) as B
		on A.date=B.date
		group by B.job_id, A.date
		order by B.job_id, A.date
		;');
	$rows= array();
	while($row = mysql_fetch_assoc($rs))
	{
		$rows[] = $row;
		//echo $row['hashtag']." ".$row['counter']." <br>";
	}
	$jobdata = array("job"->$job , "data"->$rows,);
	$data[] = $jobdata;
  }
   include("linegraph.php");
  
}
?>
</html>
  
  
	
	
	
	
	
	
	
	