<?php
function fotodenuncia_feed_func(){
    global $post;
    $args = array(
       'posts_per_page'   => 2,
       'orderby'          => 'date',
       'order'            => 'DESC',
       'post_type'        => 'fotodenuncia'
    );
    $posts_array = get_posts( $args );
    ob_start();
    ?>
    <div class="fotodenuncia-archive-wrapper shortcode">
        <div class="mosaic">
            <?php
            foreach($posts_array as $post){
                setup_postdata($post);
                include(get_stylesheet_directory().'/templates/_fotodenuncia-content.php');
            }
            ?>
        </div>
    </div>
    <?php
    wp_reset_postdata();
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
}
add_shortcode('fotodenuncia_feed', 'fotodenuncia_feed_func');
