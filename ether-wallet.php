<?php

/*
Plugin Name: Ether Wallet
Plugin URI: https://wordpress.org/plugins/ether-wallet/
Description: Wallet for Ether and ERC20 tokens for WordPress
Version: 1.0
Author: unkown
Text Domain: ether-wallet
Domain Path: /languages
*/

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly
}

global 
    $ETHER_WALLET_plugin_basename,
    $ETHER_WALLET_options,
    $ETHER_WALLET_plugin_dir,
    $ETHER_WALLET_plugin_url_path,
    $ETHER_WALLET_services,
    $ETHER_WALLET_amp_icons_css
;
if ( !function_exists( 'ETHER_WALLET_deactivate' ) ) {
    function ETHER_WALLET_deactivate()
    {
        if ( !current_user_can( 'activate_plugins' ) ) {
            return;
        }
        deactivate_plugins( plugin_basename( __FILE__ ) );
    }

}
                            
// ... Your plugin's main file logic ...
$ETHER_WALLET_plugin_basename = plugin_basename( dirname( __FILE__ ) );
$ETHER_WALLET_plugin_dir = untrailingslashit( plugin_dir_path( __FILE__ ) );
$ETHER_WALLET_plugin_url_path = untrailingslashit( plugin_dir_url( __FILE__ ) );
// HTTPS?
$ETHER_WALLET_plugin_url_path = ( is_ssl() ? str_replace( 'http:', 'https:', $ETHER_WALLET_plugin_url_path ) : $ETHER_WALLET_plugin_url_path );
// Set plugin options
$ETHER_WALLET_options = get_option( 'ether-wallet_options', array() );
function ETHER_WALLET_init()
{
    global  $ETHER_WALLET_plugin_dir, $ETHER_WALLET_plugin_basename, $ETHER_WALLET_options ;
    // Load the textdomain for translations
    load_plugin_textdomain( 'ether-wallet', false, $ETHER_WALLET_plugin_basename . '/languages/' );
}

add_filter( 'init', 'ETHER_WALLET_init' );
           
function ETHER_WALLET_form_shortcode( $attributes )
{
    //    global $ETHER_WALLET_options;
    //	$options = stripslashes_deep( $ETHER_WALLET_options );
    
    $js = '';
    $ret = "
  <h6>New Wallet</h6>
  <div><input id='userEntropy' placeholder='Type random text to generate entropy' size='80' type='text' />
    <button onclick='newWallet()'>Create New Wallet</button>
  </div>
  <h6>Restore Wallet</h6>
  <div><input id='seed' size='80' type='text' value='' />
    <button onclick='setSeed()'>Restore wallet from Seed</button>
  </div>
  <h6>Show Addresses</h6>
  <div>Show <input id='numAddr' size=v5' type='text' value='3' /> more address(es)
    <button onclick='newAddresses(\'\')'>Show</button>
  </div>
  <div id='addr'></div>
  <div>
    <button onClick='getBalances()'>Refresh</button>
  </div>
  <h6>Send Ether</h6>
  <div>From: <select id='sendFrom'></select></div>
  <div>To: <input id='sendTo' size='40' type='text' /></div>
  <div>Ether: <input id='sendValueAmount' type='text'></div>
  <div>
    <button onclick='sendEth()'>Send Ether</button>
  </div>
  <h6>Show Seed</h6>
  <button onclick='showSeed()'>Show Seed</button>
  <h6>Function Call</h6>
  <div>Caller: <select id='functionCaller'></select></div>
  <div>Contract Address: <input id='contractAddr' size='40' type='text' /></div>
  <div>Contract ABI: <input id='contractAbi' size='40' type='text' /></div>
  <div>Function Name: <input id='functionName' size='20' type='text' /></div>
  <div>Function Arguments: <input id='functionArgs' size='40' type='text' /></div>
  <div>Value (Ether): <input id='sendValueAmount' type='text'></div>
  <div>
    <button onclick='functionCall()'>Call Function</button>
  </div>";
    ETHER_WALLET_enqueue_scripts_();
    wp_enqueue_script( 'jsQR' );
    return $js . str_replace( "\n", " ", str_replace( "\r", " ", str_replace( "\t", " ", $js . $ret ) ) );
}
                    
add_shortcode( 'ether-wallet-form', 'ETHER_WALLET_form_shortcode' );
                    
