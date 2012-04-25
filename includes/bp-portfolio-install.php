<?php

/**
 * Install the necessary tables
 */
function bp_portfolio_install_tables() {
    global $wpdb;

    $items_table_name = $wpdb->prefix . BP_PORTFOLIO_ITEMS_TABLE;

    $sql = "CREATE TABLE IF NOT EXISTS $items_table_name (
                id MEDIUMINT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                author_id MEDIUMINT( 9 ) NOT NULL,
                title TEXT NOT NULL ,
                description TEXT NOT NULL ,
                url VARCHAR( 255 ) NOT NULL ,
                created_at DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
                updated_at DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
                tags TEXT NOT NULL
            );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    add_option("bp_portfolio_db_version", BP_PORTFOLIO_DB_VERSION);
}

?>
