<?php
//$sections = field_get_items('node', $node, 'field_sections');
//if ($sections) {
//  $section = field_view_value('node', $node, 'field_sections', $sections[0]);
//}
//Formatting teaser image
if ($node->field_article_photos_lead) {
  $lead_uri = $node->field_article_photos_lead[LANGUAGE_NONE][0]['uri'];
  $image = theme('image_style', array(
    'path' => $lead_uri,
    'style_name' => "col-md-6__460x260",
    'attributes' => array('class' => 'img-responsive')
  ));
}
if (!$node->field_article_photos_lead && $node->field_article_photos){
  $lead_uri = $node->field_article_photos[LANGUAGE_NONE][0]['uri'];
  $image = theme('image_style', array(
    'path' => $lead_uri,
    'style_name' => "col-md-6__460x260",
    'attributes' => array('class' => 'img-responsive')
  ));
}
// Adding theme classes
(isset($image)) ? $teaserclass = 'box-teaser' : $teaserclass = 'box-teaser text-only';?>
<div id="node-<?php print $node->nid; ?>"
     class="<?php print $classes; ?> clearfix highlight <?php print $teaserclass ?> "<?php print $attributes; ?>>

  <?php if (isset($image)) print l($image, $node_url, array('html' => TRUE,)) ?>
  <div class="well">
<!--    <div class="box-section">-->
<!--            --><?php //if(isset($section)) print render($section); ?>
<!--    </div>-->
    <?php if (!$page): ?>
      <?php if (!empty($node->field_article_front_headline[LANGUAGE_NONE][0]['value'])): ?>
    <h2><?php print render($content['field_article_front_headline']);?></h2>
      <?php else: ?>
        <?php print render($title_prefix); ?>
        <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
        <?php print render($title_suffix); ?>
      <?php endif; ?>
      <hr class="hidden-xs">
    <?php endif; ?>
    <?php if (!isset($image)) {
      print render($content['field_article_body']);
    } ?>
  </div>

</div>
