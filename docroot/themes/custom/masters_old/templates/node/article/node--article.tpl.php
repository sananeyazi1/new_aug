<?php
/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 *
 * @ingroup themeable
 */
// We hide the comments and links now so that we can render them later.
hide($content['comments']);
hide($content['links']);
$authors = field_view_field('node', $node, 'field_authors', array('label' => 'hidden'));
?>

<div id="node-<?php print $node->nid; ?>"
     class="<?php print $classes; ?> box article-story clearfix"<?php print $attributes; ?>>
<!--    Regular layout display-->
<?php if (empty($node->field_display)): ?>
  <!--    Formatting published and created dates and authors-->
  <?php
  $formatted_date = format_date($node->published_at, 'custom', 'F j, Y h:i a');
  $formated_updated_date = format_date($node->changed, 'custom', 'F j, Y h:i a');
  ?>
  <!--    Dates and Authors and Byline2-->
  <div class="story-date">
  <?php if ($node->status):?>
    Posted <?php print render($formatted_date); ?>
<?php if ($node->published_at != $node->changed): ?>
     <!--     - Updated <?php print render($formated_updated_date); ?>-->
    <?php endif; ?>
  <?php endif; ?>  
    <?php
    //if (!empty($content['field_article_byline']) || !empty($content['field_authors'])):
    if (!empty(render($authors))): ?>
      <br> BY<?php print render($authors);
	      endif; 
	      if (!empty($content['field_article_byline'])): ?>
     <!--<span class="text-primary">--> | <?php print render($content['field_article_byline']); ?><!--</span>-->
    <?php endif; ?>

  </div>
  <hr>
  <div class="addthis_inline_share_toolbox"></div>
  <!--    Title, subtitle and content fields-->
  <?php print render($title_prefix); ?>
  <h1 class="h2 story-title" data-id='node-<?php print $node->nid; ?>' <?php print $title_attributes; ?>><?php print $title; ?></h1>
  <?php print render($title_suffix); ?>
