<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Island_Wp_Activator {
    public static function activate() {
        global $wpdb;
        $table_name = $wpdb->get_blog_prefix() . 'island_users';
        $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $sql = "CREATE TABLE {$table_name} (
            id int(11) unsigned NOT NULL auto_increment,
            name varchar(255) NOT NULL default '',
            PRIMARY KEY  (id)
        ) {$charset_collate};";

        dbDelta($sql);

        $table_name = $wpdb->get_blog_prefix() . 'island_items';
        $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";
        $sql = "CREATE TABLE {$table_name} (
            id int(11) unsigned NOT NULL auto_increment,
            name varchar(255) NOT NULL default '',
            value int(11) DEFAULT NULL,
            PRIMARY KEY  (id)
        ) {$charset_collate};";

        dbDelta($sql);

        $table_name = $wpdb->get_blog_prefix() . 'island_user_items';
        $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";
        $sql = "CREATE TABLE {$table_name} (
            id int(11) unsigned NOT NULL auto_increment,
            id_user int(11) DEFAULT NULL,
            id_item int(11) DEFAULT NULL,
            PRIMARY KEY  (id)
        ) {$charset_collate};";

        dbDelta($sql);

        $table_name = $wpdb->get_blog_prefix() . 'island_lots';
        $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";
        $sql = "CREATE TABLE {$table_name} (
            id int(11) unsigned NOT NULL auto_increment,
            creator_id int(11) DEFAULT NULL,
            consumer_id int(11) DEFAULT NULL,
            status varchar(10) NOT NULL default '',
            creator_items varchar(255) NOT NULL default '',
            consumer_items varchar(255) NOT NULL default '',
            PRIMARY KEY  (id)
        ) {$charset_collate};";

        dbDelta($sql);

        run_island_api_wp();
    }
}