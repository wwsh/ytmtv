<?php
/***********************************************************
 * Copyright (c) 2016 WW Software House.
 * All Rights Reserved. Please visit http://wwsh.io
 **********************************************************/

/**
 * The entity of options class.
 *
 * Manages options (options) of the plugin.
 * Easy extendable.
 *
 * @author     Thomas Parys <ww@epoczta.pl>
 */
class YtMtv_Options
{
    /**
     * @var array
     */
    private $options;

    /**
     * Enumerates all options. And their default values.
     *
     * @var array
     */
    private $metaInformation = [
        'bonanza' => [
            'type'    => 'text',
            'default' => 'mtv party zone',
            'hint'    => 'Enter keywords to use in YouTube Search, separated by space.',
        ],
        'width'   => [
            'type'    => 'numeric',
            'default' => 512,
            'hint'    => 'Width of the player.',
        ],
        'height'  => [
            'type'    => 'numeric',
            'default' => 384,
            'hint'    => 'Height of the player.',
        ],
        'key'     => [
            'type'    => 'text',
            'default' => '',
            'hint'    => 'Required! Google YouTube API key. Go to https://console.developers.google.com, create and paste here.'
        ],
    ];

    /**
     * YtMtv_options constructor.
     */
    public function __construct()
    {
        $this->options = [];

        foreach ($this->metaInformation as $optionName => $optionDescriptor) {
            $this->options[$optionName] = get_option($optionName, $optionDescriptor['default']);
        }

    }

    /**
     * Save it all down the database.
     *
     * @since 1.0.0
     * @param array $options Array of options incoming.
     */
    public function save($options = [])
    {
        if (!empty($options)) {
            // we can easily do that, since unknown fields are filtered below.
            $this->options = $options;
        }

        foreach ($this->metaInformation as $optionName => $optionDescriptor) {
            update_option($optionName, $this->options[$optionName]);
        }

        // re-read all options and clear unknown fields.
        $this->options = [];
        foreach ($this->metaInformation as $optionName => $optionDescriptor) {
            $this->options[$optionName] = get_option($optionName, $optionDescriptor['default']);
        }
    }

    /**
     * Read a option or all options.
     *
     * @param null $name
     * @return array|mixed
     */
    public function get($name = null)
    {
        if ($name !== null && isset($this->options[$name])) {
            return $this->options[$name];
        }

        if ($name !== null && !isset($this->options[$name])) {
            throw new LogicException('Unsupported option');
        }

        return $this->options;
    }

    /**
     * Getting hints from the metadata descriptions.
     *
     * @return array
     */
    public function getHints()
    {
        $hints = [];

        foreach ($this->metaInformation as $optionName => $optionDescriptor) {
            $hints[$optionName] = $optionDescriptor['hint'];
        }

        return $hints;
    }
}