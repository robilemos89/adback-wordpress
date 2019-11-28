<?php

/**
 * A proxy to the WordPress Transient API
 * 
 * @link       https://www.adback.co
 * @since      3.9.0
 *
 * @package    Ad_Back
 * @subpackage Ad_Back/admin
 * @author     AdBack <contact@adback.co>
 */

final class Ad_Back_Transient
{
    /**
     * Retrieve the endpoint data
     *
     * @param int $currentBlogId
     * @return mixed|bool
     */
    public static function getEndpoint($currentBlogId=null)
    {
        return self::get(Ad_Back_Transient_Keys::END_POINT, $currentBlogId);
    }

    /**
     * Set the endpoint value. Returns true if the value was saved successfully, or false
     * if data cannot be saved.
     *
     * @param mixed $value
     * @param int $currentBlogId
     * @param int $expiration
     * @return bool
     */
    public static function setEndpoint($value, $currentBlogId=null, $expiration=null)
    {
        return self::set(Ad_Back_Transient_Keys::END_POINT, $value, $currentBlogId, $expiration);
    }

    /**
     * Delete endpoint data from transient
     *
     * @param int $currentBlogId
     * @return bool
     */
    public static function deleteEndpoint($currentBlogId=null)
    {
        return self::delete(Ad_Back_Transient_Keys::END_POINT, $currentBlogId);
    }

    /**
     * Set the full_tag value. Returns true if the value was saved successfully, or false
     * if data cannot be saved.
     *
     * @param mixed $value
     * @param int $currentBlogId
     * @param int $expiration
     * @return bool
     */
    public static function setFullTag($value, $currentBlogId=null, $expiration=null)
    {
        return self::set(Ad_Back_Transient_Keys::FULL_TAG, $value, $currentBlogId, $expiration);
    }

    /**
     * Retrieve the full_tag data
     *
     * @param int $currentBlogId
     * @return mixed|bool
     */
    public static function getFullTag($currentBlogId=null)
    {
        return self::get(Ad_Back_Transient_Keys::FULL_TAG, $currentBlogId);
    }

    /**
     * Delete full_tag data from transient
     *
     * @param int $currentBlogId
     * @return bool
     */
    public static function deleteFullTag($currentBlogId=null)
    {
        return self::delete(Ad_Back_Transient_Keys::FULL_TAG, $currentBlogId);
    }

    /**
     * Set the account value. Returns true if the value was saved successfully, or false
     * if data cannot be saved.
     *
     * @param mixed $value
     * @param int $currentBlogId
     * @param int $expiration
     * @return bool
     */
    public static function setAccount($value, $currentBlogId=null, $expiration=null)
    {
        return self::set(Ad_Back_Transient_Keys::ACCOUNT, $value, $currentBlogId, $expiration);
    }

    /**
     * Retrieve the account data
     *
     * @param int $currentBlogId
     * @return mixed|bool
     */
    public static function getAccount($currentBlogId=null)
    {
        return self::get(Ad_Back_Transient_Keys::ACCOUNT, $currentBlogId);
    }

    /**
     * Delete account data from transient
     *
     * @param int $currentBlogId
     * @return bool
     */
    public static function deleteAccount($currentBlogId=null)
    {
        return self::delete(Ad_Back_Transient_Keys::ACCOUNT, $currentBlogId);
    }

    /**
     * Set the my_info value. Returns true if the value was saved successfully, or false
     * if data cannot be saved.
     *
     * @param mixed $value
     * @param int $currentBlogId
     * @param int $expiration
     * @return bool
     */
    public static function setMyInfo($value, $currentBlogId=null, $expiration=null)
    {
        return self::set(Ad_Back_Transient_Keys::MYINFO, $value, $currentBlogId, $expiration);
    }

    /**
     * Retrieve the my_info data
     *
     * @param int $currentBlogId
     * @return mixed|bool
     */
    public static function getMyInfo($currentBlogId=null)
    {
        return self::get(Ad_Back_Transient_Keys::MYINFO, $currentBlogId);
    }
    
    /**
     * Delete my_info data from transient
     *
     * @param int $currentBlogId
     * @return bool
     */
    public static function deleteMyInfo($currentBlogId=null)
    {
        return self::delete(Ad_Back_Transient_Keys::MY_INFO, $currentBlogId);
    }

    /**
     * Retrieve the token data
     *
     * @param int $currentBlogId
     * @return mixed|bool
     */
    public static function getToken($currentBlogId=null)
    {
        return self::get(Ad_Back_Transient_Keys::TOKEN, $currentBlogId);
    }

    /**
     * Set the token value. Returns true if the value was saved successfully, or false
     * if data cannot be saved.
     *
     * @param mixed $value
     * @param int $currentBlogId
     * @param int $expiration
     * @return bool
     */
    public static function setToken($value, $currentBlogId=null, $expiration=null)
    {
        return self::set(Ad_Back_Transient_Keys::TOKEN, $value, $currentBlogId, $expiration);
    }

    /**
     * Delete token data from transient
     *
     * @param int $currentBlogId
     * @return bool
     */
    public static function deleteToken($currentBlogId=null)
    {
        return self::delete(Ad_Back_Transient_Keys::TOKEN, $currentBlogId);
    }

    /**
     * Return transient key specified, using the blog_id condition
     *
     * @param int $key
     * @param int $currentBlogId
     * @return mixed|bool
     */
    private static function get($key, $currentBlogId=null)
    {
        $keyToRetrieve = self::getKey($key, $currentBlogId);

        return get_transient($keyToRetrieve);
    }

    /**
     * Set the value on the specified key, using the blog_id parameters and expiration
     *
     * @param string $key
     * @param mixed $value
     * @param int $currentBlogId
     * @param int $expiration
     * @return bool
     */
    private static function set($key, $value, $currentBlogId=null, $expiration=null)
    {
        $keyToSet = self::getKey($key, $currentBlogId);

        // If expiration is null, then, the default expiration time is 6 hours.
        if ($expiration === null) {
            $expiration = 6 * HOUR_IN_SECONDS;
        }

        return set_transient($keyToSet, $value);
    }

    /**
     * Delete the data from specified record
     *
     * @param string $key
     * @param int $currentBlogId
     * @return bool
     */
    private static function delete($key, $currentBlogId=null)
    {
        $keyToDelete = self::getKey($key, $currentBlogId);

        return delete_transient($keyToDelete);
    }

    /**
     * Return formatted key, using blog_id as parameter if applicable.
     *
     * @param string $key
     * @param int $currentBlogId
     * @return string
     */
    private static function getKey($key, $currentBlogId=null)
    {
        $keyToReturn = $key;

        if ($currentBlogId !== null) {
            $keyToReturn .= "_{$currentBlogId}";
        }

        return $keyToReturn;
    }
}