<?php

/**
 * Used to post content to the adback api
 *
 * @link       https://www.adback.co
 * @since      1.0.0
 *
 * @package    Ad_Back
 * @subpackage Ad_Back/includes
 */

/**
 * Used to post content to the adback api
 *
 * This class defines all code to send some data
 *
 * @since      1.0.0
 * @package    Ad_Back
 * @subpackage Ad_Back/includes
 * @author     AdBack <contact@adback.co>
 */
class Ad_Back_Post
{
    public static function execute($url, $fields, $header = array())
    {
        $args = array(
            'timeout' => 2,
            'headers' => array(
                'Content-Type' => 'application/json'
            ),
            'body' => is_array($fields) ? json_encode($fields) : $fields
        );

        $response = wp_remote_post($url, $args );

        return wp_remote_retrieve_body($response);
    }
}
