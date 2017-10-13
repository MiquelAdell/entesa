<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

?>
<div class="content-single">
	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

		<header class="entry-header">

			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

			<div class="entry-meta">

				<?php understrap_posted_on(); ?>

			</div><!-- .entry-meta -->

		</header><!-- .entry-header -->

		<div class="tumbnail-container"><?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?></div>

		<?php if(trim(str_replace('&nbsp;','',strip_tags($post->post_content))) != ''){ ?>
			<div class="entry-content">

				<?php the_content(); ?>


				<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
					'after'  => '</div>',
				) );
				?>

			</div><!-- .entry-content -->
		<?php } ?>


		<?php $attachments = new Attachments( 'attachments' ); ?>
		<?php if( $attachments->exist() ) : ?>
			<div class="entry-content">
				<h3>Adjunts</h3>
				<ul>
					<?php while( $attachments->get() ) : ?>
						<li>
							<a href="<?php echo $attachments->url(); ?>" target="_blank">
								<?php if($attachments->field( 'title' )){ ?>
									<h4>
										<?php echo $attachments->field( 'title' ); ?><br />
									</h4>
								<?php } ?>
								<?php if($attachments->field( 'caption' )){ ?>
									<p>
										<?php echo $attachments->field( 'caption' ); ?>
									</p>
								<?php } ?>
								<?php echo $attachments->image( 'thumbnail' ); ?>
							</a>
						</li>
					<?php endwhile; ?>
				</ul>
			</div>
		<?php endif; ?>

		<footer class="entry-footer">

			<?php understrap_entry_footer(); ?>

		</footer><!-- .entry-footer -->

	</article><!-- #post-## -->
</div>
