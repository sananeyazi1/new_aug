<html>

	<head>
	<title> Notes</title>
	<meta http-equiv="refresh" content="5" >
<style>

td {font-size: 3.8em; color: #fff;font-family:arial, serif;padding-left:20px;padding-right:20px;background: #000;border 2px solid #666;vertical-align:top;border:1px solid #333;}

#time {font-size: 6em; color:#ccc; text-align:center;background-color:#000;font-family:arial, serif;}
#border {border-top: 20px solid #f08517;}
p {display:none;}

</style>

	</head>
	<body style="background-color: #333;">



<?PHP
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



