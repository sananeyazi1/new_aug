<HTML>
    <HEAD>
	  <TITLE>
            Masters 2013 Latest News
        </TITLE>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
    		<link href="http://www.augusta.com/masters/dps/feeds/news/news.css" rel="stylesheet" type="text/css" />
    
    <!-- Include js files -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

</script>

<style>
a:-webkit-any-link {
text-decoration: none !important;
color:#000;
}
h1 {font-weight: bold !important;}
</style>
    </HEAD>
    <BODY>

<?php
header('Cache-control: max-age=300');
$XMLFILE = "http://www.augusta.com/masters/feeds/dps-lede.xml";
$TEMPLATE = "http://augusta.com/masters/dps/feeds/news/index.html";
$MAXITEMS = "1";
include("rss2html.php");
?>

</body>
</html>
