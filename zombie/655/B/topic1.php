<?PHP

/* Display query  */

$topic = $top1;

/* Build query statement */
	
    $query = "SELECT date, text, count  
	FROM Hashtag_Stats_Dim
	WHERE date BETWEEN $date1 AND $date2 
	and text = $topic
	ORDER BY date;";

/* Run query, receive results */

$rs = mysql_query($query) or die(mysql_error());

/* Loop through all query results and print to screen */

   $ary_top1 = array();
   
while ($topic1 = mysql_fetch_array($rs))
{
$ary_top1[] = $topic1;
/*   printf("Date: %s  Topic: %s  Count: %s ", $topic1[0], $topic1[1], $topic1[2]);  
   	echo "<br \>"; */
	}
?>