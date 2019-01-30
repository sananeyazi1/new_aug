<html>

	<head>
	<title> Press Start and Truck Times</title>
	
	<meta http-equiv="refresh" content="60" >
<style>

td {font-size: 5em; color: #fff;font-family:arial, serif;padding-left:20px;padding-right:20px;background: #000;border 2px solid #666;vertical-align:top;border:1px solid #333;}
table {width: 95%; max-width: 95%; }
tr {border-bottom: 2px solid #f08517; }
#time {font-size: 6.5em; color:#ccc; text-align:center;background-color:#000;font-family:arial, serif;}
#border {border-top: 20px solid #f08517;}
p {display:none;}

.odd {background: #fff;}
</style>

	</head>
	<body style="background-color: #333;">



<?PHP
echo '<div id="time">'; 
echo date('g:i a'); 
echo '</div>'; 

echo '<div id="border">'; 
echo '</div>'; 
$file_handle = fopen("formdata.txt", "rb");

while (!feof($file_handle) ) {

$line_of_text = fgets($file_handle);
$parts = explode('=', $line_of_text);

print $parts[0] . $parts[1]. "</p>";

}

fclose($file_handle);
echo '<div id="border">'; 
echo '</div>'; 
?>



</body>
	</html>






