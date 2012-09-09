<!doctype = html>
<html>
<?php
include("header.php");
?>

<form action = "mentiondate.php" method = "POST" name = "form1">
	Date:	<input type="text" name="date" value ="<?php echo $_POST['date'] ?>"> (yyyy-mm-dd)<br><br>
	<input type="submit" value="Generate">
	<hr>
</form>
<?php
if (isset($_POST['date'])){

$date = $_POST['date'];
$title = "Top Mentions on ".$date;

$con = mysql_connect('sociotechnical.ischool.drexel.edu', 'tweeterfour', 'seniordesign');
mysql_select_db('twitteranalyze', $con);

  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  $rs = mysql_query( 'select screen_name as name, count as counter
		from Mention_Stats_Dim
		where date = ("'.$date.'")
		order by count DESC
		limit 25');
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