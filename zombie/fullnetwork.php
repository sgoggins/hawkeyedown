<!doctype = html>
<?php include("header.php"); ?>
<html>
<form action = "fullnetwork.php" method = "POST" name = "form1">
	Jobs:	<input type ="text" name="jobs" value ="<?php echo $_POST['jobs'] ?>"> (comma separated)<br><br>
	<input type="submit" value="Generate">
	<hr>
</form>
<?php
if (isset($_POST['jobs']) ){
$jobs = $_POST['jobs'];
$title = "Full Direct Message Network for Jobs ".$jobs ;

$con = mysql_connect('sociotechnical.ischool.drexel.edu', 'tweeterfour', 'seniordesign');
mysql_select_db('twitteranalyze', $con);

  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
   $rs = mysql_query("select from_user_id_str, to_user_id_str, count(*) as counter from tweet_analyze
		where job_id in (".$jobs.")
		and to_user_name is not null
		and to_user_name !=''
		and to_user_name != from_user_name
		group by from_user_name, to_user_name
		order by counter desc
		limit 500");
		
	$rows= array();
	$users = array();
	$links = array();
	while($row = mysql_fetch_assoc($rs))
	{
		$u1=false;
		$u2=false;
		for($i =0; $i < count($users); $i++){
			if ($row['from_user_id_str'] == $users[$i]){
				$u1 = true;
			}
			if ($row['to_user_id_str'] == $users[$i]){
				$u2 = true;
			}
		}
		if($u1==false){
			$u = $row['from_user_id_str'];
			$users[] = $u;
		}
		if($u2==false){
			$u = $row['to_user_id_str'];
			$users[] = $u;
		}
		
	// connections
	
		$user1 = $row['to_user_id_str'];
		$user2 = $row['from_user_id_str'];
		$value = $row['counter'];

		if ( intval($user2) < intval($user1)){
			$temp = $user2;
			$user2 = $user1;
			$user1 = $temp;
		}
		
		for ($i = 0 ; $i < count($users); $i++){
			if ($users[$i] == $user1){
				$u1index = $i;
			}
			if ($users[$i]== $user2){
				$u2index = $i;
			}
		}
		
		$present = false;
		for($i = 0; $i<count($links);$i++){
			if ($links[$i]['source'] == $u1index){
				if ($links[$i]['target'] == $u2index){
					$links[$i]['weight'] += $value;
					$present = true;
				}
			}
		}
		if ($present == false){
			$link = array('source'=>$u1index , 'target'=>$u2index , 'weight'=>($value));
			$links[] = $link;
		}
		

	}
	
	for ($i = 0; $i < count($links); $i++) {
		$links[$i]['weight'] = 1-(1/$links[$i]['weight']);
		//echo $links[$i]['source']." . ".$links[$i]['target']." . ".$links[$i]['weight']."<br>";
	}
	
	$numusers = count($users);
	
	$nodes=array();
	for($i=0;$i<count($users);$i++){
		$node = array('label'=>"");
		$nodes[] = $node;
	}
	

	include('fullgraph.php');
	
}
?>
</html>

  
		
