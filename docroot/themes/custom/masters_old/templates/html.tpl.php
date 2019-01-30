<?php
/**
 * @file
 * Default theme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or
 *   'rtl'.
 * - $rdf_namespaces: All the RDF namespace prefixes used in the HTML document.
 * - $grddl_profile: A GRDDL profile allowing agents to extract the RDF data.
 * - $head_title: A modified version of the page title, for use in the TITLE
 *   tag.
 * - $head_title_array: (array) An associative array containing the string parts
 *   that were used to generate the $head_title variable, already prepared to be
 *   output as TITLE tag. The key/value pairs may contain one or more of the
 *   following, depending on conditions:
 *   - title: The title of the current page, if any.
 *   - name: The name of the site.
 *   - slogan: The slogan of the site, if any, and if there is no title.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $page_top: Initial markup from any modules that have altered the
 *   page. This variable should always be output first, before all other dynamic
 *   content.
 * - $page: The rendered page content.
 * - $page_bottom: Final closing markup from any modules that have altered the
 *   page. This variable should always be output last, after all other dynamic
 *   content.
 * - $classes String of classes that can be used to style contextually through
 *   CSS.
 *
 * @see bootstrap_preprocess_html()
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 *
 * @ingroup themeable
 */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN"
  "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces;?>>
<head profile="<?php print $grddl_profile; ?>">
  <meta charset="utf-8">
  <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MC54JB2');</script>
<!-- End Google Tag Manager -->
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="apple-touch-icon" href="<?php print base_path() . path_to_theme() ?>/device-icons/apple-touch-icon.png" />
  <link rel="apple-touch-icon" sizes="57x57" href="<?php print base_path() . path_to_theme() ?>/device-icons/apple-touch-icon-57x57.png" />
  <link rel="apple-touch-icon" sizes="60x60" href="<?php print base_path() . path_to_theme() ?>/device-icons/apple-touch-icon-60x60.png" />
  <link rel="apple-touch-icon" sizes="72x72" href="<?php print base_path() . path_to_theme() ?>/device-icons/apple-touch-icon-72x72.png" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php print base_path() . path_to_theme() ?>/device-icons/apple-touch-icon-76x76.png" />
  <link rel="apple-touch-icon" sizes="114x114" href="<?php print base_path() . path_to_theme() ?>/device-icons/apple-touch-icon-114x114.png" />
  <link rel="apple-touch-icon" sizes="120x120" href="<?php print base_path() . path_to_theme() ?>/device-icons/apple-touch-icon-120x120.png" />
  <link rel="apple-touch-icon" sizes="144x144" href="<?php print base_path() . path_to_theme() ?>/device-icons/apple-touch-icon-144x144.png" />
  <link rel="apple-touch-icon" sizes="152x152" href="<?php print base_path() . path_to_theme() ?>/device-icons/apple-touch-icon-152x152.png" />
  <meta name="msapplication-square70x70logo" content="<?php print base_path() . path_to_theme() ?>/device-icons/smalltile.png" />
  <meta name="msapplication-square150x150logo" content="<?php print base_path() . path_to_theme() ?>/device-icons/mediumtile.png" />
  <meta name="msapplication-wide310x150logo" content="<?php print base_path() . path_to_theme() ?>/device-icons/widetile.png" />
  <meta name="msapplication-square310x310logo" content="<?php print base_path() . path_to_theme() ?>/device-icons/largetile.png" />
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <link href='http://fonts.googleapis.com/css?family=Montserrat|Open+Sans:400,600' rel='stylesheet' type='text/css'>
  <?php print $styles; ?>
   <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!--[if IE 9]>
  <script src="<?php print base_path() . path_to_theme() ?>/scripts/matchMedia.js"></script>
  <![endif]-->
  <?php print $scripts; ?>

</head>
<body class="<?php print $classes; ?> pmenu-push-toright" <?php print $attributes;?> data-spy="scroll" data-target=".navbar" data-offset="160">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MC54JB2"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->  
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
 
 <script type="text/javascript" src="http://augusta.com/masters/includes/mtl/player.namer.js"></script> <!--player.name-->
  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-58a229a0a9df4450"></script><!--add.this-->
</body>
</html>
