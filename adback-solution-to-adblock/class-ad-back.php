<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.adback.co
 * @since      1.0.0
 *
 * @package    Ad_Back
 * @subpackage Ad_Back
 */
class Ad_Back_Generic
{
    public function getContents($url)
    {
        if (function_exists('curl_version')) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            $data = curl_exec($curl);
            curl_close($curl);
            return $data;
        } else {
            return @file_get_contents($url);
        }
    }

    public function postContents($url, $fields, $header = array())
    {
        $header[] = 'Content-Type: application/json';

        if (function_exists('curl_version')) {

            //open connection
            $ch = curl_init();

            //set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            if (is_array($fields)) {
                curl_setopt($ch, CURLOPT_POST, count($fields));
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            } else {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

            //execute post
            $result = curl_exec($ch);

            //close connection
            curl_close($ch);
        } else {
            $options = array(
                'http' => array(
                    'header' => implode("\r\n", $header),
                    'method' => 'POST',
                    'content' => is_array($fields) ? json_encode($fields) : $fields
                )
            );
            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
        }

        return $result;
    }

    public function getMyInfo()
    {
        global $wpdb; // this is how you get access to the database

        $table_name = $wpdb->prefix . 'adback_myinfo';
        $myinfo = $wpdb->get_row("SELECT * FROM " . $table_name . " WHERE id = 1");

        if ($myinfo->myinfo == "" || strtotime($myinfo->update_time) < (time() - 10800)) {
            $mysite = $this->askScripts();

            if ($mysite === null) {
                return null;
            }

            $wpdb->update(
                $table_name,
                array(
                    'myinfo' => json_encode($mysite),
                    'update_time' => current_time('mysql', 1)
                ),
                array("id" => 1)
            );

        } else if ($myinfo->myinfo != "") {
            $mysite = json_decode($myinfo->myinfo, true);
        }

        return $mysite;
    }

    public function getCacheMessages()
    {
        global $wpdb; // this is how you get access to the database

        $table_name = $wpdb->prefix . 'adback_message';
        return stripslashes_deep($wpdb->get_row("SELECT * FROM " . $table_name . " WHERE id = 1"));
    }

    public function saveCacheMessage($display)
    {
        global $wpdb; // this is how you get access to the database

        $fields = array(
            "message" => '',
            "header_text" => '',
            "close_text" => '',
            "display" => filter_var($display, FILTER_VALIDATE_BOOLEAN),
            "update_time" => current_time('mysql', 1)
        );

        $table_name = $wpdb->prefix . 'adback_message';
        $wpdb->update(
            $table_name,
            $fields,
            array("id" => 1)
        );
    }

    public function getMessages()
    {
        $message = $this->getCacheMessages();

        $result = array();
        $result['display'] = $message->display;

        return stripslashes_deep($result);
    }

    public function saveMessage($display)
    {
        $url = 'https://adback.co/api/custom-message/update-status?_format=json&access_token=' . $this->getToken()->access_token;
        $displayAsBoolean = 'true' === $display ? true : false;
        $fields = ['display' => $displayAsBoolean];
        $this->postContents($url, $fields);
        $this->saveCacheMessage($display);

        return true;
    }

    public function isConnected($token = null)
    {
        if ($token == null) {
            $token = $this->getToken();
        }

        if (is_array($token)) {
            $token = (object)$token;
        }

        if (isset($token->access_token)) {
            $url = "https://www.adback.co/api/test/normal?access_token=" . $token->access_token;
            $result = json_decode($this->getContents($url), true);
            return is_array($result) && array_key_exists("name", $result);
        } else {
            return false;
        }
    }

    public function getToken()
    {
        global $wpdb; // this is how you get access to the database

        $table_name = $wpdb->prefix . 'adback_token';
        $token = $wpdb->get_row("SELECT * FROM " . $table_name . " WHERE id = 1");

        return $token;
    }

    public function saveToken($token)
    {
        global $wpdb; // this is how you get access to the database

        if ($token == null || array_key_exists("error", $token)) {
            return;
        }

        $table_name = $wpdb->prefix . 'adback_token';
        $wpdb->update(
            $table_name,
            array(
                "access_token" => $token["access_token"],
                "refresh_token" => $token["refresh_token"]
            ),
            array("id" => 1)
        );

        $this->notifyInstallation($token["access_token"]);
    }

    public function notifyInstallation($accessToken)
    {
        $notifyUrl = 'https://www.adback.co/api/plugin-activate/wordpress?access_token=' . $accessToken;

        $this->getContents($notifyUrl);
    }

    public function askDomain()
    {
        if (null === $this->getToken() || '' === $this->getToken()->access_token) {
            return null;
        }

        $jsonDomain = $this->getContents("https://www.adback.co/api/script/me?access_token=" . $this->getToken()->access_token);
        $result = json_decode($jsonDomain, true);
        if (isset($result['analytics_domain'])) {
            $this->saveDomain($result['analytics_domain']);
        }
    }

    public function askScripts()
    {
        if (null === $this->getToken() || '' === $this->getToken()->access_token) {
            return null;
        }

        $jsonScripts = $this->getContents("https://www.adback.co/api/script/me?access_token=" . $this->getToken()->access_token);
        $result = json_decode($jsonScripts, true);

        return $result;
    }

    public function saveDomain($domain)
    {
        global $wpdb; // this is how you get access to the database

        $table_name = $wpdb->prefix . 'adback_myinfo';
        $wpdb->update(
            $table_name,
            array(
                'domain' => $domain,
                'update_time' => current_time('mysql', 1)
            ),
            array("id" => 1)
        );
    }

    public function getDomain()
    {
        global $wpdb; // this is how you get access to the database

        $table_name = $wpdb->prefix . 'adback_myinfo';
        $myinfo = $wpdb->get_row("SELECT domain FROM " . $table_name . " WHERE id = 1 AND update_time >= DATE_SUB(NOW(),INTERVAL 3 HOUR);");

        return $myinfo ? $myinfo->domain : '';
    }

    public function askSubscription()
    {
        if (null === $this->getToken() || '' === $this->getToken()->access_token) {
            return null;
        }

        $jsonDomain = $this->getContents("https://www.adback.co/api/subscription/me?access_token=" . $this->getToken()->access_token);
        $result = json_decode($jsonDomain, true);

        return $result;
    }
}
