<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see bootstrap_preprocess_page()
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see bootstrap_process_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */

if (theme_get_setting('weather_link')) {
  $weather_url = theme_get_setting('weather_link');
};
if (theme_get_setting('subscribe_link')) {
  $subscribe_url = theme_get_setting('subscribe_link');
};
?>




  <?php if (user_is_logged_in() && theme_get_setting('dev_tools')) : ?>
    <div class="dev-tools visible-lg">
      <a class="btn btn-default btn-xs to-styleguide" href="<?php print base_path() . path_to_theme() ?>/styleguide/">Styleguide</a>
      <a class="btn btn-default btn-xs to-styleguide" href="admin/appearance/settings/published#color_scheme_form">Colors</a>
      <a class="btn btn-default btn-xs to-styleguide" href="admin/appearance/settings/published#edit-msms">MSMS
        Settings</a>
    </div>
  <?php endif; ?>

<header id="navbar" role="banner" class="<?php print $navbar_classes; ?>" data-spy="affix" data-offset-top="110">
  <!-- <div class="container"> -->
  <nav role="navigation" class="hidden-sm hidden-xs clearfix">
    <?php if (theme_get_setting('subscribe_link')) : ?>
      <a target="_blank" href="<?php print $subscribe_url ?>" class="subscribe-btn pull-left"><i class="glyph glyph-newspaper"></i>Subscribe</a>
    <?php endif; ?>
    <div class="top-links">
      <?php $tree = menu_tree_all_data('menu-top-links', NULL, 1);
      $output = menu_tree_output($tree);
      print render($output); ?>
    </div>
  </nav>
  <!-- </div> -->
  <div class="navbar-region clearfix">

    <button id="showLeftPush" class="navbar-toggle" href="#"><i class="glyph glyph-hotdog"></i>MENU</button>
    <?php if (!empty($page['search'])): ?>
      <?php print render($page['search']); ?>
    <?php endif; ?>
    <div class="user-info">

      <?php
      $block_gigya_login_Object = block_load('gigya','gigya');
      $block_gigya_login = _block_get_renderable_array(_block_render_blocks(array($block_gigya_login_Object)));
      $gigya_login = drupal_render($block_gigya_login);
      print $gigya_login;?>

      <?php if (module_exists('simple_weather_nws')): ?>
        <div id="weather">

          <?php if (theme_get_setting('weather_link')) : ?>
            <a class="weather-link" target="_blank" href="<?php print $weather_url ?>"></a>
          <?php endif; ?>

          <?php
          $block_nws_load = block_load('simple_weather_nws','simple_weather_nws_display_block');
          $block_nws = _block_get_renderable_array(_block_render_blocks(array($block_nws_load)));
          $nws_output = drupal_render($block_nws);
          print $nws_output;?>
        </div>
      <?php endif; /* simple_weather_nws */ ?>
    </div>
  </div>

</header>

<div id="content-wrapper">

  <?php print render($page['header']); ?>
  <!-- Push mobile menu -->
  <?php if (!empty($primary_nav)): ?>
    <nav class="pmenu pmenu-left" id="pmenu">
      <ul class="menu nav navbar-nav">
        <?php     $treesidebar = menu_tree_all_data('main-menu', NULL, 2);
        $outputsidebar = menu_tree_output($treesidebar);
        print render($outputsidebar); ?>
        <div class="pmenu-bottom">
          <?php
          $newsleterobj = block_load('whatcounts','whatcounts');
          $newsletterblock = _block_get_renderable_array(_block_render_blocks(array($newsleterobj)));
          $newsletter = drupal_render($newsletterblock);
          print $newsletter;
          ?>
		 
          <?php
          $block_gigya_follow1_Object = block_load('gigya', 'gigya_follow_menu');
          $block_gigya_follow1 = _block_get_renderable_array(_block_render_blocks(array($block_gigya_follow1_Object)));
          $gigya_follow1 = drupal_render($block_gigya_follow1);

          print $gigya_follow1;
          ?>
        </div>
      </ul>
    </nav>
  <?php endif; ?>

  <header role="banner" id="page-header" class="container">
        <!-- <?php /*
      $blockslidingObject = block_load('dfp_blocks','dfp_blocks_sliding');
      $blocksliding = _block_get_renderable_array(_block_render_blocks(array($blockslidingObject)));
      $outputblocksliding = drupal_render($blocksliding);
      print $outputblocksliding;
      */ ?>-->
    <div class="navbar-brand clearfix">
	<div class="logo-top">
      <?php if ($logo): ?>
        <a class="logo navbar-btn" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
          <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>"/>
        </a>
	</div>
      <?php endif; ?>
      <?php if (!empty($site_slogan)): ?>
        <p class="lead"><?php print $site_slogan; ?></p>
      <?php endif; ?>
      <div class="follow-bar hidden-xs pull-right">
