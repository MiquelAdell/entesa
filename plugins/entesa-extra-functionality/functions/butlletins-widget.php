<?php
function entesa_butlletins_init() {
	if ( !function_exists( 'register_sidebar_widget' ))
	return;

	function entesa_butlletins($args) {
		global $post;
		extract($args);

		// These are our own options
		$options = get_option( 'entesa_butlletins' );
		$title = $options['title']; // Widget title
		$pshow = $options['pshow']; // Number of elements

		$beforetitle = '';
		$aftertitle = '';

		// Output
		echo $before_widget;

		if ($title) echo $beforetitle . '<h2 class="fancy"><span>'.$title.'</span></h2>' . $aftertitle;

		$pq = new WP_Query(array( 'post_type' => $ptype, 'showposts' => $pshow, 'category_name' => 'Butlletí de l\'Entesa' ));
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
					</li>
				<?php endwhile; ?>
			</ul>
			<?php wp_reset_query(); ?>

		<?php endif; ?>

		<!-- NEEDS FIX: to display link to full list of posts page
		<?php $obj = get_post_type_object($ptype); ?>
		<div class="butlletins_icon"><a href="<?php site_url('/'.$obj->query_var); ?>" rel="bookmark"><?php _e( 'View all ' . $obj->labels->name . ' posts' ); ?>&rarr;</a></div>
		//-->

		<?php
		// echo widget closing tag
		echo $after_widget;
	}

	/**
	* Widget settings form function
	*/
	function entesa_butlletins_control() {

		// Get options
		$options = get_option( 'entesa_butlletins' );
		// options exist? if not set defaults
		if ( !is_array( $options ))
		$options = array(
			'title' => 'Butlleti',
			'phead' => 'h2',
			'ptype' => 'post',
			'pshow' => '1'
		);
		// form posted?
		if ( $_POST['latest-cpt-submit'] ) {
			$options['title'] = strip_tags( $_POST['latest-cpt-title'] );
			$options['pshow'] = $_POST['latest-cpt-pshow'];
			update_option( 'entesa_butlletins', $options );
		}
		// Get options for form fields to show
		$title = $options['title'];
		$pshow = $options['pshow'];

		// The widget form fields
		?>
		<label for="latest-cpt-title"><?php echo __( 'Widget Title' ); ?>
			<input id="latest-cpt-title" type="text" name="latest-cpt-title" size="30" value="<?php echo $title; ?>" />
		</label>
		<label for="latest-cpt-pshow"><?php echo __( 'Número d\'elements d\'agenda a mostrar','entesa' ); ?>
			<input id="latest-cpt-pshow" type="text" name="latest-cpt-pshow" size="2" value="<?php echo $pshow; ?>" />
		</label>

		<input id="latest-cpt-submit" type="hidden" name="latest-cpt-submit" value="1" />
		<?php
	}

	wp_register_sidebar_widget( 'widget_butlletins', __('Butlletins','entesa'), 'entesa_butlletins' );
	wp_register_widget_control( 'widget_butlletins', __('Butlletins','entesa'), 'entesa_butlletins_control', 300, 200 );

}
add_action( 'widgets_init', 'entesa_butlletins_init' );
