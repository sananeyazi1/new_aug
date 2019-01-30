<?php
header("Cache-Control: max-age=1");
$XMLFILE = "http://feeds.feedburner.com/augusta/preps?format=xml";
$TEMPLATE = "http://www.augusta.com/masters/dps/feeds/acprepphotos/index.html";
$MAXITEMS = "30";
include("rss2html.php");
?>
