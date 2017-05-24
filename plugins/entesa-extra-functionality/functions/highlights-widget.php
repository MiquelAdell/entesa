<?php
function entesa_highlights_init() {
	if ( !function_exists( 'register_sidebar_widget' ))
	return;

	function entesa_highlights($args) {
		global $post;
		extract($args);

		// These are our own options
		$options = get_option( 'entesa_highlights' );
		$pshow = $options['pshow']; // Number of Tweets

		$beforetitle = '';
		$aftertitle = '';

		// Output
		echo $before_widget;

		if ($title) echo $beforetitle . '<h2 class="fancy"><span>'.$title.'</span></h2>' . $aftertitle;

		$pq = new WP_Query(array( 'post_type' => 'destacat', 'showposts' => $pshow ));
		?>
		<?php if( $pq->have_posts() ) : ?>
			<ul>
				<?php while($pq->have_posts()) : $pq->the_post(); ?>
					<li>
						<header class="entry-header">
							<h2>
								<a href="<?php the_permalink(); ?>" rel="bookmark">
									<span><?php the_title(); ?></span>
								</a>
							</h2>
						</header>
						<?php echo get_the_post_thumbnail( $page->ID ); ?>
						<div class="entry-content"><?php echo the_content(); ?></div>
					</li>
				<?php endwhile; ?>
			</ul>
			<?php wp_reset_query(); ?>

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
			$options['pshow'] = $_POST['latest-cpt-pshow'];
			update_option( 'entesa_highlights', $options );
		}
		// Get options for form fields to show
		$pshow = $options['pshow'];

		// The widget form fields
		?>

		<label for="latest-cpt-pshow"><?php echo __( 'Número de destacats a mostrar','entesa' ); ?>
			<input id="latest-cpt-pshow" type="text" name="latest-cpt-pshow" size="2" value="<?php echo $pshow; ?>" />
		</label>

		<input id="latest-cpt-submit" type="hidden" name="latest-cpt-submit" value="1" />
		<?php
	}

	wp_register_sidebar_widget( 'widget_highlights', __('Destacats','entesa'), 'entesa_highlights' );
	wp_register_widget_control( 'widget_highlights', __('Destacats','entesa'), 'entesa_highlights_control', 300, 200 );

}
add_action( 'widgets_init', 'entesa_highlights_init' );