function ETHER_WALLET_enqueue_scripts_()
{
    wp_enqueue_style( 'ether-wallet' );
    wp_enqueue_script( 'ether-wallet' );
    wp_enqueue_script( 'functions' );
}

function ETHER_WALLET_stylesheet()
{
    global  $ETHER_WALLET_plugin_url_path ;
    $deps = array(
        'font-awesome',
        'bootstrap-ether-wallet',
        'bootstrap-affix-ether-wallet',
        'data-tables'
    );
    $min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
    
    if ( !wp_style_is( 'font-awesome', 'queue' ) && !wp_style_is( 'font-awesome', 'done' ) ) {
        wp_dequeue_style( 'font-awesome' );
        wp_deregister_style( 'font-awesome' );
        wp_register_style(
            'font-awesome',
            $ETHER_WALLET_plugin_url_path . "/css/font-awesome{$min}.css",
            array(),
            '4.7.0'
        );
    }
    
    
    if ( !wp_style_is( 'bootstrap-ether-wallet', 'queue' ) && !wp_style_is( 'bootstrap-ether-wallet', 'done' ) ) {
        wp_dequeue_style( 'bootstrap-ether-wallet' );
        wp_deregister_style( 'bootstrap-ether-wallet' );
        wp_register_style(
            'bootstrap-ether-wallet',
            $ETHER_WALLET_plugin_url_path . "/css/bootstrap-ns{$min}.css",
            array(),
            '4.0.0'
        );
    }
    
    
    if ( !wp_style_is( 'bootstrap-affix-ether-wallet', 'queue' ) && !wp_style_is( 'bootstrap-affix-ether-wallet', 'done' ) ) {
        wp_dequeue_style( 'bootstrap-affix-ether-wallet' );
        wp_deregister_style( 'bootstrap-affix-ether-wallet' );
        wp_register_style(
            'bootstrap-affix-ether-wallet',
            $ETHER_WALLET_plugin_url_path . "/css/affix.css",
            array(),
            '3.3.7'
        );
    }
    
    
    if ( !wp_style_is( 'data-tables', 'queue' ) && !wp_style_is( 'data-tables', 'done' ) ) {
        wp_dequeue_style( 'data-tables' );
        wp_deregister_style( 'data-tables' );
        wp_register_style(
            'data-tables',
            $ETHER_WALLET_plugin_url_path . "/css/jquery.dataTables{$min}.css",
            array(),
            '1.10.19'
        );
    }
    
    
    if ( !wp_style_is( 'ether-wallet', 'queue' ) && !wp_style_is( 'ether-wallet', 'done' ) ) {
        wp_dequeue_style( 'ether-wallet' );
        wp_deregister_style( 'ether-wallet' );
        wp_register_style(
            'ether-wallet',
            $ETHER_WALLET_plugin_url_path . '/ether-wallet.css',
            $deps,
            '2.8.0'
        );
    }

}

add_action( 'wp_enqueue_scripts', 'ETHER_WALLET_stylesheet', 20 );
                   
