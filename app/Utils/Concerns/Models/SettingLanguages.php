<?php

namespace App\Utils\Concerns\Models;


trait SettingLanguages
{
    /**
     * sitede bulunan diller.
     *
     * @return array[]
     */
    public static function languages()
    {
        // id,name,status,code,image,price
        return [
            self::LANG_TR => [self::LANG_TR, 'Türkçe', true, 'tr', 'tr.png', self::CURRENCY_TL],
            self::LANG_EN => [self::LANG_EN, 'English', true, 'en', 'en.png', self::CURRENCY_USD],
            self::LANG_DE => [self::LANG_DE, 'Germany', true, 'de', 'de.png', self::CURRENCY_EURO],
            self::LANG_FR => [self::LANG_FR, 'Fransa', false, 'fr', 'fr.png', self::CURRENCY_USD],
        ];
    }

    public static function getLanguageIdByShortName($shortName)
    {
        $items = collect(self::languages())->filter(function ($item, $key) use ($shortName) {
            if ($item[3] === $shortName) {
                return true;
            }
        });
        if (\count($items) > 0) {
            return $items->first()[0];
        }

        return self::languages()[1][0];
    }



    /**
     * language label getirir.
     *
     * @param $langId
     *
     * @return string
     */
    public static function getLanguageLabelByLang($langId)
    {
        return self::languages()[$langId][1] ?? null;
    }

    /**
     * Dil resim getirir.
     *
     * @param $langId
     *
     * @return mixed
     */
    public static function getLanguageImageNameById($langId)
    {
        return self::languages()[$langId][4] ?? self::languages()[self::LANG_TR][4];
    }
}
