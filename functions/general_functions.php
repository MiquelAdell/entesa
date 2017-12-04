<?php
function text_with_link($text, $link = null) {
	if($link){
		return "<a href='".$link."'>".$text."</a>";
	}
	else {
		return $text;
	}
}


add_action('do_meta_boxes', 'customposttype_image_box');

function customposttype_image_box() {

	remove_meta_box( 'postimagediv', 'customposttype', 'side' );

	add_meta_box('postimagediv', __('Custom Image'), 'post_thumbnail_meta_box', 'customposttype', 'normal', 'high');

}


function understrap_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
			<nav class="container navigation post-navigation">
				<h2 class="sr-only"><?php _e( 'Post navigation', 'understrap' ); ?></h2>
				<div class="row nav-links justify-content-between">
					<?php

						if ( get_previous_post_link() ) {
							previous_post_link( '<span class="nav-previous">%link</span>', _x( '<i class="fa fa-angle-left"></i><span>%title</span>', 'Previous post link', 'understrap' ) );
						}
						if ( get_next_post_link() ) {
							next_post_link( '<span class="nav-next">%link</span>',     _x( '<span>%title</span><i class="fa fa-angle-right"></i>', 'Next post link', 'understrap' ) );
						}
					?>
				</div><!-- .nav-links -->
			</nav><!-- .navigation -->

	<?php
}
