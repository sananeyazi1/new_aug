<?php
//$sections = field_get_items('node', $node, 'field_sections');
//if ($sections) {
//  $section = field_view_value('node', $node, 'field_sections', $sections[0]);
//}
//Adding classes if teaser is rendered by the view

/*
if (!empty($node->view)){
if ($node->view->row_index == 0 || $node->view->row_index == 1){
  $style_name = 'col-md-6__460x260';
}else {
  $style_name = 'col-md-4__300x170';
};
} else{
  $style_name = 'col-md-4__300x170';
}
*/
 
$style_name = 'teaser__620x350'; // new custom style for tax term pages
 
//Formatting timeago date
$formatted_date = timeago_format_date($node->changed,$date = NULL);
//Formatting teaser image
if ($node->field_slideshow_leadphoto){
  $lead_uri = $node->field_slideshow_leadphoto[LANGUAGE_NONE][0]['uri'];
  $image = theme('image_style', array('path' => $lead_uri, 'style_name' => $style_name , 'attributes' => array('class' => 'img-responsive')));
}
//if ($node->changed <= strtotime('-24 hours') &&  isset($content['field_article_byline'])) {
//  $timeorby =  $content['field_article_byline'];
//}
//else {
//  $timeorby = $formatted_date;
//}

($node->field_slideshow_leadphoto) ? $teaserclass='' : $teaserclass='text-only';?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes;?> clearfix <?php print $teaserclass?> box-teaser"<?php print $attributes; ?>>

  <?php if($node->field_slideshow_leadphoto) print l($image, $node_url,array('html' => TRUE, )) ?>

  <div class="well">
    <div class="box-section">
<!--      --><?php //if(isset($section)) print render($section); ?>
      <?php if(!$node->field_slideshow_leadphoto) print render($timeorby); ?>
    </div>
    <?php if($node->field_slideshow_leadphoto) print render($timeorby); ?>
    <hr class="hidden-xs">
    <?php print render($title_prefix); ?>
      <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
    <?php print render($title_suffix); ?>
<!--    Print body if image is not set-->
    <?php if(!$node->field_slideshow_leadphoto) print render($content['field_slideshow_body']);?>
  </div>
</div>
