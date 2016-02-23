<?php
/***********************************************************
 * Copyright (c) 2016 WW Software House.
 * All Rights Reserved. Please visit http://wwsh.io
 **********************************************************/

/**
 * A data response processor designed specifically for the YouTube API.
 *
 * @author    Thomas Parys <ww@epoczta.pl>
 */
class YtMtv_YouTubeProcessor
{
    /**
     * Postprocessor method for YouTube search response.
     *
     * Extracts all videoIDs from the search response and returns them as one array.
     *
     * @param $response
     * @return array
     */
    public function process($response)
    {
        if (empty($response) || !isset($response['collection_key']) || !isset($response['modelData'])) {
            return [];
        }

        $collectionKey = $response['collection_key'];
        $items         = $response['modelData'][$collectionKey];
        $result        = [];
        foreach ($items as $item) {
            $result[] = $item['id']['videoId'];
        }

        return $result;
    }
}