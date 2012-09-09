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
        Please select your search criteria below:<br />&nbsp;<br /></p>
        <p>&nbsp;</p>

<form action="process.php" method="POST" name="form1" target="_self">
    Beginning Date: <input type="text" name="date1" value="2012-04-08"> (yyyy-mm-dd) &nbsp;
    Ending Date: <input type="text" name="date2" value="2012-04-30"> (yyyy-mm-dd)<br><br>    
    Topic 1: <input type="text" name="topc1" value="economy">  &nbsp;
	Topic 2: <input type="text" name="topc2" value="education">  &nbsp;
	Topic 3: <input type="text" name="topc3" value="healthcare">  &nbsp;
	Topic 4: <input type="text" name="topc4" value="immigration">  &nbsp;
	Topic 5: <input type="text" name="topc5" value="abortion">  <br /><br />
    <input type="submit" value="Generate">
    <p>&nbsp;</ p>
    <hr>
</form>

</body>

</html>