<?php
/**
 * Plugin Name: Event preview boxes
 * Description: Adds shortcode to display eventbrite events.
 */

add_shortcode('spouse-events', 'spouse_show_eventboxes');

/**
 * @param array $atts
 *    $atts['count'] : int - number of posts to show. -1 = all
 * @return void
 */
function spouse_show_eventboxes($atts = []){
  $count = 5;
  if(isset($atts['count']) && $atts['count'] != 0) {
    $count = $atts['count'];
  }

  $events = spouse_get_events($count);
  if(!$events){
    return '';
  }
  spouse_print_events($events);
}

function spouse_get_events($count) {
  $args = [
    'post_type' => 'eventbrite_events',
    'post_status' => 'publish',
    'numberposts' => $count,
    'orderby' => 'date',
    'order' => 'ASC',
  ];

  $posts = wp_get_recent_posts($args, OBJECT);

  return $posts;
}

function spouse_print_events($events = []){
  foreach($events as $event){

    $color = '#fff';

    $startDate = null;

    $terms = get_the_terms($event->ID, 'eventbrite_category');

    $icon = get_field('icon', $event->ID);

    $category = '';
    if($terms && $term = reset($terms)) {
      $color = get_field('event_color', $term);
      $category = $term->name;
    }

    if($dateData = get_post_meta($event->ID, 'event_start_date')) {

      $date = new \DateTime();
      $date->setTimestamp(strtotime($dateData[0]));
      $startDate = $date->format('d/m');

      $hour = get_post_meta($event->ID, 'event_start_hour')[0];
      $minute = get_post_meta($event->ID, 'event_start_minute')[0];

      $endHour = get_post_meta($event->ID, 'event_end_hour')[0];
      $endMinute = get_post_meta($event->ID, 'event_end_minute')[0];
      $meridian = get_post_meta($event->ID, 'event_start_meridian')[0];

      $startTime = "$hour:$minute $meridian";
      $endTime = "$endHour:$endMinute $meridian";
    }

    ?>

    <?php if(is_user_logged_in()): ?>
      <a href="<?php echo get_permalink($event) ?>">

    <?php endif; ?>
    <?php
    $popupClass = '';
    if(!is_user_logged_in()) {
      $popupClass = 'popup-hover ';
    }
    ?>
    <div class="event <?php echo $popupClass ?>clearfix">
      <div class="event-color" <?php if(isset($color) && $color): ?>style="background-color:<?php echo $color; ?>" <?php endif; ?>></div>
      <div class="event-start"><?php echo $startDate; ?></div>
      <div class="event-content">
        <div class="text-content">
          <p class=""><?php echo $category ?></p>
          <p class=""><?php echo $event->post_title ?></p>
          <p><?php echo $startTime; ?> - <?php echo $endTime; ?></p>
        </div>
      </div>
      <div class="event-icon"><img src="<?php echo $icon ?>"></div>
      <i class="clearfix"></i>
      <div class="popuptext">
        Sign in to see more
      </div>
    </div>
    <?php if(is_user_logged_in()): ?>
      </a>
    <?php endif; ?>

    <?php

  }
}
