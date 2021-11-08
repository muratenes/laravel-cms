<?php

use App\Models\Admin;
use App\Models\Ayar;
use Illuminate\Support\Str;

function changeUIPhoneNumberToDbFormat($phone)
{
    $replacedText = ['(', ')', ' ', '-', '_'];

    return str_replace($replacedText, '', $phone);
}

function changeUIIbanNumberToDBFormat($ibanNumber)
{
    $replacedText = ['(', ')', ' ', '-', '_', '/', '['];

    return str_replace($replacedText, '', $ibanNumber);
}

function curLang()
{
    return session()->get('lang', config('app.locale'));
}

function curLangId()
{
    return session()->get('lang_id', config('admin.default_language'));
}

function defaultLangID()
{
    return config('admin.default_language');
}

function langIcon($langId)
{
    return '/admin_files/dist/img/langs/' . \App\Models\Ayar::getLanguageImageNameById($langId);
}

function langTitle($langId)
{
    return Ayar::getLanguageLabelByLang($langId);
}

// ====== PARA BİRİMLERİ =============
/**
 * mevcut para birimi sembol getirir.
 *
 * @return mixed
 */
function currentCurrencySymbol()
{
    $currencyID = session()->get('currency_id', config('admin.default_currency'));

    return Ayar::getCurrencySymbolById($currencyID);
}

/**
 * get logged admin user.
 *
 * @return null|\App\User|\Illuminate\Contracts\Auth\Authenticatable
 */
function loggedAdminUser()
{
    return Auth::guard('admin')->user();
}

/**
 * mevcut para birimi getirir.
 *
 * @return mixed
 */
function currentCurrencyID()
{
    return Ayar::getCurrencyId();
}

/**
 *  gönderilen para birimine göre sembol getirir.
 *
 * @param int|string $currencyID para birimi id
 *
 * @return mixed|string
 */
function getCurrencySymbolById($currencyID)
{
    return Ayar::getCurrencySymbolById($currencyID);
}

// ====== ./// CURRENCY =============

function createSlugByModelAndTitle($model, $title, $itemID)
{
    $i = 0;
    $slug = Str::slug($title);
    while ($model->all([['slug', $slug], ['id', '!=', $itemID]], ['id'])->count() > 0) {
        $slug = Str::slug($title) . '-' . $i;
        $i++;
    }

    return $slug;
}

/**
 *  create unique slug by model instance title.
 *
 * @param Eloquent $model
 * @param string   $title
 * @param int      $itemID
 *
 * @return string
 */
function createSlugFromTitleByModel($model, $title, $itemID)
{
    $i = 0;
    $slug = Str::slug($title);
    while ($model::where([['slug', $slug], ['id', '!=', $itemID]], ['id'])->count() > 0) {
        $slug = Str::slug($title) . '-' . $i;
        $i++;
    }

    return $slug;
}

function activeStatus($column = 'active')
{
    return (bool) request()->has($column);
}

/**
 * @param string      $folderPath public/categories
 * @param null|string $imageName  imageName
 */
function imageUrl(string $folderPath, $imageName = '')
{
    return Storage::url($folderPath . '/' . $imageName);
}

// ======== Session MESSAGES =============

function success($message = null)
{
    $message = $message ?: __('lang.success_message');
    session()->flash('message', $message);
}

function error($message = null)
{
    $message = $message ?: __('lang.error_message');
    session()->flash('message', $message);
    session()->flash('message_type', 'danger');
}

/**
 * get value by key from admin table.
 *
 * @param null|string $value
 *
 * @return null|mixed
 */
function admin($value)
{
    if (! $value) {
        return null;
    }
    if ('file' === config('admin.config_driver')) {
        return config('admin.' . $value);
    }

    $values = explode('.', $value);
    $admin = Admin::getCache()->toArray();
    $lastVal = null;
    foreach ($values as $index => $value) {
        $lastVal = $admin[$value] ?? $lastVal[$value] ?? $admin[$value];
    }

    return $lastVal;
}

/**
 * tarih formatı.
 *
 * @param string $dateTime
 */
function createdAt($dateTime)
{
    return $dateTime->format('d/m/yy H:m');
}