function ETHER_WALLET_enqueue_script()
{
    global  $ETHER_WALLET_plugin_url_path, $ETHER_WALLET_options ;
    $min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
    
    if ( !wp_script_is( 'web3', 'queue' ) && !wp_script_is( 'web3', 'done' ) ) {
        wp_dequeue_script( 'web3' );
        wp_deregister_script( 'web3' );
        wp_register_script(
            'web3',
            $ETHER_WALLET_plugin_url_path . "/js/web3.min.js",
            array( 'jquery' ),
            '0.20.6'
        );
    }
    
    
    if ( !wp_script_is( 'data-tables', 'queue' ) && !wp_script_is( 'data-tables', 'done' ) ) {
        wp_dequeue_script( 'data-tables' );
        wp_deregister_script( 'data-tables' );
        wp_register_script(
            'data-tables',
            $ETHER_WALLET_plugin_url_path . "/js/jquery.dataTables.min.js",
            array( 'jquery' ),
            '1.10.19'
        );
    }
    
    
    if ( !wp_script_is( 'popper', 'queue' ) && !wp_script_is( 'popper', 'done' ) ) {
        wp_dequeue_script( 'popper' );
        wp_deregister_script( 'popper' );
        wp_register_script(
            'popper',
            $ETHER_WALLET_plugin_url_path . "/js/popper.min.js",
            array( 'jquery' ),
            '1.14.6'
        );
    }
    
    
    if ( !wp_script_is( 'ether-wallet-bootstrap', 'queue' ) && !wp_script_is( 'ether-wallet-bootstrap', 'done' ) ) {
        wp_dequeue_script( 'ether-wallet-bootstrap' );
        wp_deregister_script( 'ether-wallet-bootstrap' );
        wp_register_script(
            'ether-wallet-bootstrap',
            $ETHER_WALLET_plugin_url_path . "/js/bootstrap.min.js",
            array( 'jquery', 'popper' ),
            '4.0.0'
        );
    }
    
    
    if ( !wp_script_is( 'ether-wallet-bootstrap-affix', 'queue' ) && !wp_script_is( 'ether-wallet-bootstrap-affix', 'done' ) ) {
        wp_dequeue_script( 'ether-wallet-bootstrap-affix' );
        wp_deregister_script( 'ether-wallet-bootstrap-affix' );
        wp_register_script(
            'ether-wallet-bootstrap-affix',
            $ETHER_WALLET_plugin_url_path . "/js/affix.js",
            array( 'ether-wallet-bootstrap' ),
            '3.3.7'
        );
    }
    
    
    if ( !wp_script_is( 'qrcode', 'queue' ) && !wp_script_is( 'qrcode', 'done' ) ) {
        wp_dequeue_script( 'qrcode' );
        wp_deregister_script( 'qrcode' );
        wp_register_script(
            'qrcode',
            //            $ETHER_WALLET_plugin_url_path . "/js/qrcode{$min}.js", array('ether-wallet-bootstrap-affix'), '2009'
            $ETHER_WALLET_plugin_url_path . "/js/qrcode.min.js",
            array( 'ether-wallet-bootstrap-affix' ),
            '2009'
        );
    }
    
    
    if ( !wp_script_is( 'jquery.qrcode', 'queue' ) && !wp_script_is( 'jquery.qrcode', 'done' ) ) {
        wp_dequeue_script( 'jquery.qrcode' );
        wp_deregister_script( 'jquery.qrcode' );
        wp_register_script(
            'jquery.qrcode',
            //            $ETHER_WALLET_plugin_url_path . "/js/jquery.qrcode{$min}.js", array('jquery', 'qrcode'), '1.0'
            $ETHER_WALLET_plugin_url_path . "/js/jquery.qrcode.min.js",
            array( 'jquery', 'qrcode' ),
            '1.0'
        );
    }
    
    // https://github.com/cozmo/jsQR
    
    if ( !wp_script_is( 'jsQR', 'queue' ) && !wp_script_is( 'jsQR', 'done' ) ) {
        wp_dequeue_script( 'jsQR' );
        wp_deregister_script( 'jsQR' );
        wp_register_script(
            'jsQR',
            $ETHER_WALLET_plugin_url_path . "/js/jsQR.min.js",
            array( 'ether-wallet-bootstrap-affix' ),
            '807b07357a35a2d16d8006bcc5426ce558d6b904'
        );
    }
    
    
    if ( !wp_script_is( 'clipboard', 'queue' ) && !wp_script_is( 'clipboard', 'done' ) ) {
        wp_dequeue_script( 'clipboard' );
        wp_deregister_script( 'clipboard' );
        wp_register_script(
            'clipboard',
            $ETHER_WALLET_plugin_url_path . "/js/clipboard.min.js",
            array(),
            '2.0.4'
        );
    }
    
    
    if ( !wp_script_is( 'ether-wallet', 'queue' ) && !wp_script_is( 'ether-wallet', 'done' ) ) {
        wp_dequeue_script( 'ether-wallet' );
        wp_deregister_script( 'ether-wallet' );
        wp_register_script(
            'ether-wallet',
            $ETHER_WALLET_plugin_url_path . "/lightwallet.js",
            array( 'jquery', 'web3')
        );
    }

    if ( !wp_script_is( 'functions', 'queue' ) && !wp_script_is( 'functions', 'done' ) ) {
        wp_dequeue_script( 'functions' );
        wp_deregister_script( 'functions' );
        wp_register_script(
            'functions',
            $ETHER_WALLET_plugin_url_path . "/functions.js",
            array( 'jquery', 'web3' )
        );
    }
  
}
/*
wp_localize_script( 'ether-wallet', 'etherWallet', [
        'user_wallet_address'              => esc_html( $accountAddress ),
        'user_wallet_last_txhash'          => esc_html( $lastTxHash ),
        'user_wallet_last_txtime'          => esc_html( $lastTxTime ),
        'user_wallet_last_tx_to'           => esc_html( $lastTxTo ),
        'user_wallet_last_tx_value'        => esc_html( $lastTxValue ),
        'user_wallet_last_tx_currency'     => esc_html( $lastTxCurrency ),
        'tokens'                           => esc_html( $tokens_json ),
        'site_url'                         => esc_html( site_url() ),
        'web3Endpoint'                     => esc_html( ETHER_WALLET_getWeb3Endpoint() ),
        'etherscanApiKey'                  => $etherscanApiKey,
        'blockchain_network'               => esc_html( $blockchain_network ),
        'gasLimit'                         => esc_html( $gaslimit ),
        'gasPrice'                         => esc_html( $gasprice ),
        'localePath'                       => esc_html( $ETHER_WALLET_plugin_url_path . "/i18n/" . get_locale() . ".json" ),
        'str_copied_msg'                   => __( 'Copied to clipboard', 'ether-wallet' ),
        'str_insufficient_eth_balance_msg' => __( 'Insufficient Ether balance for tx fee payment.', 'ether-wallet' ),
        'str_unknown_token_symbol_msg'     => __( 'Unknown', 'ether-wallet' ),
        'str_tx_pending_msg'               => __( 'Pending', 'ether-wallet' ),
        'str_prev_tx_pending_msg'          => __( 'Previous transaction is still not confirmed or failed', 'ether-wallet' ),
        'str_date_recently_msg'            => __( 'recently', 'ether-wallet' ),
        'str_date_days_fmt_msg'            => __( '%1$s days', 'ether-wallet' ),
        'str_date_hours_fmt_msg'           => __( '%1$s hours', 'ether-wallet' ),
        'str_date_minutes_fmt_msg'         => __( '%1$s minutes', 'ether-wallet' ),
    ] );
*/                    
add_action( 'wp_enqueue_scripts', 'ETHER_WALLET_enqueue_script' );
/**
 * Admin Options
 */
