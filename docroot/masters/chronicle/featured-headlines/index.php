<?php
//header("Cache-Control: max-age=300");
$XMLFILE = "http://www.augusta.com/mrss/featured/feed";
$TEMPLATE = "http://www.augusta.com/masters/chronicle/featured-headlines/index.html";
$MAXITEMS = "16";
include("rss2html.php");
?>
