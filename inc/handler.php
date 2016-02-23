<?php
/***********************************************************
 * Copyright (c) 2016 WW Software House.
 * All Rights Reserved. Please visit http://wwsh.io
 **********************************************************/

/**
 * WordPress API Handler.
 *
 * Supports the following:
 * - registering actions
 * - registering filters
 * - registering shortcodes
 */
class YtMtv_Handler
{

    /**
     * The array of actions registered with WP.
     *
     * @var array
     */
    protected $actions;

    /**
     * The array of filters registered with WP.
     *
     * @var array
     */
    protected $filters;

    /**
     * The array of shortcodes registered with WP.
     *
     * @var array
     */
    protected $shortcodes;


    /**
     * YtMtv_Handler constructor.
     */
    public function __construct()
    {
        $this->actions    = [];
        $this->filters    = [];
        $this->shortcodes = [];
    }

    /**
     * Add a new action to the collection to be registered with WordPress.
     *
     * @param    string $hook The name of the WordPress action that is being registered.
     * @param    object $component A reference to the instance of the object on which the action is defined.
     * @param    string $callback The name of the method definition on the $component.
     * @param    int $priority Optional. WP priority at which the function should be fired. Default is 10.
     * @param    int $accepted_args Optional. No. of arguments that should be passed to the $callback. Default is 1.
     */
    public function add_action($hook, $component, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->actions = $this->add($this->actions, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * Add a new filter to the collection to be registered with WordPress.
     *
     * @param    string $hook The name of the WP filter that is being registered.
     * @param    object $component A reference to the instance of the object on which the filter is defined.
     * @param    string $callback The name of the method definition on the $component.
     * @param    int $priority Optional. WP priority at which the function should be fired. Default is 10.
     * @param    int $accepted_args Optional. No. of arguments that should be passed to the $callback. Default is 1
     */
    public function add_filter($hook, $component, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->filters = $this->add($this->filters, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * A utility function that is used to register the actions and hooks into a single collection.
     *
     * @param    array $hooks The collection of hooks that is being registered (that is, actions or filters).
     * @param    string $hook The name of the WordPress filter that is being registered.
     * @param    object $component A reference to the instance of the object on which the filter is defined.
     * @param    string $callback The name of the method definition on the $component.
     * @param    int $priority The priority at which the function should be fired.
     * @param    int $accepted_args No. of arguments that should be passed to the $callback.
     * @return   array  The collection of actions and filters registered with WP.
     */
    private function add($hooks, $hook, $component, $callback, $priority, $accepted_args)
    {

        $hooks[] = array(
            'hook'          => $hook,
            'component'     => $component,
            'callback'      => $callback,
            'priority'      => $priority,
            'accepted_args' => $accepted_args
        );

        return $hooks;

    }

    /**
     * Registering filters, actions and shortcodes with WordPress.
     */
    public function run()
    {

        foreach ($this->filters as $hook) {
            add_filter($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'],
                $hook['accepted_args']);
        }

        foreach ($this->actions as $hook) {
            add_action($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'],
                $hook['accepted_args']);
        }

        foreach ($this->shortcodes as $shortcode) {
            add_shortcode($shortcode['code'], [$shortcode['component'], $shortcode['callback']]);
        }
    }

    /**
     * Registering a custom shortcode in WP.
     *
     * @param   $code   The name of the shortcode to be registered for the plugin.
     * @param   $component  A reference to the instance of the object on which the shortcode is defined.
     * @param   $callback The name of the method definition on the $component.
     */
    public function add_shortcode($code, $component, $callback)
    {
        $this->shortcodes[] = [
            'code'      => $code,
            'component' => $component,
            'callback'  => $callback,
        ];
    }
}