<?php

$personFields = [
  'phone' => '',
  'availability' => '',
];

$person = get_sub_field('person');
$values = get_fields($person->ID);

foreach($personFields as $key => $field){
    $personFields[$key] = $values[$key];
}
$image = $values['image'];
?>

<div class="col-12 person">
    <div class="img person-image pull-left">
  <?php if($image): ?>
    <img class="img-fluid" src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>">
    <?php if($values['name']): ?>
      <p class="person-title"><?php echo $values['name']; ?></p>
    <?php endif; ?>
  <?php endif; ?>
    </div>
    <div class="person-content pull-left">
      <!--
      <?php if($values['title']): ?>
          <p><span style="font-weight: bold">Title:</span><br/><?php echo $values['title']; ?></p>
      <?php endif; ?>
      -->
      <?php if($values['description']): ?>
          <p class="person-description"><?php echo $values['description']; ?></p>
      <?php endif; ?>

      <span>Contact:</span><br/>
      <?php if($values['email']): ?>
          <a href="mailto:<?php echo $values['email']; ?>"><?php echo $values['email']; ?></a>
      <?php endif; ?>
      <?php foreach($personFields as $key => $field): ?>
          <p class="person-<?php echo $key; ?>"><span style="font-weight: bold"><?php echo ucfirst($key); ?></span> <br/><?php echo $field; ?></p>
      <?php endforeach; ?>
      <?php if($values['linkedin']): ?>
          <a class="person-linkedin" href="<?php echo $values['linkedin']; ?>">LinkedIn</a>
      <?php endif; ?>
    </div>
    <i class="clearfix"></i>
</div>


<!--
<div class="col-12 col-lg-6 person">
  <?php if($image): ?>
  <div style="min-height: 100px;" class="img person-image pull-left">
      <img class="img-fluid" src="<?php echo $image ?>">
        <?php if($values['name']): ?>
            <p class="person-title"><?php echo $values['name']; ?></p>
        <?php endif; ?>

  </div>
  <?php endif; ?>
  <div class="person-content pull-left">

      <?php if($values['title']): ?>
        <p><span style="font-weight: bold">Title:</span><br/><?php echo $values['title']; ?></p>
      <?php endif; ?>
    <?php if($values['description']): ?>
        <p class="person-description"><?php echo $values['description']; ?></p>
    <?php endif; ?>
    <span style="font-weight: bold">Contact:</span>
    <?php if($values['email']): ?>
        <a href="mailto:<?php echo $values['email']; ?>"><?php echo $values['email']; ?></a>
    <?php endif; ?>

    <?php foreach($personFields as $key => $field): ?>
        <p class="person-<?php echo $key; ?>"><span style="font-weight: bold"><?php echo $key ?></span> <br/><?php echo $field; ?></p>
    <?php endforeach; ?>

    <?php if($values['linkedin']): ?>
        <a class="person-linkedin" href="<?php echo $values['linkedin']; ?>">LinkedIn</a>
    <?php endif; ?>

  </div>
</div>
-->
<?php
