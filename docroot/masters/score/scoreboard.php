<?php
// Receive form Post data and Saving it in variables

$press = @$_POST['press'] ;
$pressb = @$_POST['pressb'] ;
$comments = @$_POST['comments'];
$thirtyseven = @ $_POST['thirtyseven'];
$thirtysevenb = @ $_POST['thirtysevenb'];
$fortyseven = @ $_POST['fortyseven'];
$fortysevenb = @ $_POST['fortysevenb'];
$fiftyseven = @ $_POST['fiftyseven'];
$fiftysevenb = @ $_POST['fiftysevenb'];
$fiftysix = @ $_POST['fiftysix'];
$fiftysixb = @ $_POST['fiftysixb'];



// Write the name of text file where data will be stored
$filename = "formdata.txt";

// Merge all the variables with text in a single variable. 
$f_data= '

<center><table>
<tr>
<td>
Notes: '.$comments.'
</td>
</tr>
</table>
</center>
<br />
<center>
<table>
<tr>
<td>Press Start:  Goal</td>
<td>Actual</td>

</tr>
<tr>

<td>
'.$press.'  
</td>
<td>
 '.$pressb.'  
</td>

</tr>





</table>
</center>
<br />

<center>


<table>
<tr>
<td>Truck #</td>
<td>
Expected Arrival
</td>
</tr>

<tr>
<td>
37
</td>
<td>
'.$thirtyseven.'  
</td>

</tr>

<tr>
<td>
35, 47, 57R, 59R, 69,71
</td>
<td>
'.$fortyseven.'  
</td>

</tr>


<tr>
<td>
57, 57A, 59A
</td>
<td>
'.$fiftyseven.'  
</td>

</tr>


<tr>
<td>
55, 56, 61
</td>
<td>
'.$fiftysix.'  
</td>

</tr>
</table></center>';

echo 'The information has been saved.';
echo "<br /><a href=http://origin.augusta.com/masters/score/output.php>click here to view results</a>";
$file = fopen($filename, "w");
fwrite($file,$f_data);
fclose($file);


$filename2 = "formdata2.txt";
// Merge all the variables with text in a single variable. 
$f_data= '
'.$press.'  
'.$pressb.'  
'.$thirtyseven.'  
'.$fortyseven.'  
'.$fiftyseven.'  
'.$fiftysix.'  
'.$comments.'
';




$file = fopen($filename2, "w");
fwrite($file,$f_data);
fclose($file);


?>