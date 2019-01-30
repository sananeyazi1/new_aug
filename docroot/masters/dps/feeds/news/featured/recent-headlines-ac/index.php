<?php
header('Cache-control: max-age=300');
$XMLFILE = "http://admin.augusta.com/mrss/feed/queue21";
$TEMPLATE = "http://www.augusta.com/masters/dps/feeds/news/featured/recent-headlines-ac/index.html";
$MAXITEMS = "8";
include("rss2html.php");
?>
