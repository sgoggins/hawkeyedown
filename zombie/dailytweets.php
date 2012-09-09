<!doctype = html>
<?php include("header.php"); ?>
<html>
<form action = "dailytweets.php" method = "POST" name = "form1">
	Jobs:	<input type ="text" name="jobs" value ="<?php echo $_POST['jobs'] ?>"> (comma separated)<br><br>
	Start Date: <input type ="text" name="s_date" value ="<?php echo $_POST['s_date'] ?>"> (yyyy-mm-dd)<br><br>
	End Date: <input type ="text" name="e_date" value ="<?php echo $_POST['e_date'] ?>"> (yyyy-mm-dd)<br><br>
	<input type="submit" value="Generate">
	<hr>
</form>

<?php
if (isset($_POST['jobs'])&& isset($_POST['s_date'])&& isset($_POST['e_date']) ){
$jobs = $_POST['jobs'];
$job = split(",",$jobs,-1);
$title = "Tweets by Day for Jobs ".$jobs;
$s_date= $_POST['s_date'];
$e_date=$_POST['e_date'];

$con = mysql_connect('sociotechnical.ischool.drexel.edu', 'tweeterfour', 'seniordesign');
mysql_select_db('twitteranalyze', $con);

  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  $alljobs=array();
  $dates = array();
  $max= 0;
  for ($i = 0; $i < count($job); $i++){
	
	$values = array();
	$rs = mysql_query("select A.date,B.count from (select date, job_id from Tweet_Stats_Dim
			where date >= '".$s_date."'
			and date <= '".$e_date."') as A left outer join (select date, job_id, count from Tweet_Stats_Dim where job_id in (".$job[$i].")) as B
			on A.date=B.date
			group by B.job_id, A.date
			order by B.job_id, A.date
			;");
		
		while($row = mysql_fetch_assoc($rs)){
			
			$date= split("-",$row['date'],-1);
			$month = $date[1];
			$day = $date[2];
			$label = "".$month."/".$day;
			
			if($row['count'] == null) $value = 0;
			else $value = $row['count'];
			
			if($value > $max){$max = $value;}
			
			if($i==0){
				$dates[] = $label; 
			}
			$values[] = $value;
			
			//echo $row['date']." ".$row['count']." <br>";
		}
		
		$jobdata = array('jobid'=> $job[$i] , 'values'=>$values);
		$alljobs[] = $jobdata;
   }
	
	include("linegraph.php");
}
?>
</center>
  </html>