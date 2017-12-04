<?php
/**
* Front page template
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
			<?php
			$images = get_field('imatges_de_portada');

			if( $images ) {
				shuffle($images);
				$image = array_shift($images);
				$i = 1;
				?>
				<li class="slide<?=$i?> on loaded <?=$image['title']?>" style="background-image:url('<?=$image['url']?>')"></li>
				<?php
				foreach($images as $image){
					$i++;
					?>
					<li class="slide<?=$i?> off <?=$image['title']?>" data-image="<?=$image['url']?>"></li>
					<?php
				}
			}
			?>
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
					$args = array('child_of' => 2);
					$news_category_ids = array();
					$categories = get_categories( $args );
					foreach($categories as $category) {
						if(
							$category->term_id != 28 //agenda
							&& $category->term_id != 56 //butlletí
						) {
							$news_category_ids[] = $category->term_id;
						}
					}
// echo "<pre>"; var_dump($news_category_ids); die();
					$args = array(
						'orderby' => 'date',
						'order' => 'DESC',
						'posts_per_page' =>6,
						'category__in' => $news_category_ids
					);
					$posts = get_posts( $args );
					foreach($posts as $post){
						setup_postdata($post);
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

						<?php
					}
					?>
				</div>

			</main><!-- #main -->

			<!-- The pagination component -->
			<!-- <?php understrap_pagination(); ?> -->

			<div class="text-center"><a class="btn btn-secondary understrap-read-more-link" href="<?=get_site_url()?>/categoria/actualitat/page/2/">Llegir més notícies</a></div>

		</div><!-- #primary -->

		<!-- Do the right sidebar check -->
		<?php if ( 'right' === $sidebar_pos || 'both' === $sidebar_pos ) : ?>
			<?php get_sidebar( 'right' ); ?>

		<?php endif; ?>

	</div><!-- .row -->

</div><!-- Container end -->

<div class="participa-belt-holder">
	<div class="fluid-container participa-belt" data-parallax="scroll" data-image-src="<?=get_stylesheet_directory_uri()?>/images/participa.jpg">
		<div class="container">
			<div class="row">
				<div class="col-md-6 push-md-3">
					<?=get_field('text_participa',get_option( 'page_on_front' ))?>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="container networks-section">
	<div class="row">
		<div class="col col-md-6 text-center">
			<h2 class="fancy"><span>YouTube</span></h2>
			<?=get_field('text_social_1',get_option( 'page_on_front' ))?>
		</div>
		<div class="col col-md-6 text-center">
			<h2 class="fancy"><span>Fotodenúncia</span></h2>
			<?=get_field('text_social_2',get_option( 'page_on_front' ))?>
		</div>
	</div> <!-- row -->
</div> <!-- secondary container .fluid-container -->




</div><!-- Wrapper end -->

<?php get_footer(); ?>
