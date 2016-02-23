<?php
/***********************************************************
 * Copyright (c) 2016 WW Software House.
 * All Rights Reserved. Please visit http://wwsh.io
 **********************************************************/

/**
 * Simple and primitive class, responsible for gathering shown videoIDs
 * in a database table.
 *
 * @author Thomas Parys <ww@epoczta.pl>
 */
class YtMtv_StatsCollector
{
    /**
     * Inserting a dataset into the stats database.
     * 
     * @param $videoID Video ID from YouTube
     */
    public function collect($videoID)
    {
        global $wpdb;

        $dataset = [
            'videoID'     => $videoID
        ];

        $wpdb->insert('ytmtv', $dataset);
    }
}