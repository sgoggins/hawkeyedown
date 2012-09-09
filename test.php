<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<?php

$url = "gaymarriage.xml";
$xml = simplexml_load_file($url);
$alltweets = "\"";
foreach($xml->ROW as $row) {
    //echo $row->text . "<br />";
    $alltweets = $alltweets . " " . $row->text;
}

$allwords = array();
$allwords = explode(" ", $alltweets);
$allwords = implode("\",\"", $allwords);
print_r($allwords);

?>
</body>
</html>

