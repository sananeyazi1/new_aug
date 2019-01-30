<?php

$style_name = 'slideshow_h_360';

if ($node->field_slideshow_leadphoto){
  $lead_uri = $node->field_slideshow_leadphoto[LANGUAGE_NONE][0]['uri'];
  $image = theme('image_style', array('path' => $lead_uri, 'style_name' => $style_name , 'attributes' => array('class' => 'img-responsive')));
}
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes;?> clearfix "<?php print $attributes; ?>>
  <div class="slide-image">
    <?php if($node->field_slideshow_leadphoto) print l($image, $node_url,array('html' => TRUE, )) ?>
    <div class="box-section">
      <a href="<?php print $node_url; ?>"><?php print $title; ?></a>
    </div>
  </div>
</div>
