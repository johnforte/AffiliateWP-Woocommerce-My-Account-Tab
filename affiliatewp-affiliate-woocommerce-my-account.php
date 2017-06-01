<?php
/*
Plugin Name: AffiliateWP Woocommerce My Account Tab
Description: Adds AffiliateWP to the my account menu and page inside of Woocommerce
Version: 0.0.1
Author: John Forte
*/
function affilatewp_woocommerce_add_affilate_wp_endpoint() {
  add_rewrite_endpoint( 'woocommerce-affiliate', EP_ROOT | EP_PAGES );
}
add_action( 'init', 'affilatewp_woocommerce_add_affilate_wp_endpoint' );

function affilatewp_woocommerce_my_account_menu( $items ) {
  if (function_exists( 'affwp_is_affiliate' ) && affwp_is_affiliate() ) {
    $logout = array_pop( $items );
    $items['woocommerce-affiliate'] = 'Affiliate Details';
    $items[] = $logout;
  }
  return $items;
}
add_filter( 'woocommerce_account_menu_items', 'affilatewp_woocommerce_my_account_menu' );

function affilatewp_woocommerce_tab_content() {
  if (!class_exists( 'Affiliate_WP_Shortcodes' ) ) {
    return;
  }
  $shortcode = new Affiliate_WP_Shortcodes;
  echo $shortcode->affiliate_area(array());
}
add_action('woocommerce_account_woocommerce-affiliate_endpoint', 'affilatewp_woocommerce_tab_content' );

function affilatewp_woocommerce_filter_affiliate_tabs( $url, $page_id, $tab ) {
  return esc_url_raw(add_query_arg( 'tab', $tab));
}
add_filter( 'affwp_affiliate_area_page_url', 'affilatewp_woocommerce_filter_affiliate_tabs', 10, 3 );
