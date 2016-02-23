<?php
/***********************************************************
 * Copyright (c) 2016 WW Software House.
 * All Rights Reserved. Please visit http://wwsh.io
 **********************************************************/


/**
 * Performing plugin activation.
 *
 * @author     Thomas Parys <ww@epoczta.pl>
 */
class YtMtv_Activator
{

    /**
     * Nothing much to do except creating one table for stats.
     */
    public static function activate()
    {
        global $wpdb;

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $sql = <<<SQL
		CREATE TABLE `ytmtv` (
		  `id` int(11) NOT NULL auto_increment,
          `time` TIMESTAMP NOT NULL,
          `videoId` varchar(256) NOT NULL,
          PRIMARY KEY  (`id`)
        )
SQL;
        $sql .= $wpdb->get_charset_collate();

        dbDelta($sql);

        add_option('ytmtv_version', YTMTV_VERSION);
    }

}