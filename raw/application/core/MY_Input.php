<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 05 July 2017, 8:00 AM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Input extends CI_Input
{
    /**
     * @param string $index
     * @param mixed|null $default_value
     * @param bool $xss_clean
     * @return mixed|array|null
     */
    function postOrDefault($index = null, $default_value = null, $xss_clean = false)
    {
        $value = parent::post($index, $xss_clean);

        if (!$value)
        {
            $value = $default_value;
        }

        return $value;
    }

    /**
     * @param string $index
     * @param mixed|null $default_value
     * @param bool $xss_clean
     * @return mixed|array|null
     */
    function getOrDefault($index = null, $default_value = null, $xss_clean = false)
    {
        $value = parent::get($index, $xss_clean);

        if (!$value)
        {
            $value = $default_value;
        }

        return $value;
    }
}

?>