<?php endif; ?>
<div class="content"<?php print $content_attributes; ?>>
  <?php if (!empty($content['field_article_subheadline'])): ?>
    <?php print render($content['field_article_subheadline']); ?>
  <?php endif; ?>
  
  <?php
  $block_gigya_share_Object = block_load('gigya', 'gigya_share');
  $block_gigya_share = _block_get_renderable_array(_block_render_blocks(array($block_gigya_share_Object)));
  $gigya_share = drupal_render($block_gigya_share);

  print $gigya_share;
  ?>




  <!-- If not wide layout-->
  <?php if (empty($node->field_display)): ?>
    <!-- Media assets start-->
    <?php if (!empty($content['field_article_photos']) || !empty($content['field_article_videos'])):; ?>
      <?php $imgno = count(@$content['field_article_photos']['#items']) + count(@$content['field_article_videos']['#items'])?>
      <?php ($imgno > 1) ? $slider = TRUE : $slider = FALSE; ?>
      <?php if ($slider): ?>
        <!--        Slick slider-->
        <?php
        drupal_add_css('//cdn.jsdelivr.net/jquery.slick/1.5.8/slick.css', 'external');
        drupal_add_js('//cdn.jsdelivr.net/jquery.slick/1.5.8/slick.min.js', 'external');
        ?>
        <script type="text/javascript">
          jQuery(document).ready(function ($) {
            
	$('.story-slider').slick({
              lazyLoad: 'progressive',
              fade: true,
	      autoplay: false,
	      autoplaySpeed: 7000,
              cssEase: 'linear',
              "accessibility": false,
              adaptiveHeight: true,
              arrows: false
            });
	
	$('.slide-desc').removeClass('hidden');

            $('.slick-next').click(function (e) {
              $('.story-slider').slick('slickNext');
            });
            $('.slick-prev').click(function (e) {
              $('.story-slider').slick('slickPrev');
            });
          });
        </script>
        <div class="story-slider bottom-margin box-row">
          <?php foreach ($slideshow as $key => $value) {
            print $value;
          }?>
       </div>
      <?php else: ?>
        <!--        Single image-->
        <div class="box-row"><?php print render($content['field_article_photos']); ?>
          <div class="slide-desc">
            <?php if (!empty($content['field_article_photos']['#items'][0]['field_file_image_title_text'])): ?>
              <div class="field-file-image-title-text">
                <?php print $content['field_article_photos']['#items'][0]['field_file_image_title_text']['und'][0]['value']; ?>
              </div>
            <?php endif; ?>
            <?php if (!empty($content['field_article_photos']['#items'][0]['field_image_description'])): ?>
              <div class="field-image-description">
                <?php print $content['field_article_photos']['#items'][0]['field_image_description']['und'][0]['value']; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
     <?php print render($content['field_article_videos']); ?>

    <?php endif; ?>
    <?php endif; ?>
    <!-- Media assets End-->
  <?php endif; ?>
  <!-- End not wide layout-->
  <?php $content_array = explode("<p>", render($content['field_article_body'])); ?>
  <?php if (count($content_array) <=1){
    $content_array = explode('<p class="body_copy">', render($content['field_article_body']));
  }
  ?>
  <?php if (!empty($content['field_article_content_include'])): ?>
    <?php $added_string = render($content['field_article_content_include']); ?>
  <?php else: ?>
    <?php $added_string = views_embed_view('content_include_field', 'block'); ?>
  <?php endif; ?>
  <?php if (!empty($node->field_display)): ?>
    <?php
    $sliced = array_slice($content_array, 0, 4);
    $first_content = implode("<p>", $sliced);
    print $first_content;?>
    <!-- Media assets start-->
    <?php if (!empty($content['field_article_photos']) || !empty($content['field_article_videos'])):; ?>
      <?php $imgno = count(@$content['field_article_photos']['#items']) + count(@$content['field_article_videos']['#items'])?>
      <?php ($imgno > 1) ? $slider = TRUE : $slider = FALSE; ?>
      <?php if ($slider): ?>
        <!--        Slick slider-->
        <?php
        drupal_add_css('//cdn.jsdelivr.net/jquery.slick/1.5.8/slick.css', 'external');
        drupal_add_js('//cdn.jsdelivr.net/jquery.slick/1.5.8/slick.min.js', 'external');
        ?>
        <script type="text/javascript">
          jQuery(document).ready(function ($) {


            $('.story-slider').slick({
              
	      lazyLoad: 'ondemand',
	      autoplay: true,
	      autoplaySpeed: 7000,
              fade: true,
              cssEase: 'linear',
              "accessibility": false,
              adaptiveHeight: true,
              arrows: false
            });
            $('.slick-next').click(function (e) {
              $('.story-slider').slick('slickNext');
            });
            $('.slick-prev').click(function (e) {
              $('.story-slider').slick('slickPrev');
            });
          });
        </script>
        <div class="story-slider bottom-margin box-row">
          <?php foreach ($slideshow as $key => $value) {
            print $value;
          }?>
        </div>
      <?php else: ?>
        <!--        Single image-->
        <div class="box-row"><?php print render($content['field_article_photos']); ?>
          <div class="slide-desc">
            <?php if (!empty($content['field_article_photos']['#items'][0]['field_file_image_title_text'])): ?>
              <div class="field-file-image-title-text">
                <?php print $content['field_article_photos']['#items'][0]['field_file_image_title_text']['und'][0]['value']; ?>
              </div>
            <?php endif; ?>
            <?php if (!empty($content['field_article_photos']['#items'][0]['field_image_description'])): ?>
              <div class="field-image-description">
                <?php print $content['field_article_photos']['#items'][0]['field_image_description']['und'][0]['value']; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <?php print render($content['field_article_videos']); ?>

      <?php endif; ?>
    <?php endif; ?>
    <!-- Media assets End-->
  <?php endif; ?>
  
  <?php
   if (!empty($node->field_article_videos_embedded)) {
    $insert_video_embedd_after = 3;
    $video_code='<div class="box-row-video">'.render($content['field_article_videos_embedded']).'</div>';
    array_splice($content_array, $insert_video_embedd_after + 1, 0, $video_code);
  }
  if (!empty($node->field_ci_insert)) {
    $insert_after = $node->field_ci_insert[LANGUAGE_NONE][0]['value'];
    array_splice($content_array, $insert_after + 1, 0, $added_string);
  }
  else {
    $insert_after = 99;
    array_splice($content_array, $insert_after + 1, 0, $added_string);

  }
  $final_content = implode("<p>", $content_array);

  ?>
  <?php if (!empty($node->field_display)): ?>
    <?php
    $sliced_last = array_slice($content_array, 6);
    $final_content_wide = implode("<p>", $sliced_last);
    print $final_content_wide;?>

  <?php else: ?>
   <div id="mainStoryContent"> <!--player.name-->
    <?php print $final_content; ?>
 </div> <!--player.name-->
  <?php endif; ?>
  <div class="box-row"><?php print render($content['field_article_embedded']); ?></div>
  
  <?php print render($content['field_article_related_articles']); ?>
  <?php print render($content['field_article_breakout']); ?>
  <?php print render($content['field_article_links']); ?>
  <?php print render($content['field_article_files']); ?>

  <?php
  /* $block_yieldmo_Object = block_load('yieldmo', 'yieldmo_first');
  $block_yieldmo = _block_get_renderable_array(_block_render_blocks(array($block_yieldmo_Object)));
  $yieldmo = drupal_render($block_yieldmo);

  print $yieldmo; */
  ?>
  <?php if (!empty($content['field_topics'])): ?>
    <div class="story-topics">
      <?php print render($content['field_topics']); ?>
    </div>
  <?php endif; ?>
  <?php if (!empty($content['field_tags'])): ?>
    <div class="story-tags">
      <?php print render($content['field_tags']); ?>
    </div>
  <?php endif; ?>

  <!-- Facebook comments section -->
  <?php if (isset($content['facebook_comments'])): ?>
    <div class="clearfix facebook-comment-wrapper">
      <?php print render($content['facebook_comments']); ?>
    </div>
  <?php endif; ?>

  <?php
  $block_gigya_comments_Object = block_load('gigya', 'gigya_comments');
  $block_gigya_comments = _block_get_renderable_array(_block_render_blocks(array($block_gigya_comments_Object)));
  $gigya_comments = drupal_render($block_gigya_comments);

  print $gigya_comments;
  ?>
