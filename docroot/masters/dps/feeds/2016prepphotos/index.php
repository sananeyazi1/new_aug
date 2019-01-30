<?php
header("Cache-Control: max-age=1");
$XMLFILE = "http://feeds.feedburner.com/augusta/preps?format=xml";
$TEMPLATE = "http://www.augusta.com/masters/dps/feeds/2016prepphotos/index.html";
$MAXITEMS = "10";
include("rss2html.php");
?>
