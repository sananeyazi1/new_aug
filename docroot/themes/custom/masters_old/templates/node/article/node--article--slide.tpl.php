<?php
//$sections = field_get_items('node', $node, 'field_sections');
//if ($sections) {
//  $section = field_view_value('node', $node, 'field_sections', $sections[0]);
//}
//Formatting slider image
$style_name = 'top_slider__620x350';
$formatted_date = timeago_format_date($node->changed,$date = NULL);
if ($node->field_article_photos_lead) {
  $lead_uri = $node->field_article_photos_lead[LANGUAGE_NONE][0]['uri'];
  $image = theme('image_style', array(
    'path' => $lead_uri,
    'style_name' => $style_name,
    'attributes' => array('class' => 'img-responsive')
  ));
}
if (!$node->field_article_photos_lead && $node->field_article_photos){
  $lead_uri = $node->field_article_photos[LANGUAGE_NONE][0]['uri'];
  $image = theme('image_style', array(
    'path' => $lead_uri,
    'style_name' => $style_name,
    'attributes' => array('class' => 'img-responsive')
  ));
}

// Adding theme classes
if (isset($image)) $teaserclass='';
else $teaserclass='text-only';
//Formatting updated time and byline
if ($node->changed <= strtotime('-24 hours') &&  (isset($content['field_article_byline']) || isset($content['field_authors']))) {
  $timeorby = (isset($content['field_authors'])) ? $content['field_authors'] : $content['field_article_byline'];
}
else {
  $timeorby = $formatted_date;
}
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes;?> clearfix <?php print $teaserclass?> "<?php print $attributes; ?>>

  <div class="slide-image">
    <?php if($image) print l($image, $node_url,array('html' => TRUE, )) ?>
    <!--  <div class="box-section">-->
    <!--    --><?php //if(isset($section)) print render($section); ?>
    <!--  </div>-->
    <button type="button" class="slick-prev slick-arrow glyph glyph-btn glyph-arrow-right"></button>
    <button type="button" class="slick-next slick-arrow glyph glyph-btn glyph-arrow-right"></button>
  </div>
  <div class="slide-content">
    <div class="well">

      <?php print render($timeorby); ?>
      <hr>
      <?php if (!empty($content['field_article_front_headline'])): ?>
        <h2><?php print render($content['field_article_front_headline']);?></h2>
      <?php else: ?>
        <?php print render($title_prefix); ?>
        <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
        <?php print render($title_suffix); ?>
      <?php endif; ?>
      <?php print render($content['field_article_body']); ?>
    </div>
  </div>
</div>
