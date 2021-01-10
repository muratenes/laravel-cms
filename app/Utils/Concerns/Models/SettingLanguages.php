<?php

namespace App\Utils\Concerns\Models;


use App\Models\Ayar;

trait SettingLanguages
{
    /**
     * sitede bulunan diller
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
            if ($item[3] == $shortName)
                return true;
        });
        if (count($items) > 0)
            return $items->first()[0];
        return self::languages()[1][0];
    }


    /**
     * aktif dilleri getirir
     * @return array
     */
    public static function activeLanguages()
    {
        return collect(self::languages())->filter(function ($item, $key) {
            if ($item[2]) return true;
        })->toArray();
    }


    /**
     * sitenin ana dili hariç aktif dilleri dönderir
     * @return \Illuminate\Support\Collection
     */
    public static function otherActiveLanguages()
    {
        return collect(Ayar::languages())->filter(function ($item, $key) {
            if ($item[2] and defaultLangID() != $item[0]) return true;
        });
    }

    /**
     * language label getirir
     * @param $langId
     * @return string
     */
    public static function getLanguageLabelByLang($langId)
    {
        return self::languages()[$langId][1] ?? null;
    }


    /**
     * Dil resim getirir
     * @param $langId
     * @return mixed
     */
    public static function getLanguageImageNameById($langId)
    {
        return self::languages()[$langId][4] ?? self::languages()[self::LANG_TR][4];
    }

}

