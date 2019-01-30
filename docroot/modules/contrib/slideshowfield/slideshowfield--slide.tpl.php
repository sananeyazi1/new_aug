<div class="slideshow">
  <?php foreach ($slides as $key => $slide): ?>
    <div class="slideshowfield-slide">
      <div>ID: <?php print $key; ?></div>
      <div><img data-lazy="<?php print $slide->photo; ?>" /></div>
      <div>Caption: <?php print $slide->caption; ?></div>
      <div>Total slides: <?php print $total_items; ?></div>
    </div>
  <?php endforeach; ?>
</div>
