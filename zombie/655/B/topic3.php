<?PHP

/* Display query  */

$topic = $top3;

/* Build query statement */
	
    $query = "SELECT date, text, count  
	FROM Hashtag_Stats_Dim
	WHERE date BETWEEN $date1 AND $date2 
	and text = $topic
	ORDER BY date;";

/* Run query, receive results */

$rs = mysql_query($query) or die(mysql_error());

/* Loop through all query results and print to screen */

   $ary_top3 = array();
   
while ($topic3 = mysql_fetch_array($rs))
{
$ary_top3[] = $topic3;
}
?>