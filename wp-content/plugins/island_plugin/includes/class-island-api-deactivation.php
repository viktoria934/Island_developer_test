<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Island_Wp_Deactivator {
    public static function deactivate() {
        global $wpdb;
        $table_name = $wpdb->get_blog_prefix() . 'island_users';
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $sql = "DROP TABLE IF EXISTS {$table_name}";
        $wpdb->query($sql);

        $table_name = $wpdb->get_blog_prefix() . 'island_items';
        $sql = "DROP TABLE IF EXISTS {$table_name}";
        $wpdb->query($sql);

        $table_name = $wpdb->get_blog_prefix() . 'island_user_items';
        $sql = "DROP TABLE IF EXISTS {$table_name}";
        $wpdb->query($sql);

        $table_name = $wpdb->get_blog_prefix() . 'island_lots';
        $sql = "DROP TABLE IF EXISTS {$table_name}";
        $wpdb->query($sql);
    }
}