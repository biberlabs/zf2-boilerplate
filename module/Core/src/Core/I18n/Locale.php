<?php
/**
 * Locale class for i18n purposes.
 *
 * @since     Jul 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Core\I18n;

class Locale
{
    const LOCALE_TR = 'tr_TR';
    const LOCALE_EN = 'en_US';

    const DEFAULT_LOCALE = self::LOCALE_EN;

    /**
     * Returns application-wide available locales list.
     *
     * @static
     *
     * @return array
     */
    public static function getAvailableLocales()
    {
        return array(
            self::LOCALE_TR => 'Türkçe',
            self::LOCALE_EN => 'English',
            );
    }
}
