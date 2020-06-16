<?php
  $text = get_sub_field('text_with_image');
  $image = get_sub_field('image');
  $imagePosition = get_sub_field('image_position');
?>

<?php echo $text;

?>

<div class="image-and-text">
  <?php if($imagePosition == 'left'): ?>
  <?php endif; ?>

  <div class="">
    <?php echo $text; ?>
  </div>

  <?php if($imagePosition == 'right'): ?>
  <?php endif; ?>
</div>
