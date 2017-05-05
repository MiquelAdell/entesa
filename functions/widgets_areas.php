<?php
if ( function_exists('register_sidebar') )
  register_sidebar(array(
    'name' => 'Last Navigation Element',
    'before_widget' => '<div class = "lastNavigationElement">',
    'after_widget' => '</div>',
    'before_title' => '<span class="title">',
    'after_title' => '</span>',
  )
);
