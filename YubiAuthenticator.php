<?php

/**
 * PHP Class for handling Yubi Authenticator 2-factor authentication
 *
 * @author Michael Kliewe
 * @copyright 2012 Michael Kliewe
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link http://www.phpgangsta.de/
 */

class PHP_YubiAuthenticator
{
    /**
     * Check if the code is correct. Ask configured API Server.
     *
     * @param string $url
     * @return bool
     */
    public function verifyCode($url, &$response)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);

        $results = explode(PHP_EOL, $result);
        foreach ($results as $item) {
            $delpos = strpos($item,'=');
            if($delpos == false) continue;
            $response[substr($item,0,$delpos)] = substr($item, $delpos+1);
        }

        return $response["status"]=="OK";
    }
}
