<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

get_header();
?>

<?php
$container   = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper fotodenuncia-archive-wrapper" id="archive-wrapper">

	<div class="<?php echo esc_html( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<main class="site-main" id="main">

				<?php if ( have_posts() ) : ?>

					<header class="page-header">
						<h1 class="page-title">Fotodenúncia</h1>
						<div class="taxonomy-description">
							<p>Aquest és un espai obert a la participació de tothom que vulgui denunciar alguna situació injusta, incoherent, absurda… de la ciutat o del rodal. Us animem a participar!</p>
							<p>Envia’ns la teva imatge de denúncia a <a href="mailto:entesaxsabadell@gmail.com">entesaxsabadell@gmail.com</a></p>
						</div>
					</header><!-- .page-header -->

					<?php /* Start the Loop */ ?>
					<div class="mosaic">
					<?php while ( have_posts() ) : the_post(); ?>
						<div class="mosaic-item">

							<div class="content">
								<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

									<div class="card">
										<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

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

					<?php endwhile; ?>
					</div>
				<?php else : ?>

					<?php get_template_part( 'loop-templates/content', 'none' ); ?>

				<?php endif; ?>

			</main><!-- #main -->

			<!-- The pagination component -->
			<?php understrap_pagination(); ?>

		</div><!-- #primary -->

	</div> <!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
