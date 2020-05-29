<?php get_header(); ?>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.1/fullcalendar.min.css">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.1/fullcalendar.min.js"></script>
<?php

global $wpdb;
$query = "
    SELECT p.id,
    p.post_type,
    p.post_status,
    p.post_title,
    p.post_excerpt,
    wp_terms.name as category,
    GROUP_CONCAT(pm.meta_key ORDER BY pm.meta_key DESC SEPARATOR '||') as meta_keys,
    GROUP_CONCAT(pm.meta_value ORDER BY pm.meta_key DESC SEPARATOR '||') as meta_values
    FROM $wpdb->posts p 
    LEFT JOIN $wpdb->postmeta pm on pm.post_id = p.ID 
    LEFT JOIN wp_term_relationships ON (p.ID = wp_term_relationships.object_id)
    LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
    LEFT JOIN wp_terms on (wp_terms.term_id = wp_term_taxonomy.term_id)
    WHERE p.post_type = 'eventbrite_events'
    AND p.post_status = 'publish'
    GROUP BY p.ID
";

$data = $wpdb->get_results($query);
$meta = [];
$events = [];
$count = [];

foreach($data as $post) {
    $color = get_field('color', $post->id);
    $event = [];
    $keys = explode('||',$post->meta_keys);
    $values = explode('||',$post->meta_values);
    foreach($keys as $key => $val){
      $meta[$val] = $values[$key];
    }
    $event['id'] = $post->id;
    $event['title'] = $post->post_title;
    $event['start'] = $meta['event_start_date'];
    $event['starttime'] = "{$meta['event_start_hour']}:{$meta['event_start_minute']}{$meta['event_start_meridian']}";
    $event['description'] = $post->post_excerpt;
    $event['category'] = $post->category;
    $event['venue_name'] = $meta['venue_name'];
    $event['venue_address'] = "{$meta['venue_address']}, {$meta['venue_zipcode']} {$meta['venue_city']}";
    $event['url'] = get_permalink($post->id);
    if($meta['event_start_date']){
      $year = explode('-', $meta['event_start_date'])[0];
      $month = ltrim(explode('-', $meta['event_start_date'])[1], '0');
      $count[$year][$month] = is_numeric($count[$year][$month]) ? $count[$year][$month] : 1;
    }
    $events[] = $event;
}

?>

<script>
  window.spouse_events_counts = JSON.parse('<?php echo json_encode($count)?>');
  window.spouse_events = JSON.parse('<?php echo json_encode($events)?>');
</script>

<div class="container-fluid">
  <div class="row">
    <div class="col-3">
      <div class="events-date">

          <div class="controls">
              <div id="spouse-fc-prevyear">
                  <<
              </div>
              <div id="current-year"><?php echo date('Y'); ?></div>
              <div id="spouse-fc-nextyear">
                  >>
              </div>
              <i class="clearfix"></i>
          </div>
          <div class="months">
              <?php
              $months = [];
              for($m=1; $m<=12; ++$m){
                $months[] = date('F', mktime(0, 0, 0, $m, 1));
              }

              foreach($months as $key => $month):
              ?>
                  <div class="month <?php echo lcfirst($month); ?><?php if(date('F') == $month){ echo ' active';} ?>">
                    <?php echo $month; ?><span class="count"><?php echo $count[date('Y')][$key+1] ?? 0 ?></span>
                  </div>
              <?php
              endforeach;
              ?>
          </div>
      </div>
    </div>

    <div class="col-6">
      <div id="events-calendar" class="events-calendar">
      </div>
    </div>

    <div class="col-3">
      <div class="events-column">
        <h2>Events</h2>
        <div class="event-list">
        </div>
      </div>
    </div>
  </div>
</div>

<script>

jQuery(document).ready(function(){
  $('#events-calendar').fullCalendar({
    header: {
      left: '',
      center: 'title',
      right: ''
    },
    events: window.spouse_events,
    lang: 'en',
    eventLimit: 1,
    eventRender: function(event){
      const html = `<div class="event clearfix">
          <a href="${event.url}">
            <div class="event-color" style="background-color:"></div>
            <div class="event-content">
              <div style="font-size:22px; padding-right:20px;" class="event-start">${event.start.format('d')}</div>
              <div class="text-content">
                <span class="">${event.category}</span>
                <p>${event.starttime}</p>
                <p>${event.venue_address}</p>
              </div>
            </div>
            <div class="event-icon"><img src=""></div>
            <i class="clearfix"></i>
          </a>
        </div>`;

      // prevent appending before clear has been done
      setTimeout( function(){
          jQuery('.event-list').append(html)
      }, 50);

    },
    eventMouseover: function (data, event, view) {

      const tooltip = '' +
        '<div class="tooltiptopicevent" style="width:auto;height:auto;background:#ececec;position:absolute;z-index:10001;padding:10px 10px 10px 10px ;  line-height: 200%;">' +
        '' + 'Title: ' + ': ' + data.title + '</br>' +
         'Start: '+ data.starttime + ': ' + data.venue_name + '</br>' +
              'Address:' + data.venue_address
        '</div>'
      $("body").append(tooltip);
      $(this).mouseover(function (e) {
        $(this).css('z-index', 10000);
        $('.tooltiptopicevent').fadeIn('500');
        $('.tooltiptopicevent').fadeTo('10', 1.9);
      }).mousemove(function (e) {
        $('.tooltiptopicevent').css('top', e.pageY + 10);
        $('.tooltiptopicevent').css('left', e.pageX + 20);
      });


    },
    eventMouseout: function (data, event, view) {
      $(this).css('z-index', 8);
      $('.tooltiptopicevent').remove();
    },
  });

  const calendar = $('#events-calendar').fullCalendar();

  $('#spouse-fc-prevyear').click( function (){
    calendar.fullCalendar('prevYear');
    $('#current-year').text(calendar.fullCalendar('getDate').year());
    renderEventCounts(calendar.fullCalendar('getDate').year());
    clearEventList();
  });

  $('#spouse-fc-nextyear').click( function (){
    calendar.fullCalendar('nextYear')
    $('#current-year').text(calendar.fullCalendar('getDate').year());
    renderEventCounts(calendar.fullCalendar('getDate').year());
    clearEventList();
  });

  $('.month').click(function(event){
    const month = event.target.innerHTML.trim()
    const date = moment().month(month);
    calendar.fullCalendar('gotoDate', date);
    $('.month').removeClass('active');
    $(event.target).addClass('active');
    clearEventList();
  })

});

</script>

<script>
function renderEventCounts(year){
  let month = 0;
  let skip = false;
  if(!window.spouse_events_counts[year]) {
    skip = true;
  }
  jQuery('.month').each(function(e){
    if(skip){
      jQuery(jQuery('.month')[month]).find('span').text(0);
    } else {
      let count = window.spouse_events_counts[year][month+1];
      if(count){
        jQuery(jQuery('.month')[month]).find('span').text(count);
      } else {
        jQuery(jQuery('.month')[month]).find('span').text(0);
      }
    }
    month++
  })
}
function clearEventList(){
  jQuery('.event-list').empty();
}
</script>

<?php get_footer();