<div class="addthis_inline_follow_toolbox">
        <?php
        $block_gigya_follow_Object = block_load('gigya','gigya_follow');
        $block_gigya_follow = _block_get_renderable_array(_block_render_blocks(array($block_gigya_follow_Object)));
        $gigya_follow = drupal_render($block_gigya_follow);
        print $gigya_follow;
        ?>
      </div>
      <div class="ad-sponsored pull-right">
	        <?php if (!empty($page['sponsorship'])): ?>
	          <?php print render($page['sponsorship']); ?>
	        <?php endif; ?>
	  </div>
    </div>

  </header>
  <!-- /#page-header -->
	<?php print render($page['top_ad']); ?>
  <div class="main-container container">

    <?php if (!empty($node->field_display) && ($node->type == 'article' || $node->type == 'sponsored')): ?>
      <div class="lead-image">
        <?php
        $style_name = "lead_940x400";
        $authors = field_view_field('node', $node, 'field_authors', array('label' => 'hidden'));
        if ($node->type == 'article') {
          if ($node->field_article_photos_lead) {
            $lead_uri = $node->field_article_photos_lead[LANGUAGE_NONE][0]['uri'];
            $image = theme('image_style', array(
              'path' => $lead_uri,
              'style_name' => $style_name,
              'attributes' => array('class' => 'img-responsive')
            ));
          }
        }
        elseif (($node->type == 'sponsored')) {?>
        <div class="sponsored-label">Sponsored</div>
        <?php
          if ($node->field_sponsored_photos_lead) {
            $lead_uri = $node->field_sponsored_photos_lead[LANGUAGE_NONE][0]['uri'];
            $image = theme('image_style', array(
              'path' => $lead_uri,
              'style_name' => $style_name,
              'attributes' => array('class' => 'img-responsive')
            ));
          }
        }

      ?>

        <?php
        if ($node->type == 'article') {
        if ($node->field_article_photos_lead) {
            print $image;
            }
        } ?>

        <?php
        if ($node->type == 'sponsored') {
        if ($node->field_sponsored_photos_lead) {
          print $image;
          }} ?>
		 
		  <?php
        if ($node->type == 'video') {
        if ($node->field_article_photos_lead) {
          print $image;
          }} ?>

        <div class="well">
          <div class="story-date">
            <?php
            $formatted_date = format_date($node->published_at, 'custom', 'F j, Y h:i a');
            $formated_updated_date = format_date($node->changed, 'custom', 'F j, Y h:i a');
            $authors = field_view_field('node', $node, 'field_authors', array('label' => 'hidden'));

            $authored = false;

            if ($node->field_authors){
              $authored = true;
            }

            if ($node->type == 'article') {
              if ($node->field_article_byline){
                $authored = true;
              }
            }
            if ($node->type == 'sponsored') {
              if ($node->field_sponsored_byline){
                $authored = true;
              }
            }

            ?>
            <div class="story-date">
              <?php ($authored) ? print 'by ' : '' ?>
                <?php if ($node->field_authors) {
                print render($authors);
              } ?>
              <?php
      if ($node->type == 'article') {
        $article_byline_field = field_get_items('node', $node, 'field_article_byline');
        if ($article_byline_field) {
          print $node->field_article_byline[LANGUAGE_NONE][0]['value'];
        }
      }
              if ($node->type == 'sponsored') {
                $article_byline_field = field_get_items('node', $node, 'field_sponsored_byline');
                if ($article_byline_field) {
                  print $node->field_sponsored_byline[LANGUAGE_NONE][0]['value'];
                }
              }
              ?>
              <br>
              <?php if ($node->status):?>
                Posted <?php print render($formatted_date); ?>
                <?php if ($node->published_at != $node->changed): ?>
                  -  Updated <?php print render($formated_updated_date); ?>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          </div>

          <hr>
          <?php print render($title_prefix); ?>
          <h1 class="h2" data-id='node-<?php print $node->nid;?>' <?php print $title_attributes; ?>><?php print $title; ?></h1>
          <?php print render($title_suffix); ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="row">
      <section<?php print $content_column_class; ?>>
        <?php if (!empty($page['highlighted'])): ?>
          <div class="highlighted jumbotron"><?php print render($page['highlighted']); ?></div>
        <?php endif; ?>

        <a id="main-content"></a>
        <?php print render($title_prefix); ?>
        <?php if (!empty($title) && (empty($node))): ?>
          <h1 class="page-header"><?php print $title; ?></h1>
        <?php endif; ?>
        <?php print render($title_suffix); ?>
        <?php print $messages; ?>
        <?php if (!empty($tabs)): ?>
          <?php print render($tabs); ?>
        <?php endif; ?>
        <?php if (!empty($page['help'])): ?>
          <?php print render($page['help']); ?>
        <?php endif; ?>
        <?php if (!empty($action_links)): ?>
          <ul class="action-links"><?php print render($action_links); ?></ul>
        <?php endif; ?>

