<?php
/***********************************************************
 * Copyright (c) 2016 WW Software House.
 * All Rights Reserved. Please visit http://wwsh.io
 **********************************************************/

/**
 * A bridge between the plugin and Google API Client library.
 * Portions of code copied from google.com.
 *
 * @author    Thomas Parys <ww@epoczta.pl>
 */
class YtMtv_YouTubeService
{
    /**
     * @var YtMtv_Options
     */
    private $options;

    /**
     * Class responsible for processing data incoming from the YouTube API.
     * 
     * @var YtMtv_YouTubeProcessor
     */
    private $processor;

    /**
     * This service consumes options, as it need the Google Developer Console's
     * Developer API Key to function.
     *
     * @todo Rewrite into OAUTH.
     *
     * @param $options
     */
    public function __construct($options)
    {
        $this->options   = $options;
        $this->processor = new YtMtv_YouTubeProcessor();
    }

    /**
     * Performs a YouTube search.
     *
     * @return Google_Service_YouTube_SearchListResponse|false
     */
    private function search()
    {
        $client = new Google_Client();
        $client->setDeveloperKey($this->options->get('key'));
        // Define an object that will be used to make all API requests.
        $youtube = new Google_Service_YouTube($client);
        // perform YouTube search.
        try {
            $response = $youtube->search->listSearch('id,snippet', array(
                'q'          => $this->options->get('bonanza'),
                'type'       => 'video',
                'maxResults' => '50',
            ));
        }
        catch (Google_Service_Exception $e) {
            return false;
        }

        return $response;
    }


    /**
     * Returning one videoID from youtube random search, performed, using
     * provided keywords ("bonanza").
     *
     * This is the only public method of this service.
     *
     * @return mixed|null
     */
    public function get_random_videoID()
    {
        $response = $this->search();

        if ($response === false) {
            return null;
        }

        $videoIds = $this->processor->process($response);

        if (empty($videoIds)) {
            return null;
        }

        shuffle($videoIds);
        $result = array_shift($videoIds);

        return $result;
    }
}