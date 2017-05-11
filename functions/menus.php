<?php
function register_logos_menu() {
  register_nav_menu('logos-menu',__( 'Menú de logos' ));
}
add_action( 'init', 'register_logos_menu' );
