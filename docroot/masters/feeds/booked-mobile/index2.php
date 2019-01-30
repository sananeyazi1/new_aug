<?php
header('Cache-control: max-age=10');
$XMLFILE = "http://booked.augusta.com/bookings/feed/apps";
$TEMPLATE = "http://www.augusta.com/masters/feeds/booked-mobile/index.html";
$MAXITEMS = "2";
include("rss2html.php");
?>
