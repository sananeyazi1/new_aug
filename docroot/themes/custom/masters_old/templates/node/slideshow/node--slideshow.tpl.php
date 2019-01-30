
<?php
/**
 * Created by PhpStorm.
 * User: bzivkov
 * Date: 9/15/15
 * Time: 5:19 PM
 */
?>


<div id="node-<?php print $node->nid; ?>"
     class="<?php print $classes; ?> box node-story clearfix"<?php print $attributes; ?>>
  <!--    Title, subtitle and content fields-->
  <?php print render($title_prefix); ?>
 <center>  <div class="addthis_inline_share_toolbox"></div> </center>
  <div class="slideshow-title">
    <h2 <?php print $title_attributes; ?>><?php print $title; ?></h2>
    <?php
      //Gigya share without comment
      $block_gigya_share_Object = block_load('gigya', 'gigya_share_without_comments');
      $block_gigya_share = _block_get_renderable_array(_block_render_blocks(array($block_gigya_share_Object)));
      $gigya_share = drupal_render($block_gigya_share);

      print $gigya_share;
    ?>
  </div>
  <?php print render($title_suffix); ?>

  <?php if (!empty($content['field_slideshow_data_source']) && !empty($node->field_slideshow_data_source['und'][0]['url'])): ?>
    <?php print render($content['field_slideshow_data_source']); ?>
  <?php elseif (!empty($content['field_slideshow_photos'])):; ?>


    <?php

    function addThis() {

      $hash = rand(0,9999);

      $addthis = <<<ADTAG
  <script>

var syncCookieValue;
if(jQuery.cookie('syncwall-active-subscriber') == 'true'){
    syncCookieValue = 'y';
}else{
    syncCookieValue = 'n';
}

    if (typeof googletag !== "undefined") {
      var ctype;
      var taxonomy;
      if (typeof  Drupal.settings.tealium != "undefined") {
        ctype = Drupal.settings.tealium.ctype;
      } else {
        ctype = ""
      }
      if (typeof  Drupal.settings.tealium != "undefined") {
        taxonomy = Drupal.settings.tealium.sections;
      } else {
        taxonomy = ""
      }
    }
  </script>
  <div id="300250ad$hash" class="adslot">
    <script>
      if (typeof googletag !== "undefined") {

        googletag.cmd.push(function () {

          //Adslot 1 declaration
         googletag.defineSlot(NMTdata.ads.dfp_adunit_prefix + NMTdata.ads.dfp_adunit, [300, 250], "300250ad$hash")
            .addService(googletag.pubads())
            .setTargeting("pos", ["300x250_1"])
            .setTargeting("content_type", ctype)
            .setTargeting("Taxonomy", taxonomy)
            .setTargeting("pplogin", syncCookieValue)
            .setCollapseEmptyDiv(false)
            .setTargeting("ccc", NMTdata.ads.dfp_ccc);
          googletag.pubads().enableSingleRequest();
          googletag.enableServices();
          googletag.display("300250ad$hash");

        })
      }

    </script>
  </div>
ADTAG;

      return $addthis;
    }

    ?>
    <?php if (isset($node->field_enable_ads)) {
      if($node->field_enable_ads['und'][0]['value'] == "1") {
        global $base_url;
        $freq = variable_get('slideshowfield_ad_frequency', 5);



        $names = $content['field_slideshow_photos']['#items'];

        for($i=1;$i<count($names)+1;$i++) {
          $modul = $i % $freq;
          if ($modul == 0) {
            array_splice($names, $i-1, 0,addThis());
          }
        }

        $new = $names;

//        $new = array_reduce(
//          array_map(
//            function($i) use($addthis, $freq) { return count($i) == $freq ? array_merge($i, array($addthis)) : $i; },
//            array_chunk($names, $freq)
//          ),
//          function($r, $i) { return array_merge($r, $i); },
//          array()
//        );
      }  else {
        $new = $content['field_slideshow_photos']['#items'];
      }
    }

    ?>
    <?php $imgno = count($new); ?>
    <?php ($imgno > 1) ? $slider = TRUE : $slider = FALSE; ?>
    <?php if ($slider): ?>
      <!--        Slick slider-->
      <?php
      drupal_add_css('//cdn.jsdelivr.net/jquery.slick/1.5.8/slick.css', 'external');
      drupal_add_js('//cdn.jsdelivr.net/jquery.slick/1.5.8/slick.min.js', 'external');
      ?>

      <script type="text/javascript">
        jQuery(document).ready(function ($) {

          var _ = $('.slideshow-page');
          var skipHashChangeEvent = false;

          var doHashMagic = function () {
            if (skipHashChangeEvent) {
              skipHashChangeEvent = false;
              return;
            }
            hash = location.hash.replace(/^#slide-/, '');

            var noslides = $(".slick-track > div").size();
            if (!hash){
              hash = 1;
            }
            $('.slide-number').html(hash);
            $('.slide-total').html("of " + (noslides - 2));

            if (isNumber(hash)) {
              _.slick('slickGoTo', parseInt(hash) - 1);
            }
          };

          function isNumber(n) {
            return !isNaN(parseFloat(n)) && isFinite(n);
          }

          _.slick({
            lazyLoad: 'ondemand',
            cssEase: 'linear',
            accessibility: false,
            adaptiveHeight: true,
            appendArrows: '.slideshow-title',
            prevArrow: '<button type="button" class="slick-prev slick-arrow glyph glyph-btn glyph-arrow-right"></button>',
            nextArrow: '<button type="button" class="slick-next slick-arrow glyph glyph-btn glyph-arrow-right"></button>'
          });


          _.on('afterChange', function (event, slick, currentSlide) {
            window.location.hash = '#slide-' + (currentSlide + 1).toString();
          });

          $(window).hashchange(function () {
            doHashMagic();
          });

          $('.node-slideshow .slick-arrow').on('click',function() {
            googletag.pubads().refresh();
          });
          doHashMagic();

        });
      </script>
      <div class="slideshow-page">
        <?php
        foreach ($new as $key => $value) {
          if (is_numeric($key)) {

            if (isset($value['type'])) {
              if ($value['type'] === 'image') {
                if (!empty($value['field_file_image_title_text'])) {
                  $value_title = $value['field_file_image_title_text']['und'][0]['value'];
                }
                if (!empty($value['field_image_description'])) {
                  $value_desc = $value['field_image_description']['und'][0]['value'];
                }
                $img_uri = $value['uri'];
                $style_name = 'slideshow__640x360';
                $image_url = image_style_url($style_name, $img_uri);
                $value = '<img class="img-responsive" data-lazy="' . $image_url . '">';
              }
            }           ?>
            <div class="slide-wrap row gutterless">
            <div class="slide-counter pull-right"> <?php  print $key+1 . ' of ' .$imgno;  ?></div>

            <div class="slide-image-controls <?php if (isset($value_title) || isset($value_desc)) {
              echo('col-md-8');
            } ?>">
              <div>

                <?php
                print render($value);
                ?>
              </div>

            </div>
            <?php if (isset($value_title) || isset($value_desc)): ?>
              <div class="col-md-4">
                <?php if (isset($value_title)): ?>
                  <div class="field-file-image-title-text">
                    <?php print $value_title; ?>
                  </div>
                <?php endif; ?>
                <?php if (isset($value_desc)): ?>
                  <div class="field-image-description">
                    <?php print $value_desc; ?>
                  </div>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            </div><?php
          }
          unset($value_title);
          unset($value_desc);
        }?></div>
    <?php else: ?>
      <!--        Single image-->
      <div class="box-row"><?php print render($content['field_slideshow_photos']); ?></div>
    <?php endif; ?>
  <?php endif; ?>
  <?php if (!empty($content['field_slideshow_body'])): ?>
   
    <?php print render($content['field_slideshow_body']); ?>
  <?php endif; ?>

</div>
