<html>
<head>
<title>Truck Times</title>
</head>
<body style="background:#ccc;font-family: arial,serif;max-width: 420px;">
<span style="color: #c53513;"><B>NOTE:</B> Every field MUST contain a value before saving.  Do not leave any fields blank. To reset the form or individual form fields,  it is recommended you use dashes (-) or zeros (0:00) to populate the field(s) before saving.</span><BR><BR>

<form name="myform" action="scoreboard.php" method="post">
<B>Press Start</B><br/>
Goal: <textarea rows="1" cols="20" name="press" maxlength="8" required style="max-height: 25px;white-space: nowrap;"><?php
$myFile = "formdata2.txt";
$lines = file($myFile);//file in to an array
echo $lines[1]; //line 2
?></textarea><br>
Actual: <textarea rows="1" cols="20" name="pressb" maxlength="8" required style="max-height: 25px;white-space: nowrap;"><?php
$myFile = "formdata2.txt";
$lines = file($myFile);//file in to an array
$lines = file($myFile);//file in to an array
echo $lines[3]; //line 4
?></textarea><br><br>


<B>TRUCKING REPORT</B><br/>
<B>37</B><br/>
Expected Arrival: <textarea rows="1" cols="20" name="thirtyseven" maxlength="8" required style="max-height: 25px;white-space: nowrap;"><?php
$myFile = "formdata2.txt";
$lines = file($myFile);//file in to an array
echo $lines[5]; //line 6
?></textarea><br><br>


<B>35, 47, 57R, 59R, 69, 71</B><br/>
Expected Arrival:  <textarea rows="1" cols="20" name="fortyseven" maxlength="8" required style="max-height: 25px;white-space: nowrap;"><?php
$myFile = "formdata2.txt";
$lines = file($myFile);//file in to an array
echo $lines[7]; //line 8
?></textarea><br><br>


<B>57, 57A, 59A</B><br/>
Expected Arrival:  <textarea rows="1" cols="20" name="fiftyseven" maxlength="8" required style="max-height: 25px;white-space: nowrap;"><?php
$myFile = "formdata2.txt";
$lines = file($myFile);//file in to an array
echo $lines[9]; //line 10
?></textarea><br><br>


<B>55, 56, 61</B><br/>
Expected Arrival:  <textarea rows="1" cols="20" name="fiftysix" maxlength="8" required style="max-height: 25px;white-space: nowrap;"><?php
$myFile = "formdata2.txt";
$lines = file($myFile);//file in to an array
echo $lines[11]; //line 12
?></textarea><br><br>



<B>Comments/Delays/Alerts</B><br> <textarea rows="4" cols="50" maxlength="200" name="comments" required style="white-space: nowrap;"><?php
$myFile = "formdata2.txt";
$lines = file($myFile);//file in to an array
echo $lines[13]; //line 14?></textarea>
<br><br>


<input type="submit" value=" Save "><br>
</form>
</body>
</html>