<div class="center-content-bg">
        <?php print render($page['content']); ?>
</div>
      </section>

      <?php if (!empty($page['sidebar'])): ?>
        <aside class="col-md-4 clearfix" role="complementary">
          <?php print render($page['sidebar']); ?>
        </aside>  <!-- /#sidebar-first -->
      <?php endif; ?>

      <?php if (!empty($page['content_below'])): ?>
        <section class="col-md-12">
          <?php print render($page['content_below']); ?>
        </section>
      <?php endif; ?>

    </div>
  </div>
  


  <footer id="footer" class="footer">
    <div class="container">
     <!-- <?php if ($logo): ?>
        <a class="logo navbar-btn" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
          <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>"/>
        </a>
      <?php endif; ?>-->
	    <p class="footer-message">
		This site and all its content are representative of The Augusta Chronicle's Masters&reg; Tournament coverage and information. The Augusta Chronicle and Augusta.com are our trademarks. Augusta.com is an online publication of The Augusta Chronicle and is neither affiliated with nor endorsed by the Masters or the Augusta National Golf Club.
		<br><br><!--<?php print $site_name; ?>-->The Augusta Chronicle &copy; <?php echo date("Y") ?>. All Rights Reserved.</p>
      <?php if (!empty($secondary_nav)): ?>
        <?php print render($secondary_nav); ?>
      <?php endif; ?>
      <?php if (!empty($site_name)): ?>
      
      <?php endif; ?>
    </div>
    <div class="ad-bottom">
      <?php drupal_add_library('system', 'jquery.cookie');?>
        <div class="adhesion-unit fade-on-bottom  <?php (!theme_get_setting('progress_bar')) ? print "" : print "hard-static" ?>">
    	<?php if (!empty($page['footer'])): ?>
    	  <?php print render($page['footer']); ?>
    	<?php endif; ?>
          <a id="btnadclose" class="visible-lg visible-md ad-close" href="javascript:void(0)">X</a>
        </div>
    </div>
  </footer>

  <div id="pmenuOverlay" class="pmenu-overlay"></div>
</div>