<!DOCTYPE html>
<html> 
	<head> 
		<meta http-equiv="content-type" content="text/html;charset=utf-8"> 
		<title>The Guess Who - Election Topic Heat-map</title>
		<link rel="stylesheet" href="css/style.css"> 
		<script type="text/javascript" src="http://mbostock.github.com/d3/d3.js"></script>
		<!-- <script type="text/javascript" src="./d3.js"></script> -->
		<script type="text/javascript" src="./d3.csv.js"></script>
		<script type="text/javascript" src="./json2.js"></script>
	</head>
	<body>

<!-- ------------------------------------------------------------------------------------------------ --> 
		<h2>The Guess Who - Election Topic Heatmap</h2><hr />

        <p>
        The heat-map below displays an ordinal view of election year topics based on data gathered from Twitter.  
        The scale to the right of the table translates the background color on the heat-map to the relative frequency 
        of the occurrence of a topic keyword.<br />&nbsp;<br />



<?php

/* Include queries and data parsing */

if (isset($_POST['date1'])) {
    $date1 = "'".$_POST['date1']."'";
    }

if (isset($_POST['date2'])) {
    $date2 = "'".$_POST['date2']."'";
    }

if (isset($_POST['topc1'])) {
    $top1 = "'".$_POST['topc1']."'";
    $dsc1 = $_POST['topc1'];
    }

if (isset($_POST['topc2'])) {
    $top2 = "'".$_POST['topc2']."'";
    $dsc2 = $_POST['topc2'];
    }

if (isset($_POST['topc3'])) {
    $top3 = "'".$_POST['topc3']."'";
    $dsc3 = $_POST['topc3'];
    }
    
if (isset($_POST['topc4'])) {
    $top4 = "'".$_POST['topc4']."'";
    $dsc4 = $_POST['topc4'];
    }    

if (isset($_POST['topc5'])) {
    $top5 = "'".$_POST['topc5']."'";
    $dsc5 = $_POST['topc5'];
    }    

echo "You have chosen the topics ".$dsc1.", ".$dsc2.", ".$dsc3.", ".$dsc4.", and ".$dsc5.".</p><p>&nbsp;</p>";

/* connect to remote database */

    $con = mysql_connect('sociotechnical.ischool.drexel.edu', 'tweeterfour', 'seniordesign');
    mysql_select_db('twitteranalyze', $con);

    if (!$con) {
        die('Could not connect: ' . mysql_error());
    }

/* Query for topic 1 */
include("topic1.php");

/* Query for topic 2 */
include("topic2.php");

/* Query for topic 3 */
include("topic3.php");

/* Query for topic 4 */
include("topic4.php");

/* Query for topic 5 */
include("topic5.php");

/* Parse and combine all query results for output */
include("parse.php");


/* Break data into easily digestible elements */
/* based on code found at: */
/* http://stackoverflow.com/questions/1181691/extract-leaf-nodes-of-multi-dimensional-array-in-php */

function printValue($value, $key, $userData) 
{
        //echo "$value\n";
        $userData[] = $value;
}


$result = new ArrayObject();
array_walk_recursive($output, 'printValue', $result);

$counter = count($result);

?>

<div class="blockl">

<div id="viz2"></div> 

<script type="text/javascript"> 

/* Use JSON to make PHP data usable by JavaScript */

var xdata = <?php echo json_encode($result); ?>;

/* Establish row limit based on available data */

var counter = <?php echo $counter; ?>;
var limitrows = (counter/6);

/* Translate topic names from PHP to JavaScript */

var topic1 = <?php echo $top1; ?>;
var topic2 = <?php echo $top2; ?>;
var topic3 = <?php echo $top3; ?>;
var topic4 = <?php echo $top4; ?>;
var topic5 = <?php echo $top5; ?>;

/* Build d3 table - based on code found at */
/* http://christopheviau.com/d3_tutorial/  */

var dataset = [],
tmpDataset = [], i, j;

for (i = 0; i < 1; i++) {
    for (j = 0, tmpDataset = []; j < 1; j++) {
        tmpDataset.push(' ', topic1, topic2, topic3, topic4, topic5);
    }
    dataset.push(tmpDataset);
}

var k = -6;

for (i = 0; i < limitrows; i++) {
	k = k + 6;
		
    for (j = 0, tmpDataset = []; j < 1; j++) {
        tmpDataset.push(
        xdata[k], 
        xdata[k+1], 
        xdata[k+2], 
        xdata[k+3], 
        xdata[k+4],
        xdata[k+5]);
		}
    dataset.push(tmpDataset);
}


d3.select("#viz2")
    .append("table")
    .style("border-collapse", "collapse")
    .style("border", "2px black solid")
    .selectAll("tr")
    .data(dataset)
    .enter().append("tr")
    .selectAll("td")
    .data(function(d){return d;})
    .enter().append("td")
    .style("width", "80px")
    .style("height", "5px")
    .style("border", "1px black solid")
    .style("padding", "5px")
	.style("background",
                    function(data) {
                        if(data==4) { return "#234061";}
                        if(data==3) { return "#365f92";} 
                        if(data==3) { return "#94b3d6";}
                        if(data==2) { return "#b8cce3";}
                        if(data==1) { return "#dce6f0";} 
                        if(data==0) { return "#ffffff";}
                    })
	.style("color",
                    function(data) {
                        if(data==4) { return "#234061";}
                        if(data==3) { return "#365f92";} 
                        if(data==3) { return "#94b3d6";}
                        if(data==2) { return "#b8cce3";}
                        if(data==1) { return "#dce6f0";} 
                        if(data==0) { return "#ffffff";}
                    }) 
	.text(function(d){return d;}) 
	.style("font-size", "12px");	
        </script>

&nbsp;
</div>
<div class="blockr">
<h4>Scale</h4>
Number of times a topic hash-tag is used<br \>
<p>&nbsp;</p>

<table width="80%" height="150" cellpadding="0" cellspacing="0" style="font-size:12px" border="1" >
  <tr>
    <td >Most</td>
    <td bgcolor="#234061">&nbsp;</td>
  </tr>
  <tr>
    <td>|</td>
    <td bgcolor="#365f92">&nbsp;</td>
  </tr>
  <tr>
    <td>|</td>
    <td bgcolor="#94b3d6">&nbsp;</td>
  </tr>
  <tr>
    <td>|</td>
    <td bgcolor="#b8cce3">&nbsp;</td>
  </tr>
  <tr>
    <td>V</td>
    <td bgcolor="#dce6f0">&nbsp;</td>
  </tr>
  <tr>
    <td>Least</td>
    <td bgcolor="#ffffff">&nbsp;</td>
  </tr>
</table>

</div>

<div class="clearfloat"></div>

<p>&nbsp;</p>
<hr />
<p>&nbsp;</p>
<p>&nbsp;</p>        

	</body> 
</html> 