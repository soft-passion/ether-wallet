<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
function ETHER_WALLET_options_page()
{
    // Require admin privs
    if ( !current_user_can( 'manage_options' ) ) {
        return false;
    }
    $new_options = array();
    // Which tab is selected?
    $possible_screens = array( 'default', 'floating' );
    $current_screen = ( isset( $_GET['action'] ) && in_array( $_GET['action'], $possible_screens ) ? $_GET['action'] : 'default' );
    
    if ( isset( $_POST['Submit'] ) ) {
        // Nonce verification
        check_admin_referer( 'ether-wallet-update-options' );
        // Standard options screen
        //        $new_options['wallet_address']        = ( ! empty( $_POST['ETHER_WALLET_wallet_address'] )       /*&& is_numeric( $_POST['ETHER_WALLET_wallet_address'] )*/ )       ? sanitize_text_field($_POST['ETHER_WALLET_wallet_address'])        : '';
        //        if ( ! empty( $_POST['ETHER_WALLET_wallet_private_key'] ) ) {
        //            $new_options['wallet_private_key'] = sanitize_text_field($_POST['ETHER_WALLET_wallet_private_key']);
        //        }
        $new_options['gas_limit'] = ( !empty($_POST['ETHER_WALLET_gas_limit']) && is_numeric( $_POST['ETHER_WALLET_gas_limit'] ) ? intval( sanitize_text_field( $_POST['ETHER_WALLET_gas_limit'] ) ) : 200000 );
        $new_options['gas_price'] = ( !empty($_POST['ETHER_WALLET_gas_price']) && is_numeric( $_POST['ETHER_WALLET_gas_price'] ) ? floatval( sanitize_text_field( $_POST['ETHER_WALLET_gas_price'] ) ) : 2 );
        $new_options['provider'] = ( !empty($_POST['ETHER_WALLET_provider']) ? sanitize_text_field( $_POST['ETHER_WALLET_provider'] ) : '' );
        $new_options['infuraApiKey'] = ( !empty($_POST['ETHER_WALLET_infuraApiKey']) ? sanitize_text_field( $_POST['ETHER_WALLET_infuraApiKey'] ) : '' );
        // Get all existing Ethereum Wallet options
        $existing_options = get_option( 'ether-wallet_options', array() );
        // Merge $new_options into $existing_options to retain Ethereum Wallet options from all other screens/tabs
        if ( $existing_options ) {
            $new_options = array_merge( $existing_options, $new_options );
        }
        
        if ( get_option( 'ether-wallet_options' ) ) {
            update_option( 'ether-wallet_options', $new_options );
        } else {
            $deprecated = '';
            $autoload = 'no';
            add_option(
                'ether-wallet_options',
                $new_options,
                $deprecated,
                $autoload
            );
        }
        
        ?>
		<div class="updated"><p><?php 
        _e( 'Settings saved.' );
        ?></p></div>
		<?php 
    } else {
        
        if ( isset( $_POST['Reset'] ) ) {
            // Nonce verification
            check_admin_referer( 'ether-wallet-update-options' );
            delete_option( 'ether-wallet_options' );
        }
    
    }
    
    $options = stripslashes_deep( get_option( 'ether-wallet_options', array() ) );
    ?>
	
	<div class="wrap">
	
	<h1><?php 
    _e( 'Ethereum Wallet Settings', 'ether-wallet' );
    ?></h1>
	
    
    <?php 
    settings_errors();
    ?>

    <section>
        <h1><?php 
    _e( 'Install and Configure Guide', 'ether-wallet' );
    ?></h1>
        <p><?php 
    echo  sprintf( __( 'Use the official %1$sInstall and Configure%2$s step by step guide to configure this plugin.', 'ether-wallet' ), '<a href="https://ethereumico.io/knowledge-base/install-ethereum-wallet-wordpress-plugin/" target="_blank">', '</a>' ) ;
    ?></p>
    </section>
	
    <h2 class="nav-tab-wrapper">
		<a href="<?php 
    echo  admin_url( 'options-general.php?page=ether-wallet' ) ;
    ?>" class="nav-tab<?php 
    if ( 'default' == $current_screen ) {
        echo  ' nav-tab-active' ;
    }
    ?>"><?php 
    esc_html_e( 'Standard' );
    ?></a>
	</h2>

	<form id="ether-wallet_admin_form" method="post" action="">
	
	<?php 
    wp_nonce_field( 'ether-wallet-update-options' );
    ?>

		<table class="form-table">
		
		<?php 
    
    if ( 'default' == $current_screen ) {
        ?>			
			<tr valign="top">
                <th scope="row"><h2><?php 
        _e( "Blockchain Settings", 'ether-wallet' );
        ?></h2></th>
			<td></td>
			</tr>
			
			<tr valign="top">
			<th scope="row"><?php 
        _e( "Provider", 'ether-wallet' );
        ?></th>
			<td><fieldset>
				<label>
                    <input class="text" name="ETHER_WALLET_provider" type="text" maxlength="1024" value="<?php 
        echo  ( !empty($options['provider']) ? esc_attr( $options['provider'] ) : '' ) ;
        ?>">
                    <p><?php 
        _e( "The blockchain used: mainnet or ropsten. Use mainnet in production, and ropsten in test mode. See plugin documentation for the testing guide.", 'ether-wallet' );
        ?></p>
                </label>
			</fieldset></td>
			</tr>

			<tr valign="top">
                <th scope="row"><?php 
        _e( "Infura.io API Key", 'ether-wallet' );
        ?><sup>*</sup></th>
			<td><fieldset>
				<label>
                    <input class="text" name="ETHER_WALLET_infuraApiKey" type="text" maxlength="70" placeholder="<?php 
        _e( "Put your Infura.io API Key here", 'ether-wallet' );
        ?>" value="<?php 
        echo  ( !empty($options['infuraApiKey']) ? esc_attr( $options['infuraApiKey'] ) : '' ) ;
        ?>">
                    <p><?php 
        echo  sprintf(
            __( 'The API key for the %1$s. You need to register on this site to obtain it. Follow the %2$sGet infura API Key%3$s guide please.', 'ether-wallet' ),
            '<a target="_blank" href="https://infura.io/register">https://infura.io/</a>',
            '<a target="_blank" href="https://ethereumico.io/knowledge-base/infura-api-key-guide/">',
            '</a>'
        ) ;
        ?></p>
                </label>
			</fieldset></td>
			</tr>
			
			<tr valign="top">
			<th scope="row"><?php 
        _e( "Gas Limit", 'ether-wallet' );
        ?></th>
			<td><fieldset>
				<label>
                    <input class="text" name="ETHER_WALLET_gas_limit" type="number" min="0" step="10000" maxlength="8" placeholder="200000" value="<?php 
        echo  ( !empty($options['gas_limit']) ? esc_attr( $options['gas_limit'] ) : '200000' ) ;
        ?>">
                    <p><?php 
        _e( "The default gas limit to to spend on your transactions. 200000 is a reasonable default value.", 'ether-wallet' );
        ?></p>
                </label>
			</fieldset></td>
			</tr>
			
			<tr valign="top">
			<th scope="row"><?php 
        _e( "Gas price", 'ether-wallet' );
        ?></th>
			<td><fieldset>
				<label>
                    <input class="text" name="ETHER_WALLET_gas_price" type="number" min="0" step="1" maxlength="8" placeholder="2" value="<?php 
        echo  ( !empty($options['gas_price']) ? esc_attr( $options['gas_price'] ) : '2' ) ;
        ?>">
                    <p><?php 
        _e( "The gas price in Gwei. Reasonable values are in a 2-40 ratio. The default value is 2 that is cheap but not very fast. Increase if you want transactions to be mined faster, decrease if you want pay less fee per transaction.", 'ether-wallet' );
        ?></p>
                </label>
			</fieldset></td>
			</tr>
       
		<?php 
    }
    
    ?>
		
		</table>
        <p class="submit">
			<input class="button-primary" type="submit" name="Submit" value="<?php 
    _e( 'Save Changes', 'ether-wallet' );
    ?>" />
			<input id="ETHER_WALLET_reset_options" type="submit" name="Reset" onclick="return confirm('<?php 
    _e( 'Are you sure you want to delete all Ether Wallet options?', 'ether-wallet' );
    ?>')" value="<?php 
    _e( 'Reset', 'ether-wallet' );
    ?>" />
		</p>
	
	</form>

    </div>

<?php 
}
