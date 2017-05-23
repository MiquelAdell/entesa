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
