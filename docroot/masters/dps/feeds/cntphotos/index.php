<?php
header("Cache-Control: max-age=1");
$XMLFILE = "http://feeds.feedburner.com/augusta/cntslideshows?format=xml";
$TEMPLATE = "http://www.augusta.com/masters/dps/feeds/cntphotos/index.html";
$MAXITEMS = "30";
include("rss2html.php");
?>
