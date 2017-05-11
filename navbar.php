<!-- ******************* The Navbar Area ******************* -->
<div class="wrapper-fluid wrapper-navbar" id="wrapper-navbar">

    <a class="skip-link screen-reader-text sr-only" href="#content"><?php esc_html_e( 'Skip to content',
    'understrap' ); ?></a>

    <nav class="navbar navbar-toggleable-md  navbar-inverse bg-inverse">

    <?php if ( 'container' == $container ) : ?>
        <div class="container">
    <?php endif; ?>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

                <!-- Your site title as branding in the menu -->
                <?php if ( ! has_custom_logo() ) { ?>

                    <?php if ( is_front_page() && is_home() ) : ?>

                        <h1 class="navbar-brand mb-0"><a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>

                    <?php else : ?>

                        <a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a>

                    <?php endif; ?>


                <?php } else {
                    the_custom_logo();
                } ?><!-- end custom logo -->

            <div id="navbarNavDropdown" class="collapse navbar-collapse">
                <!-- The WordPress Menu goes here -->
                <?php wp_nav_menu(
                    array(
                        'theme_location'  => 'primary',
                        'menu_class'      => 'navbar-nav',
                        'fallback_cb'     => '',
                        'menu_id'         => 'main-menu',
                        'walker'          => new WP_Bootstrap_Navwalker(),
                    )
                ); ?>
                <?php if ( !function_exists('last_navigation_element') || !last_navigation_element("Last Navigation Element") ) : ?><?php endif;?>

                <!-- logo menu -->
                <?php wp_nav_menu( array( 'theme_location' => 'logos-menu' ) ); ?>
            </div>

        <?php if ( 'container' == $container ) : ?>
        </div><!-- .container -->
        <?php endif; ?>


    </nav><!-- .site-navigation -->

</div><!-- .wrapper-navbar end -->
