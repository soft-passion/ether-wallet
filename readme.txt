=== Ethereum Wallet ===
Contributors: ethereumicoio, freemius
Tags: ethereum, erc20, token, crypto, cryptocurrency, wallet
Requires at least: 3.7
Tested up to: 5.6.2
Stable tag: 2.8.0
Donate link: https://etherscan.io/address/0x476Bb28Bc6D0e9De04dB5E19912C392F9a76535d
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires PHP: 7.0

The user friendly Ethereum Wallet for your WordPress site.

== Description ==

The Ethereum Wallet WordPress plugin auto-creates a user wallet upon registration and allows user to send Ether or ERC20 tokens from it.

> It is a valuable addition for the [Cryptocurrency Product for WooCommerce](https://ethereumico.io/product/cryptocurrency-wordpress-plugin/ "Cryptocurrency Product for WooCommerce") plugin.

Using these two plugins your non-techie customers can register to obtain an Ethereum account address and then buy your tokens to be sent to this new address.

== FREE Features ==

* To show user's Ethereum account address insert the `[ethereum-wallet-account]` shortcode wherever you like. You can use `label="My label"` attribute to set your own label text. And `nolabel="yes"` attribute to display no label at all.
* To show user's Ethereum account address's Ether balance insert the `[ethereum-wallet-balance]` shortcode wherever you like. Add the `displayfiat="1"` attribute to display the calculated fiat balance too.
* Use `tokendecimals` attribute to configure the desired digits after the decimal separator count for the `[ethereum-wallet-balance]` shortcode.
* Use `tokendecimalchar` attribute to configure the desired decimal separator character for the `[ethereum-wallet-balance]` shortcode.
* Dynamic ETH token price feature of the [Cryptocurrency Product for WooCommerce](https://ethereumico.io/product/cryptocurrency-wordpress-plugin/ "Cryptocurrency Product for WooCommerce") plugin is supported.
* To show the send Ether form insert the `[ethereum-wallet-sendform]` shortcode wherever you like.
* To show an account's transactions history insert the `[ethereum-wallet-history direction="in"]` shortcode wherever you like. The `direction` attribute can have values `in` to show only input transactions, `out` to show only output transactions, or `inout` to show both input and output transactions. If attribute is omitted, the `inout` is used by default.
* Pagination and filtering is available for the tx history table
* Use the `user_ethereum_wallet_address` user_meta key to display the user's account address, or for the `Ethereum Wallet meta key` setting of the [Cryptocurrency Product for WooCommerce](https://ethereumico.io/product/cryptocurrency-wordpress-plugin/ "Cryptocurrency Product for WooCommerce") plugin
* The `user_ethereum_wallet_last_tx_hash` user meta key can be used to access the user's most recent transaction
* The Ethereum Gas price is auto adjusted according to the [etherchain.org](https://www.etherchain.org) API
* Balances and tx tables of the wallet-receiver are auto-refreshed by listening to the blockchain
* Integration with the [Ether and ERC20 tokens WooCommerce Payment Gateway](https://wordpress.org/plugins/ether-and-erc20-tokens-woocommerce-payment-gateway/) plugin is provided
* New account creation form shortcode: `[ethereum-wallet-account-management-create]`
* Accounts list, select default shortcode: `[ethereum-wallet-account-management-select]`
* Private key import shortcode: `[ethereum-wallet-account-management-import]`
* Private key export shortcode: `[ethereum-wallet-account-management-export]`
* QR-code is displayed for account and private key export shortcodes
* QR Scanner for `TO` section of `SEND FORM`
* `Ethereum wallet` column with linked user's account addresses is displayed on the `Users` WordPress admin page (`/wp-admin/users.php`)
* This plugin is l10n ready

== PRO Features ==

> Full ERC20 tokens support!

* Admin markup feature to earn Ether fee from your site's Ethereum Wallet users
* To show user's Ethereum account address's TSX ERC20 token balance insert the `[ethereum-wallet-balance tokenname="TSX" tokenaddress="0x6Fe928d427b0E339DB6FF1c7a852dc31b651bD3a"]` shortcode wherever you like.
* The [Cryptocurrency Product for WooCommerce](https://ethereumico.io/product/cryptocurrency-wordpress-plugin/ "Cryptocurrency Product for WooCommerce") plugin integration for the `[ethereum-wallet-balance]` shortcode is available. Add the `tokenwooproduct` attribute with a product id of the corresponding WooCommerce Token product as a value to display the balance in a fiat currency as well. The token to fiat currency rate would be calculated from the WooCommerce product price. Example: `[ethereum-wallet-balance tokenname="TSX" tokenaddress="0x6Fe928d427b0E339DB6FF1c7a852dc31b651bD3a" tokenwooproduct="123"]`. Result: `12.345 TSX $12.34`.
* The `tokeniconpath` attribute added to the `[ethereum-wallet-balance]` shortcode turns it to a more sophisticated widget with token icon. For token: `[ethereum-wallet-balance tokensymbol="TSX" tokenname="Test Coin" tokenaddress="0x6Fe928d427b0E339DB6FF1c7a852dc31b651bD3a" tokenwooproduct="123" tokeniconpath="https://example.com/icons/BTC.png"]`. For Ether: `[ethereum-wallet-balance displayfiat="1" tokeniconpath="https://example.com/icons/BTC.png"]`.
* Dynamic ERC20 token price feature of the [Cryptocurrency Product for WooCommerce](https://ethereumico.io/product/cryptocurrency-wordpress-plugin/ "Cryptocurrency Product for WooCommerce") plugin is supported.
* The `[ethereum-wallet-accounts-table]` shortcode can be used to display a table of all accounts with fiat balances. Avatars and logins are also shown for the admin user. Integration with [BuddyPress](https://buddypress.org/) is provided for avatars display.
* To show the send ERC20 token form insert the `[ethereum-wallet-sendform]` shortcode wherever you like.
* Multi-vendor support for the [Cryptocurrency Product for WooCommerce](https://ethereumico.io/product/cryptocurrency-wordpress-plugin/ "Cryptocurrency Product for WooCommerce") plugin
* `ethereum-wallet-dividends` shortcode can be used to display dividends payment history. See the `ERC20 Dividend Payments Add-On` of the [Cryptocurrency Product for WooCommerce](https://ethereumico.io/product/cryptocurrency-wordpress-plugin/ "Cryptocurrency Product for WooCommerce") plugin for details
* `tokenaddress` attribute for the `ethereum-wallet-accounts-table` forces this table to display token balances instead of the Ether
* `mintokenamount` attribute for the `ethereum-wallet-accounts-table` shortcode forces this table to display users with token balances greater or equal to the `mintokenamount` value set
* `Tools` / `Ethereum Wallet` submenu can be used to manually recalculate user account balances
* [ERC1404](https://erc1404.org/) support. If transfer is not allowed, corresponding error message would be displayed.
* `tokenslist` attribute for the `ethereum-wallet-sendform` shortcode can contain a single allowed token address or a comma separated list of allowed token addresses.
* [ERC2212](https://github.com/ethereum/EIPs/issues/2212) support. `ethereum-wallet-dividends` shortcode can contain all attributes the `ethereum-wallet-balance` can. It requires the token to implement the [ERC2212](https://github.com/ethereum/EIPs/issues/2212) standard.

> See the official site for a live demo: [https://ethereumico.io/ethereum-wallet/](https://ethereumico.io/ethereum-wallet/ "The Ethereum Wallet WordPress plugin")

> To use the `ERC20 Dividend Payments Add-On` for the [Cryptocurrency Product for WooCommerce](https://ethereumico.io/product/cryptocurrency-wordpress-plugin/ "Cryptocurrency Product for WooCommerce") plugin, install the [Cryptocurrency Product for WooCommerce](https://ethereumico.io/product/cryptocurrency-wordpress-plugin/ "Cryptocurrency Product for WooCommerce") and then go to Settings > Cryptocurrency Product > Add-Ons > Dividends.

== Screenshots ==

1. The `[ethereum-wallet-account]` display with QR-code opened
2. The `[ethereum-wallet-sendform]` display
3. The `[ethereum-wallet-history]` display
4. The plugin settings
5. The `[ethereum-wallet-account-management-create]` display
6. The `[ethereum-wallet-account-management-import]` display
7. The `[ethereum-wallet-account-management-select]` display
8. The `[ethereum-wallet-account-management-export]` display
9. The `[ethereum-wallet-account-management-export]` display with QR-code opened
10. The `[ethereum-wallet-balance]` display with different settings

== Disclaimer ==

**By using this plugin you accept all responsibility for handling the account balances for all your users.**

Under no circumstances is **ethereumico.io** or any of its affiliates responsible for any damages incurred by the use of this plugin.

Every effort has been made to harden the security of this plugin, but its safe operation depends on your site being secure overall. You, the site administrator, must take all necessary precautions to secure your WordPress installation before you connect it to any live wallets.

You are strongly advised to take the following actions (at a minimum):

- [Educate yourself about cold and hot cryptocurrency storage](https://en.bitcoin.it/wiki/Cold_storage)
- Obtain hardware wallet to store your coins, like [Ledger Nano S](https://www.ledgerwallet.com/r/4caf109e65ab?path=/products/ledger-nano-s) or [TREZOR](https://shop.trezor.io?a=ethereumico.io)
- [Educate yourself about hardening WordPress security](https://codex.wordpress.org/Hardening_WordPress)
- [Install a security plugin such as Jetpack](https://jetpack.com/pricing/?aff=9181&cid=886903) or any other security plugin
- **Enable SSL on your site** if you have not already done so.

> By continuing to use the Ethereum Wallet WordPress plugin, you indicate that you have understood and agreed to this disclaimer.

== Installation ==

> Make sure that [System Requirements](https://ethereumico.io/knowledge-base/ethereum-wallet-plugin-system-requirements/) are met on your hosting provider. These providers are tested for compliance: [Cloudways](https://www.cloudways.com/en/?id=462243), [Bluehost](https://www.bluehost.com/track/olegabr/), [SiteGround](https://www.siteground.com/go/ethereumico)

Enter your settings in admin pages and place the `[ethereum-wallet-sendform]`, `[ethereum-wallet-balance]` and other shortcodes wherever you need it.

= bcmath and gmp =

`
sudo apt-get install php-bcmath php-gmp
service apache2 restart
`

For AWS bitnami AMI restart apache2 with this command:

`
sudo /opt/bitnami/ctlscript.sh restart apache
`

= Shortcodes =

Possible shortcodes configuration:

`
[ethereum-wallet-account label="Your wallet:"]

[ethereum-wallet-account nolabel="yes"]

[ethereum-wallet-balance]

[ethereum-wallet-balance tokenname="TSX" tokenaddress="0x6Fe928d427b0E339DB6FF1c7a852dc31b651bD3a"]

[ethereum-wallet-sendform]

[ethereum-wallet-history]

[ethereum-wallet-history direction="in"]

[ethereum-wallet-history direction="out"]

[ethereum-wallet-account-management-create]

[ethereum-wallet-account-management-select]

[ethereum-wallet-account-management-import]

[ethereum-wallet-account-management-export]
`

= Infura.io Api Key =

Register for an infura.io API key and put it in admin settings. It is required to interact with Ethereum blockchain. Use this [Get infura API Key Guide](https://ethereumico.io/knowledge-base/infura-api-key-guide/) if unsure.

== Testing ==

You can test this plugin in some test network for free. 

> The `ropsten`, `rinkeby`, `goerli` and `kovan` testnets are supported.

=== Testing in ropsten ===

* Set the `Blockchain` setting to `ropsten`
* "Buy" some Ropsten Ether for free using [MetaMask](https://metamask.io)
* Send some Ropsten Ether to the account this plugin generated for you. Use `[ethereum-wallet-account]` shortcode to display it
* Send some Ropsten Ether to the `0x773F803b0393DFb7dc77e3f7a012B79CCd8A8aB9` address to obtain TSX tokens. The TSX token has the `0x6Fe928d427b0E339DB6FF1c7a852dc31b651bD3a` address.
* Use your favorite wallet to send TSX tokens to the account this plugin generated for you
* Now test the plugin by sending some Ropsten Ether and/or TSX tokens from the generated account address to your other address. Use the `[ethereum-wallet-sendform]` shortcode to render the send form on a page.
* Check that proper amount of Ropsten Ether and/or TSX tokens has been sent to your payment address
* You can use your own token to test the same

=== Testing in rinkeby ===

* Set the `Blockchain` setting to `rinkeby`
* You can "buy" some Rinkeby Ether for free here: [rinkeby.io](https://www.rinkeby.io/#faucet)
* Send some Rinkeby Ether to the account this plugin generated for you. Use `[ethereum-wallet-account]` shortcode to display it
* Send some Rinkeby Ether to the `0x669519e1e150dfdfcf0d747d530f2abde2ab3f0e` address to obtain TSX tokens. The TSX token has the `0x194c35B62fF011507D6aCB55B95Ad010193d303E` address.
* Use your favorite wallet to send TSX tokens to the account this plugin generated for you
* Now test the plugin by sending some Rinkeby Ether and/or TSX tokens from the generated account address to your other address. Use the `[ethereum-wallet-sendform]` shortcode to render the send form on a page.
* Check that proper amount of Rinkeby Ether and/or TSX tokens has been sent to your payment address
* You can use your own token to test the same

== l10n ==

This plugin is localization ready.

Languages this plugin is available now:

* English
* Russian(Русский)
* German(Deutsche) by Johannes from decentris dot com

Feel free to translate this plugin to your language.

== Changelog ==

= 2.8.0 =

* `Ethereum wallet` column with linked user's account addresses is displayed on the `Users` WordPress admin page (`/wp-admin/users.php`)

= 2.7.4 =

* Fix Ultimate Member Pro and etherscan.io API conflict with the `X-CSRF-UMP-TOKEN` header

= 2.7.3 =

* Fix fatal error when WooCommerce is not installed
* Fix Ultimate Member Pro and etherscan.io API conflict with the `X-CSRF-UMP-TOKEN` header
* Correct gas estimation calculation for transactions
* Skip admin fee for contract target to support sending Ether to Crowdsale contracts

= 2.7.2 =

* goerli and kovan testnets support is added

= 2.7.1 =

* Fix new user registration issue

= 2.7.0 =

* Admin markup feature is implemented

= 2.6.5 =

* All external libs code is wrapped with an unique namespace to prevent conflicts
* Libraries are updated to latest versions
