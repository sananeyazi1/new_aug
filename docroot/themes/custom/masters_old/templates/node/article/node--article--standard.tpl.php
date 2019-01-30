<?php
$formatted_date = timeago_format_date($node->changed, $date = NULL);

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
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix "<?php print $attributes; ?>>

  <div class="well ">
    <?php print render($title_prefix); ?>
    <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
    <?php print render($title_suffix); ?>
    <?php print render($formatted_date); ?>


    <?php if (isset($image)) print l($image, $node_url, array('html' => TRUE,)) ?>
    <?php if (!empty($content['field_article_subheadline'])): ?>
      <?php print render($content['field_article_subheadline']); ?>
    <?php endif; ?>
    <?php print render($content['field_article_body']); ?>


  </div>
</div>
