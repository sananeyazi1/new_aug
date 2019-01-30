<?php
header('Cache-control: max-age=300');
$XMLFILE = "http://feeds.feedburner.com/masters/latest?format=xml";
$TEMPLATE = "http://augusta.com/masters/dps/feeds/news/test/index.html";
$MAXITEMS = "5";
include("rss2html.php");
?>
