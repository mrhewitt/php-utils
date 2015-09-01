<?php

namespace MarkHewitt\Util;

/**
 * Class for providing a secure token that can be used for applications such as links to confirm user email
 * address or activate accounts 
 *
 * @link   https://github.com/mrhewitt/php-utils
 * @author Mark Hewitt <info@markhewitt.co.za>
 */
class Token {
	
	/**
	 * Returns a secure random token that can be used for actions such as links for
	 * activating user accounts or confirming of email addresses
	 *
	 * @return string
	 */
    public static function generate()
    {
        return rtrim(strtr(base64_encode($this->getRandomNumber()), '+/', '-_'), '=');
    }

    private function getRandomNumber()
    {
        // determine whether to use OpenSSL
        if (defined('PHP_WINDOWS_VERSION_BUILD') && version_compare(PHP_VERSION, '5.3.4', '<')) {
            $open_ssl = false;
        } else if (!function_exists('openssl_random_pseudo_bytes')) {
            $open_ssl = false;
        } else {
            $open_ssl = true;
        }
		
        $nbBytes = 32;

        // try OpenSSL
        if ($open_ssl) {
            $bytes = openssl_random_pseudo_bytes($nbBytes, $strong);

            if (false !== $bytes && true === $strong) {
                return $bytes;
            }
        }

        return hash('sha256', uniqid(mt_rand(), true), true);
    }
}