</div>
</div>
<!-- progress bar and flippy -->
<?php if (theme_get_setting('progress_bar')) : ?>
  <div class="story-bar fade-on-bottom">
    <progress id="progressbar" class="progress-bar" value="0" max="100"></progress>
    <div class="bar-content">
      <span><?php print $title; ?></span>
      <?php if (!empty($content['field_article_byline']) || !empty($content['field_authors'])): ?>
        <span>- By </span>
        <?php print render($authors); ?>
        <?php print render($content['field_article_byline']); ?>
      <?php endif; ?>
	  </div>
	 <div class="node-lister">
        <?php
        if (!empty($node->field_sections)){
        $next_node_nid_arr = taxonomy_select_nodes_from_nid($node->field_sections['und'][0]['tid'], $node->nid, 'next');
        if(sizeof($next_node_nid_arr)){
          $next_node=node_load($next_node_nid_arr[0]);
          print '<a class="next" href=/node/'. $next_node->nid.'><i class="glyph glyph-arrow-right"></i></a>';
        }
        $prev_node_nid_arr = taxonomy_select_nodes_from_nid($node->field_sections['und'][0]['tid'], $node->nid, 'prev');
        if(sizeof($prev_node_nid_arr)){
          $prev_node=node_load($prev_node_nid_arr[0]);
          print '<a class="prev"  href=/node/'. $prev_node->nid.'><i class="glyph glyph-arrow-right"></i></a>';
        }
        }
        ?>
      </div>
  </div>
<?php endif; ?>