if ( is_admin() ) {
    include_once $ETHER_WALLET_plugin_dir . '/ether-wallet.admin.php';
}
function ETHER_WALLET_add_menu_link()
{
    $page = add_options_page(
        __( 'Ethereum Wallet Settings', 'ether-wallet' ),
        __( 'Ethereum Wallet', 'ether-wallet' ),
        'manage_options',
        'ether-wallet',
        'ETHER_WALLET_options_page'
    );
}

add_filter( 'admin_menu', 'ETHER_WALLET_add_menu_link' );
// Place in Option List on Settings > Plugins page
function ETHER_WALLET_actlinks( $links, $file )
{
    // Static so we don't call plugin_basename on every plugin row.
    static  $this_plugin ;
    if ( !$this_plugin ) {
        $this_plugin = plugin_basename( __FILE__ );
    }
    
    if ( $file == $this_plugin ) {
        $settings_link = '<a href="options-general.php?page=ether-wallet">' . __( 'Settings' ) . '</a>';
        array_unshift( $links, $settings_link );
        // before other links
    }
    
    return $links;
}

add_filter(
    'plugin_action_links',
    'ETHER_WALLET_actlinks',
    10,
    2
);
       
                    
// @see https://www.tipsandtricks-hq.com/adding-a-custom-column-to-the-users-table-in-wordpress-7378
add_action( 'manage_users_columns', 'ETHER_WALLET_modify_user_columns' );
function ETHER_WALLET_modify_user_columns( $column_headers )
{
    $column_headers['ether_wallet'] = __( 'Ethereum wallet', 'ether-wallet' );
    return $column_headers;
}
                    
add_action( 'admin_head', 'ETHER_WALLET_custom_admin_css' );
function ETHER_WALLET_custom_admin_css()
{
    echo  '<style>
.column-ethereum_wallet {width: 22%}
</style>' ;
}
                    
add_action(
    'manage_users_custom_column',
    'ETHER_WALLET_user_posts_count_column_content',
    10,
    3
);

function ETHER_WALLET_user_posts_count_column_content( $value, $column_name, $user_id )
{
    
    if ( 'ether_wallet' == $column_name ) {
        $address = ETHER_WALLET_get_wallet_address( $user_id );
        $addressPath = ETHER_WALLET_get_address_path( $address );
        $value = sprintf( '<a href="%1$s" target="_blank" rel="nofollow">%2$s</a>', $addressPath, $address );
    }
    
    return $value;
}
