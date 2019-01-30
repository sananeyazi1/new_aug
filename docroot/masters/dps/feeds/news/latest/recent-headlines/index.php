<?php
header('Cache-control: max-age=300');
$XMLFILE = "http://feeds.feedburner.com/masters/latest?format=xml";
$TEMPLATE = "http://admin.augusta.com/masters/dps/feeds/news/latest/recent-headlines/index.html";
$MAXITEMS = "5";
include("rss2html.php");
?>
