<?php
/**
* The main template file.
*
* This is the most generic template file in a WordPress theme
* and one of the two required files for a theme (the other being style.css).
* It is used to display a page when nothing more specific matches a query.
* E.g., it puts together the home page when no home.php file exists.
* Learn more: http://codex.wordpress.org/Template_Hierarchy
*
* @package understrap
*/

get_header();

$container   = get_theme_mod( 'understrap_container_type' );
$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );

?>
<?php if ( is_front_page() && is_home() ) : ?>
	<?php get_template_part( 'global-templates/hero', 'none' ); ?>
<?php endif; ?>


<div class="wrapper" id="wrapper-index">

	<div class="hero">
		<ul class="home-slider">
			<li class="slide1" style="background-image:url('/wp-content/uploads/2017/05/torre-de-l-aigua.jpg')"></li>
			<li class="slide2" style="background-image:url('/wp-content/uploads/2017/05/paisatge.jpg')"></li>
			<li class="slide3" style="background-image:url('/wp-content/uploads/2017/05/campanar.jpg')"></li>
			<li class="slide4" style="background-image:url('/wp-content/uploads/2017/05/gent.jpg')"></li>
		</ul>
		<div class="container">
			<a class="logo" href="/">L'Entesa per Sabadell</a>
		</div>
	</div>

	<?php require_once('navbar.php'); ?>

	<div class="<?php echo esc_html( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check and opens the primary div -->
			<?php get_template_part( 'global-templates/left-sidebar-check', 'none' ); ?>

			<main class="site-main" id="main">

				<div class="row"><div class="col-12"><h2 class="fancy"><span>Notícies</span></h2></div></div>

				<div class="row grid">
					<?php
					$args = array(
						'orderby'       => 'date',
						'order' => 'DESC',
						'posts_per_page' =>6,
						'category__not_in' => array(56,11,28)
					);
					$posts = get_posts( $args );
					?>

					<?php if ( have_posts() ) : ?>
						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php

							/*
							* Include the Post-Format-specific template for the content.
							* If you want to override this in a child theme, then include a file
							* called content-___.php (where ___ is the Post Format name) and that will be used instead.
							*/
							?>
							<div class=" newspiece-holder grid-item">
								<?php
								get_template_part( 'loop-templates/content', get_post_format() );
								?>
							</div>

						<?php endwhile; ?>

					<?php else : ?>

						<?php get_template_part( 'loop-templates/content', 'none' ); ?>

					<?php endif; ?>
				</div>

			</main><!-- #main -->

			<!-- The pagination component -->
			<!-- <?php understrap_pagination(); ?> -->

			<div class="text-center"><a class="btn btn-secondary understrap-read-more-link" href="//localhost:3000/2017/04/03/full-nomenclator/">Llegir més notícies</a></div>

		</div><!-- #primary -->

		<!-- Do the right sidebar check -->
		<?php if ( 'right' === $sidebar_pos || 'both' === $sidebar_pos ) : ?>
			<?php get_sidebar( 'right' ); ?>

		<?php endif; ?>

	</div><!-- .row -->

</div><!-- Container end -->

<div class="participa-belt-holder">
	<div class="fluid-container participa-belt" data-parallax="scroll" data-image-src="<?=get_stylesheet_directory_uri()?>/images/participa.png">
		<div class="container">
			<div class="row">
				<div class="col-md-6 push-md-3">
					<h2>Participa</h2>
					<p>Terris humanas frigore sectamque militis arce convexi. Sine crescendo ab. Ab permisit sic colebat ventos super. Mortales inclusum. Gentes ignea. Neu fontes finxit undae frigore zephyro occiduo. Recessit aere aetas mutastis suis fulgura illis. Dei plagae solum glomeravit mutastis habentia spisso nova formaeque!</p>
					<a class="btn btn-secondary understrap-read-more-link" href="mailto:info@entesa.org">Envian's un correu electrònic</a>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="container networks-section">
	<div class="row">
		<div class="col col-md-6 text-center">
			<h2 class="fancy"><span>YouTube</span></h2>
			<p>Terris humanas frigore sectamque militis arce convexi. Sine crescendo ab. Ab permisit sic colebat ventos super. Mortales inclusum. Gentes ignea. Neu fontes finxit undae frigore zephyro occiduo. Recessit aere aetas mutastis suis fulgura illis. Dei plagae solum glomeravit mutastis habentia spisso nova formaeque!</p>
			<iframe width="100%" height="255" src="http://www.youtube.com/embed?max-results=1&showinfo=0&rel=0&listType=user_uploads&list=entesapersabadell" frameborder="0" allowfullscreen></iframe>
			<a class="btn btn-secondary understrap-read-more-link" href="mailto:info@entesa.org">Visita el nostre canal de YouTube</a>
		</div>
		<div class="col col-md-6 text-center">
			<h2 class="fancy"><span>Foto Denúncia</span></h2>
			<p>Terris humanas frigore sectamque militis arce convexi. Sine crescendo ab. Ab permisit sic colebat ventos super. Mortales inclusum. Gentes ignea. Neu fontes finxit undae frigore zephyro occiduo. Recessit aere aetas mutastis suis fulgura illis. Dei plagae solum glomeravit mutastis habentia spisso nova formaeque!</p>
			<?php
			echo do_shortcode('[instagram-feed]');
			?>
			<a class="btn btn-secondary understrap-read-more-link" href="mailto:info@entesa.org">Visita el nostre instagram</a>
		</div>
	</div> <!-- row -->
</div> <!-- secondary container .fluid-container -->




</div><!-- Wrapper end -->

<?php get_footer(); ?>
