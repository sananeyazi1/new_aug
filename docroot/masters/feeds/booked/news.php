<?php
header('Cache-control: max-age=300');
$XMLFILE = "http://booked.augusta.com/bookings/feed/apps";
$TEMPLATE = "http://www.augusta.com/masters/feeds/booked/index.html";
$MAXITEMS = "50";
include("rss2html.php");
?>
