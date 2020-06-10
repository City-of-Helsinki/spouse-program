<?php



// check if the repeater field has rows of data
if( have_rows('content') ):

  // loop through the rows of data
  while ( have_rows('content') ) : the_row();



  endwhile;

else :

  // no rows found

endif;

?>
