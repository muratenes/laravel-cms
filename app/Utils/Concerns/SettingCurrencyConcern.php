<?php

namespace App\Utils\Concerns;

trait SettingCurrencyConcern
{
    /**
     * site üzerinde bulunan para birimleri.
     *
     * @return array[]
     */
    public static function currencies()
    {
        // const,short name,symbol,iyzico,database_prefix,status
        return [
            self::CURRENCY_TL   => [self::CURRENCY_TL, 'TL', '₺', 'TRY', 'tl', true],
            self::CURRENCY_USD  => [self::CURRENCY_USD, 'USD', '$', 'USD', 'usd', true],
            self::CURRENCY_EURO => [self::CURRENCY_EURO, 'EURO', '€', 'EUR', 'eur', true],
        ];
    }

    /**
     * aktif para birimlerini getirir.
     *
     * @return array
     */
    public static function activeCurrencies()
    {
        return collect(self::currencies())->filter(function ($item) {
            if ($item[5]) {
                return true;
            }
        })->toArray();
    }

    /**  seçilen dile göre varsayılan para birimi gönderilir.
     * @param $lang
     */
    public static function getCurrencyIDByLanguage($lang)
    {
        return isset(self::languages()[$lang])
            ? self::languages()[$lang][5]
            : self::languages()[config('admin.default_language')][5];
    }

    /**
     * eğer param gönderilirse zorlama yok ise onu return eder
     * dile göre para birimi zorlanmışşa dile göre getirir
     * yoksa sessiondan getirir
     * yoksa configden getirir.
     *
     * @param null $currencyID
     *
     * @return int
     */
    public static function getCurrencyId($currencyID = null)
    {
        if (config('admin.force_lang_currency')) {
            return self::getCurrencyIDByLanguage(curLangId());
        }
        if ($currencyID) {
            return $currencyID;
        }

        return session()->has('currency_id') ? session()->get('currency_id') : config('admin.default_currency');
    }

    /**  seçilen dile sembolü getirir.
     * @param $languageID
     */
    public static function getCurrencySymbolById($languageID)
    {
        return isset(self::currencies()[$languageID])
            ? self::currencies()[$languageID][2]
            : '-';
    }

    /**
     * seçilen dile göre varsayılan para birimi prefix gönderilir
     * return ex: tl,usd,eur.
     *
     * @param $lang
     */
    public static function getCurrencyProductPrefixByLang($lang)
    {
        return self::currencies()[self::getCurrencyIDByLanguage($lang)][4];
    }

    /**
     *  seçilen dile göre varsayılan para birimi product_price db sutunu gönderilir
     *  return ex : tl_price, usd_price,eur_price.
     *
     * @param $lang
     */
    public static function getCurrencyProductPriceFieldByLang($lang)
    {
        return self::currencies()[self::getCurrencyIDByLanguage($lang)][4] . '_price';
    }

    /**
     * seçilen para birimine göre ürün prefix gönderilir
     * return ex: tl,usd,eur.
     *
     * @param $currencyID
     *
     * @return mixed
     */
    public static function getCurrencyProductPrefixByID($currencyID = null)
    {
        return $currencyID
        ? self::currencies()[$currencyID][4]
        : self::currencies()[self::getCurrencyId()][4];
    }

    /**
     * para birimi ön eki getirir.
     *
     * @param $currency
     *
     * @return string
     */
    public static function getCurrencyPrefixByCurrencyID($currency)
    {
        return self::currencies()[$currency] ? self::currencies()[$currency][4] : config('admin.default_currency_prefix');
    }

    /**
     * iyzico para birimi gönder.
     *
     * @param int $currencyID
     */
    public static function getCurrencyIyzicoConstById($currencyID)
    {
        return self::currencies()[$currencyID]
            ? self::currencies()[$currencyID][3]
            : self::currencies()[config('admin.default_currency')][3];
    }
}
