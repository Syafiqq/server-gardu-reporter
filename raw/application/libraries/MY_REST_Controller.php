<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 05 July 2017, 8:06 AM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

namespace Restserver\Libraries;

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/REST_Controller.php';

class MY_REST_Controller extends REST_Controller
{
    public function __construct($config = 'rest')
    {
        parent::__construct($config);
    }

    /**
     * @param string $key
     * @param mixed|null $default_value
     * @param bool $xss_clean
     * @return mixed|array|null
     */
    public function postOrDefault($key = null, $default_value = null, $xss_clean = null)
    {
        $value = parent::post($key, $xss_clean);

        if (!$value)
        {
            $value = $default_value;
        }

        return $value;
    }

    /**
     * @param string $key
     * @param mixed|null $default_value
     * @param bool $xss_clean
     * @return mixed|array|null
     */
    public function getOrDefault($key = null, $default_value = null, $xss_clean = null)
    {
        $value = parent::get($key, $xss_clean);

        if (!$value)
        {
            $value = $default_value;
        }

        return $value;
    }
}

?>
