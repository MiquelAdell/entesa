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
						<h1 class="page-title">
							<?php
							if(get_the_archive_title() == "Arxiu: Fotodenúncies"){
								echo "Fotodenúncies";
							} else {
								echo get_the_archive_title();
							}
							?>
						</h1>
						<div class="taxonomy-description">
							<p>Aquest és un espai obert a la participació de tothom que vulgui denunciar alguna situació injusta, incoherent, absurda… de la ciutat o del rodal. Us animem a participar!</p>
							<p>Envia’ns la teva imatge de denúncia a <a href="mailto:entesaxsabadell@gmail.com">entesaxsabadell@gmail.com</a></p>
						</div>
					</header><!-- .page-header -->

					<?php /* Start the Loop */ ?>
					<div class="mosaic">
					<?php
					while ( have_posts() ) : the_post();
						include(get_stylesheet_directory().'/templates/_fotodenuncia-content.php');
					endwhile;
					?>
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
