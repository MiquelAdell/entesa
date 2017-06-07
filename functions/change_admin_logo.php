<?php
function my_login_logo_one() {
?>
<style type="text/css">
body.login div#login h1 a {
    background-image: url(<?=get_stylesheet_directory_uri()?>/images/logo_entesa.svg);  //Add your own logo image in this url
}
</style>
<?php
} add_action( 'login_enqueue_scripts', 'my_login_logo_one' );
