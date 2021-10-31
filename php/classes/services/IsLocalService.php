<?php

class IsLocalService
{
    /**
     * Check if the website is currently on a localhost or not
     * 
     * @author https://stackoverflow.com/a/21702853
     * 
     * @param array $whitelist addresses that are localhost
     * @return boolean true if local
     */
    static function check(array $whitelist = ['127.0.0.1', '::1']): bool
    {
        return in_array($_SERVER['REMOTE_ADDR'], $whitelist);
    }
}