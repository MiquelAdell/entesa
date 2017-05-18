<!-- ******************* The Navbar Area ******************* -->
<div class="wrapper-fluid wrapper-navbar" id="wrapper-navbar">

    <a class="skip-link screen-reader-text sr-only" href="#content"><?php esc_html_e( 'Skip to content','understrap' ); ?></a>
    <div class="container">
        <div class="row fixed-row">
            <div class="col-2 col-lg-2 hide-if-not-fixed">
                <!-- Your site title as branding in the menu -->
                <?php if ( ! has_custom_logo() ) { ?>
                    <h1 class="navbar-brand mb-0"><a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
                <?php } else {
                    the_custom_logo();
                } ?><!-- end custom logo -->
            </div>

            <div class="col-5 col-lg-5 push-8 push-lg-0 col-lg-7-not-fixed">
                <nav class="navbar navbar-toggleable-md  navbar-inverse bg-inverse primary">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- The WordPress Menu goes here -->
                    <?php wp_nav_menu(
                        array(
                            'theme_location'  => 'primary',
                            'container_class' => 'collapse navbar-collapse',
                            'container_id'    => 'navbarNavDropdown',
                            'menu_class'      => 'navbar-nav',
                            'fallback_cb'     => '',
                            'menu_id'         => 'main-menu',
                            'walker'          => new WP_Bootstrap_Navwalker(),
                        )
                    ); ?>
                    <?php if ( !function_exists('last_navigation_element') || !last_navigation_element("Last Navigation Element") ) : ?><?php endif;?>
                </nav><!-- .site-navigation -->
            </div>
            <div class="col-5 col-lg-5 pull-4 pull-lg-0">
                <nav class="navbar navbar-toggleable-md  navbar-inverse bg-inverse secondary">
                    <!-- <?php wp_nav_menu( array( 'theme_location' => 'logos-menu' ) ); ?> -->
                    <?php wp_nav_menu(
                        array(
                            'theme_location'  => 'logos-menu',
                            'menu_class'      => 'navbar-nav',
                            'menu_id'         => 'logos-menu',
                        )
                    ); ?>
                </nav>
            </div>
        </div>
    </div>
</div><!-- .wrapper-navbar end -->
