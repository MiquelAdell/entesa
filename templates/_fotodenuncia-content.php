<div class="mosaic-item">
	<div class="content">
		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<div class="card">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<?php
				$term_list = wp_get_post_terms($post->ID, 'tipus_de_fotodenuncia');
				$term = $term_list[0];
				?>
				<h4><a href="<?=get_term_link( $term )?>"><?=$term->name?></h4></p>
				<div class="entry-meta">
					<?php understrap_posted_on(); ?>
				</div><!-- .entry-meta -->
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
			</div>
			<div class="image" style="background-image:url('<?=get_the_post_thumbnail_url( $post->ID, 'large' ); ?>')"></div>
		</article><!-- #post-## -->
	</div>
</div>
