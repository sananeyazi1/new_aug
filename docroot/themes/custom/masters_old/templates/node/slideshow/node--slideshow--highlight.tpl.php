<?php
 /* This is the missing highlights template for slideshows */
 /* Lead photo is required for this content type, so no fallback to photos[] */
 
 $link = url('node/' . $node->nid);

if ($node->field_slideshow_leadphoto){
  $lead_uri = $node->field_slideshow_leadphoto[LANGUAGE_NONE][0]['uri'];
  $image = theme('image_style', array('path' => $lead_uri, 'style_name' => "col-md-6__460x260", 'attributes' => array('class' => 'img-responsive')));
}

 $teaserclass='box-teaser';?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes;?> clearfix highlight <?php print $teaserclass?>"<?php print $attributes; ?>>

  <?php if($node->field_slideshow_leadphoto) print l($image, $link,array('html' => TRUE, ))?>
  <div class="well">

  <?php print render($title_prefix); ?>
  <?php if (!$page): ?>
    <h2<?php print $title_attributes; ?>><?php print l($title, $link) ?></h2>
  <?php endif; ?>
  <?php print render($title_suffix); ?>
 
  </div>
</div>
