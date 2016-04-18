<?php defined('SYSPATH') OR die('No direct script access.');

class Date extends Kohana_Date
{
    /**
     * @param string $format
     * @param null|string $locale
     * @param null|int $timestamp
     * 
     * @return string
     */
    public static function strftime_fix($format, $timestamp = null, $locale = null){
        $timestamp = null === $timestamp ? time() : $timestamp;
        $locale = null === $locale ? setlocale(LC_ALL, 'ru_RU.CP1251', 'rus_RUS.CP1251', 'Russian_Russia.1251', 'ru_RU.Windows1251') : $locale;
        
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            $format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
        }
        
        $date_str = strftime($format, $timestamp);
        
        if (stripos($locale, '1251') !== false) {
            return mb_convert_encoding($date_str,'utf-8', 'windows-1251');
        } elseif (stripos($locale, '1252') !== false) {
            return mb_convert_encoding($date_str, 'utf-8', 'windows-1251');
        } else {
            return $date_str;
        }
    }
}
