<?php
define('WP_USE_THEMES', false);
require_once( $_SERVER['DOCUMENT_ROOT'] ."/wp-load.php" );


/*
moure arxius a la carpeta correpsonent de pujades
buscar allà i crear l'attachment des d'allà
mirar que passa amb l'enllaç de l'attachments

XXX http://entesa.miqueladell.com/wp-content/uploads/home/miqueladell/entesa.miqueladell.com/wp-content/entesa_old/IMG/pdf_Diari_ES_2011_x_web.pdf
*/
// Get the path to the upload directory.


$wp_upload_dir = wp_upload_dir();

$qry = "
SELECT
d.titre as title, d.fichier as file, a.id_article
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
				'value' => $row->id_article
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

	if(file_exists($filename)){
		//move to the upload directory
		//change that to move
		// copy($filename, $new_filename);


		rename($filename, $new_filename);

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

		// Generate the metadata for the attachment, and update the database record.
		$attach_data = wp_generate_attachment_metadata( $attach_id, $new_filename );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		$meta = get_post_meta($post_id);
		set_post_thumbnail( $post_id, $attach_id );

		set_post_thumbnail( $post_id, $thumbnail_id );


		if(!$row->title){
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
