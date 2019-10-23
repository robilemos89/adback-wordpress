<?php

/**
 * Used to get content from the adback api
 *
 * @link       https://www.adback.co
 * @since      1.0.0
 *
 * @package    Ad_Back
 * @subpackage Ad_Back/includes
 */

/**
 * Used to get content from the adback api
 *
 * This class defines all code to get some data
 *
 * @since      1.0.0
 * @package    Ad_Back
 * @subpackage Ad_Back/includes
 * @author     AdBack <contact@adback.co>
 */
class Ad_Back_Get
{
    static public function execute($url)
    {
        $response = wp_remote_get($url, array('timeout' => 2));

        return wp_remote_retrieve_body($response);
    }
}
