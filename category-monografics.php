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
$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );
?>

<div class="wrapper" id="archive-wrapper">

	<div class="<?php echo esc_html( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check', 'none' ); ?>

			<main class="site-main" id="main">

				<?php if ( have_posts() ) : ?>

					<header class="page-header">
						<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
						?>
					</header><!-- .page-header -->

					<?php /* Start the Loop */ ?>
					<div class="grid">
						<?php
							if (is_category()) {
								$this_category = get_category($cat);
							}
							if($this_category->category_parent){
								$categories = get_categories('orderby=id&show_count=0&title_li=&use_desc_for_title=1&child_of='.$this_category->category_parent."&echo=0");
							} else {
								$categories = get_categories('orderby=id&depth=1&show_count=0&title_li=&use_desc_for_title=1&child_of='.$this_category->cat_ID."&echo=0");
							}
							if($categories){
								foreach($categories as $category) {
									?>
									<div class=" newspiece-holder grid-item">
										<article class="post type-post status-publish format-standard hentry" >
											<header class="entry-header">
												<h2 class="entry-title"><a href="<?=get_term_link($category)?>" rel="bookmark"><?=$category->name?></a></h2>
											</header><!-- .entry-header -->
											<div class="entry-content">
												<?=$category->category_description?>
												<p><a class="btn btn-secondary understrap-read-more-link" href="<?=get_term_link($category)?>">Llegir més&#8230;</a></p>
											</div><!-- .entry-content -->
										</article><!-- #post-## -->
									</div>
									<?php
								}
							}
						?>
					</div>
				<?php else : ?>

					<?php get_template_part( 'loop-templates/content', 'none' ); ?>

				<?php endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<!-- Do the right sidebar check -->
		<?php if ( 'right' === $sidebar_pos || 'both' === $sidebar_pos ) : ?>

			<?php get_sidebar( 'right' ); ?>

		<?php endif; ?>

	</div> <!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
