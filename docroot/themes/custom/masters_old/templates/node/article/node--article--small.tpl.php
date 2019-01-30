<?php
  $style_name = 'menu_205x115';
if ($node->field_article_photos_lead){
  $lead_uri = $node->field_article_photos_lead[LANGUAGE_NONE][0]['uri'];
  $image = theme('image_style', array('path' => $lead_uri, 'style_name' => $style_name , 'attributes' => array('class' => 'img-responsive')));
}
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes;?> clearfix"<?php print $attributes; ?>>

  <?php if($node->field_article_photos_lead) print l($image, $node_url,array('html' => TRUE, )) ?>

      <?php print $title_attributes; ?><a href="<?php print $node_url; ?>"><?php print $title; ?></a>

</div>
