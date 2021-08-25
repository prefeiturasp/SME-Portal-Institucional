<?php do_action( 'before_sidebar' ); ?>
 
  <?php
    $sidebar = get_sub_field('select_sidebar');
    if($sidebar != 'none'){
      dynamic_sidebar($sidebar);
    };
  ?>
 
  <?php do_action( 'after_sidebar' ); ?>