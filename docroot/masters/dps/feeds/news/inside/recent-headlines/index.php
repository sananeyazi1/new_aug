<?php
header('Cache-control: max-age=300');
$XMLFILE = "http://feeds.feedburner.com/Masters-Blog?format=xml";
$TEMPLATE = "http://www.augusta.com/masters/dps/feeds/news/inside/recent-headlines/index.html";
$MAXITEMS = "5";
include("rss2html.php");
?>
