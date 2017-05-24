<?php
/**
* Plugin Name: Entesa per Sabadell Custom Tools
* Plugin URI: https://entesa.org
* Description: Plugin with custom functionality for entesa's website
* Version: 1.0.0
* Author: Miquel Adell
* Author URI: http://miqueladell.com
* License: GPL v3
*/
// Creating the widget
class highlight_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'highlight_widget',

			// Widget name will appear in UI
			__('WPBeginner Widget', 'entesa'),

			// Widget description
			array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'entesa' ), )
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];

		// This is where you run the code and display the output
		?>

		<?php
		echo $args['after_widget'];
	}

	// Widget Backend
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'entesa' );
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Class highlight_widget ends here

// Register and load the widget
function highlight_load_widget() {
	register_widget( 'highlight_widget' );
}
add_action( 'widgets_init', 'highlight_load_widget' );



function entesa_highlights_init() {
	if ( !function_exists( 'register_sidebar_widget' ))
	return;

	function entesa_highlights($args) {
		global $post;
		extract($args);

		// These are our own options
		$options = get_option( 'entesa_highlights' );
		$title = $options['title']; // Widget title
		$phead = $options['phead']; // Heading format
		$ptype = $options['ptype']; // Post type
		$pshow = $options['pshow']; // Number of Tweets

		$beforetitle = '';
		$aftertitle = '';

		// Output
		echo $before_widget;

		if ($title) echo $beforetitle . '<h2 class="fancy"><span>'.$title.'</span></h2>' . $aftertitle;

		$pq = new WP_Query(array( 'post_type' => $ptype, 'showposts' => $pshow ));
		if( $pq->have_posts() ) :
			?>
			<ul>
				<ul><?php while($pq->have_posts()) : $pq->the_post(); ?>
					<li><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></li>
				</ul>
			</ul>
			<?php wp_reset_query();
		endwhile; ?>

	<?php endif; ?>

	<!-- NEEDS FIX: to display link to full list of posts page
	<?php $obj = get_post_type_object($ptype); ?>
	<div class="highlights_icon"><a href="<?php site_url('/'.$obj->query_var); ?>" rel="bookmark"><?php _e( 'View all ' . $obj->labels->name . ' posts' ); ?>&rarr;</a></div>
	//-->

	<?php
	// echo widget closing tag
	echo $after_widget;
}

/**
* Widget settings form function
*/
function entesa_highlights_control() {

	// Get options
	$options = get_option( 'entesa_highlights' );
	// options exist? if not set defaults
	if ( !is_array( $options ))
	$options = array(
		'title' => 'Destacats',
		'phead' => 'h2',
		'ptype' => 'destacat',
		'pshow' => '1'
	);
	// form posted?
	if ( $_POST['latest-cpt-submit'] ) {
		$options['title'] = strip_tags( $_POST['latest-cpt-title'] );
		$options['phead'] = $_POST['latest-cpt-phead'];
		$options['ptype'] = $_POST['latest-cpt-ptype'];
		$options['pshow'] = $_POST['latest-cpt-pshow'];
		update_option( 'entesa_highlights', $options );
	}
	// Get options for form fields to show
	$title = $options['title'];
	$phead = $options['phead'];
	$ptype = $options['ptype'];
	$pshow = $options['pshow'];

	// The widget form fields
	?>

	<label for="latest-cpt-title"><?php echo __( 'Widget Title' ); ?>
		<input id="latest-cpt-title" type="text" name="latest-cpt-title" size="30" value="<?php echo $title; ?>" />
	</label>

	<label for="latest-cpt-phead"><?php echo __( 'Widget Heading Format' ); ?></label>

	<select name="latest-cpt-phead"><option selected="selected" value="h2">H2 - <h2></h2></option><option selected="selected" value="h3">H3 - <h3></h3></option><option selected="selected" value="h4">H4 - <h4></h4></option><option selected="selected" value="strong">Bold - <strong></strong></option></select><select name="latest-cpt-ptype"><option value="">- <?php echo __( 'Select Post Type' ); ?> -</option></select><?php $args = array( 'public' => true );
	$post_types = get_post_types( $args, 'names' );
	foreach ($post_types as $post_type ) { ?>

		<select name="latest-cpt-ptype"><option selected="selected" value="<?php echo $post_type; ?>"><?php echo $post_type;?></option></select><?php } ?>

		<label for="latest-cpt-pshow"><?php echo __( 'Number of posts to show' ); ?>
			<input id="latest-cpt-pshow" type="text" name="latest-cpt-pshow" size="2" value="<?php echo $pshow; ?>" />
		</label>

		<input id="latest-cpt-submit" type="hidden" name="latest-cpt-submit" value="1" />
		<?php
	}

	wp_register_sidebar_widget( 'widget_highlights', __('Destacats','entesa'), 'entesa_highlights' );
	wp_register_widget_control( 'widget_highlights', __('Destacats','entesa'), 'entesa_highlights_control', 300, 200 );

}
add_action( 'widgets_init', 'entesa_highlights_init' );
