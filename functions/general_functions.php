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
