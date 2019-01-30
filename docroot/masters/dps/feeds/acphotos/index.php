<?php
header("Cache-Control: max-age=1");
$XMLFILE = "http://feeds.feedburner.com/chronicle/slideshows?format=xml";
$TEMPLATE = "http://www.augusta.com/masters/dps/feeds/acphotos/index.html";
$MAXITEMS = "30";
include("rss2html.php");
?>
