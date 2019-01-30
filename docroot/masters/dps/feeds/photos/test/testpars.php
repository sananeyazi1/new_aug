<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php

function parse() { 

    $data = file_get_contents("http://www.augusta.com/mrss/slideshows/feed"); 
     
    $data = simplexml_load_string($data); 
     
    $entries = array(); 
     
    foreach($data->entry as $entry) 
    {     
     
        $entries[] = array 
        ( 
            'title' => (string)$entry->title, 
			'media' => (string)$entry->media,
			 
        ); 
    } 
     

         
};  
?>
</head>

<body>


<?php 
foreach(parse() as $post) 
    {  
?> 
    <h2><?php echo($post['title']); ?></h2> 
    <div><?php echo($post['description']); ?></div> 
<?php 
    } 
?>
</body>
</html>
