<div class="slideshow">
  <?php foreach ($slides as $key => $slide): ?>
    <div class="slideshowfield-slide">
      <div class="slide-photo">
        <div>
          <img data-lazy="<?php print $slide['photo']; ?>"/>
        </div>
      </div>
      <div class="slide-content">
        <div class="slide-header">
          <span class="slide-number"><?php print $key + 1; ?></span>
          <span class="slide-total"><?php print t('of') . ' ' . $total_items; ?></span>
<!--          <span class="share-icons">Face | Twitter | G+ | Mail</span>-->
        </div>
        <?php if (isset($slide['title'])): ?>
          <h3 class="slide-title"><?php print $slide['title']; ?></h3>
        <?php endif; ?>
        <div class="slide-caption"><?php print $slide['caption']; ?></div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
