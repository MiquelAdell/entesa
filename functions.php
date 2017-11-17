<?php
function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );

	// Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Get the theme data
	$the_theme = wp_get_theme();

	wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), filemtime( get_stylesheet_directory() . '/css/child-theme.min.css' ) );
	wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), filemtime( get_stylesheet_directory() . '/js/child-theme.min.js' ), true );
}


require_once __DIR__ . '/vendor/autoload.php';
use PostTypes\PostType;

require_once('CPT/autoload.php');
require_once('functions/autoload.php');


add_filter( 'embed_defaults', 'change_embed_size' );

function change_embed_size() {
	// Adjust values
	return array('width' => 730, 'height' => 800);
}


add_filter('the_content', 'emd_content');

function emd_content( $content ) {
	$subtitle = get_field('soustitre');
	if(!$subtitle) {
		return $content;
	}
	if(is_array($subtitle)){
		$subtitle = $subtitle[0];
	}
	if(!is_string($subtitle)){
		return $content;
	}
	$content = "<h2 class='entry_subtitle'>".$subtitle."</h2>".$content;
	return $content;
}


// if ( !function_exists( 'fgs2wp_documents_load' ) ) {
// 	function fgs2wp_documents_load() {
// 		if ( !defined('FGS2WPP_LOADED') ) return;
//
// 		load_plugin_textdomain( 'fgs2wp_documents', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
//
// 		global $fgs2wpp;
// 		new fgs2wp_documents($fgs2wpp);
// 	}
// }

/*
moure arxius a la carpeta correpsonent de pujades
buscar allà i crear l'attachment des d'allà
mirar que passa amb l'enllaç de l'attachments

XXX http://entesa.miqueladell.com/wp-content/uploads/home/miqueladell/entesa.miqueladell.com/wp-content/entesa_old/IMG/pdf_Diari_ES_2011_x_web.pdf
*/
// Get the path to the upload directory.

/*
$wp_upload_dir = wp_upload_dir();

$qry = "
SELECT
d.titre as title, d.fichier as file, a.id_article as old_id
FROM spip_documents d
INNER JOIN spip_documents_liens dl ON dl.id_document = d.id_document AND objet = 'article'
INNER JOIN spip_articles a ON a.id_article = dl.id_objet
WHERE
d.statut = 'publie' AND extension in ('doc', 'html', 'mp3', 'pdf', 'swf')
";


$states = $wpdb->get_results( $qry );
foreach( $states as $row ) {



	$args = array(
		'meta_query' => array(
			array(
				'key' => '_fgs2wp_old_article_id',
				'value' => $row->old_id
			)
		)
	);
	$posts = get_posts( $args );
	$post_id = $posts[0]->ID;

	$meta = get_post_meta($post_id);
	$attached_media = get_attached_media('image',$post_id);
	$thumbnail_id = get_post_thumbnail_id( $post_id );



	// $filename should be the path to a file in the upload directory.
	$filename = '/home/miqueladell/entesa.miqueladell.com/wp-content/entesa_old/IMG/'.$row->file;
	$new_filename = $wp_upload_dir['path']."/".basename( $filename );

	if(file_exists($filename) || file_exists($new_filename) ){
		//move to the upload directory
		//change that to move
		// copy($filename, $new_filename);

		if(!file_exists($new_filename)){
			rename($filename, $new_filename);
		}

		// Check the type of file. We'll use this as the 'post_mime_type'.
		$filetype = wp_check_filetype( basename( $new_filename ), null );


		// Prepare an array of post data for the attachment.
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $new_filename ),
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $new_filename ) ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);

		// Insert the attachment.
		$attach_id = wp_insert_attachment( $attachment, $new_filename, $post_id );

		// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );


		// Generate the metadata for the attachment, and update the database record.
		$attach_data = wp_generate_attachment_metadata( $attach_id, $new_filename );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		$meta = get_post_meta($post_id);
		set_post_thumbnail( $post_id, $attach_id );

		set_post_thumbnail( $post_id, $thumbnail_id );


		if($row->title){
			$title = $row->title;
		}
		else {
			$title = basename( $new_filename );
		}

		$attachments = array(
				"id" => $attach_id,
				"fields" => array(
					"title" => $title,
					"caption" => ""
				)
		);
		$attachments = '{"attachments":['.json_encode($attachments).']}';

		add_post_meta( $post_id, 'attachments', $attachments );
	} else {
		echo "does not exist: ".$filename."<br>";
	}
}
die();
*/
