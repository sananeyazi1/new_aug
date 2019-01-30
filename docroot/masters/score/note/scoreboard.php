<?php
// Receive form Post data and Saving it in variables


$comment = @$_POST['comment'];



// Write the name of text file where data will be stored
$filename = "http://origin.augusta.com/masters/score/note/formdata.txt";

// Merge all the variables with text in a single variable. 
$f_data= '
<center><table>
<tr>
<td>
'.$comment.'
</td>
</tr>
</table>
</center>

';

echo 'The information has been saved.';
echo "<br /><a href=http://origin.augusta.com/masters/score/note/output.php>click here to view results</a>";
$file = fopen($filename, "w");
fwrite($file,$f_data);
fclose($file);
?>