<!DOCTYPE html>
<html>
<head>
    <title>#GayMarriage Word Cloud</title>
	<script type="text/javascript" src="d3.v2.js"></script>
    <script type="text/javascript" src="d3.layout.cloud.js"></script>
</head>
<body>
<?php

//get xml file
$url = "data.xml";
$xml = simplexml_load_file($url);

$alltweets = "";

//create giant string by combining all Tweets together
foreach($xml->ROW as $row) {
    $alltweets = $alltweets . " " . $row->text;
}

//remove quotes marks from the giant string
$alltweets = str_replace("\"", "", $alltweets);
//remove hyperlinks from the string
$pattern = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
$replacement = " ";
$alltweets = preg_replace($pattern, $replacement, $alltweets);

//create a new array by making each word in the giant string its own array element
$allwords = array();
$allwords = explode(" ", $alltweets);

//get unique values and how many times each value appears in the array, furthermore, use filter to remove empty array elements
$wordsandcounts = array_count_values(array_filter($allwords));

//convert the new array containing words and their counts into two separate arrays: one for words and one for counts
$worddata = array();
$sizedata = array();

foreach($wordsandcounts as $word => $count) {
   array_push($worddata, $word);
   array_push($sizedata, $count);
}

//exclude useless words
$exclude = array("a", "at", "in", "as", "is", "the", "with", "on", "off", "when", "where", "them", "it", "who", "for", "Is", "or", "This", "by", "not", "to");
$worddata = array_diff($worddata, $exclude);

?>

<div id="header" style="text-align: center;">
	<p style="font-family: Arial, Helvetica, sans-serif; font-size: 1.1em">When the Twitter universe is buzzing about #gaymarriage, what other things are being mentioned? Let's take a look with this word cloud visualization. The larger the word, the more times it's come up.</p>
</div>

<div id="cloud" style="width: 1000px; margin: 0px auto;">
</div>

<script type="text/javascript">

	var width = 1000;
	var height = 800;
	var fill = d3.scale.category20c();
    var words = ["<?php echo join("\", \"", $worddata); ?>"]; //convert php array to jscript array
    var sizes = ["<?php echo join("\", \"", $sizedata); ?>"]; //convert php array to jscript array

    d3.layout.cloud().size([width, height])
        .words(d3.zip(words, sizes).map(function(d) {
        return {text: d[0], size: d[1] * 30};
    }))
        .rotate(function() { return ~~(Math.random() * 5) * 30 - 60; })
        .fontSize(function(d) { return d.size; })
        .on("end", draw)
        .start();

    function draw(words) {
        d3.select("#cloud").append("svg")
            .attr("width", width)
            .attr("height", height)
            .append("g")
            .attr("transform", "translate(500,200)")
            .selectAll("text")
            .data(words)
            .enter().append("text")
            .style("font-size", function(d) { return d.size + "px"; })
			.attr("fill", function(d, i) { return fill(i); })
            .attr("text-anchor", "middle")
            .attr("transform", function(d) {
                return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
            })
            .text(function(d) { return d.text; });
    }
		
</script>

</body>
</html>

