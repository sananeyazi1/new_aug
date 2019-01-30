<?php
$sections = field_get_items('node', $node, 'field_sections');
if ($sections) {
  $section = field_view_value('node', $node, 'field_sections', $sections[0]);
}
$formatted_date = timeago_format_date($node->changed, $date = NULL);
//Formatting teaser image

if ($node->field_article_photos_lead) {
  $lead_uri = $node->field_article_photos_lead[LANGUAGE_NONE][0]['uri'];
}else if (!$node->field_article_photos_lead && $node->field_article_photos){
  $lead_uri = $node->field_article_photos[LANGUAGE_NONE][0]['uri'];
}
  $image = theme('image_style', array(
    'path' => $lead_uri,
    'style_name' => "list__200x115",
    'attributes' => array('class' => 'img-responsive')
  ));

// Adding theme classes
($node->field_article_photos_lead) ? $teaserclass = 'list-teaser' : $teaserclass = 'list-teaser text-only';?>
<div id="node-<?php print $node->nid; ?>"
     class="<?php print $classes; ?> clearfix title-only <?php print $teaserclass ?> "<?php print $attributes; ?>>
    <div class="box-section">
      <?php if(isset($section)) print render($section); ?>
      <?php print render($formatted_date); ?>
    </div>
    <div class="gutterless row">
      <div class="col-xs-4">
        <?php print l($image, $node_url, array('html' => TRUE,)); ?>
      </div>
      <div class="col-xs-8"> <div>
          <?php print render($title_prefix); ?>
            <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
          <?php print render($title_suffix); ?>
        </div></div>
    </div>
</div>