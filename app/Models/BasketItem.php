<?php

namespace App\Models;

use App\Models\Product\Product;
use App\Models\Product\ProductSubAttribute;
use App\Repositories\Traits\ModelCurrencyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BasketItem extends Model
{
    use ModelCurrencyTrait;
    use SoftDeletes;

    public const STATUS_BASARISIZ = 1;
    public const STATUS_ONAY_BEKLIYOR = 3;
    public const STATUS_SIPARIS_ALINDI = 4;
    public const STATUS_HAZIRLANIYOR = 5;
    public const STATUS_HAZIRLANDI = 6;
    public const STATUS_KARGOYA_VERILDI = 7;
    public const STATUS_IADE_EDILDI = 9;
    public const STATUS_IPTAL_EDILDI = 10;
    public const STATUS_TAMAMLANDI = 11;
    public const STATUS_IADE_TALEP = 12;
    public const STATUS_KISMI_IADE = 13;

    protected $guarded = ['id'];

    public static function listStatusWithId()
    {
        return [
            // index => [id,label,can_editable]
            self::STATUS_BASARISIZ       => [self::STATUS_BASARISIZ, 'Ürün siparişi Başarısız', false],
            self::STATUS_ONAY_BEKLIYOR   => [self::STATUS_ONAY_BEKLIYOR, 'Ürün Onay Bekliyor', true],
            self::STATUS_SIPARIS_ALINDI  => [self::STATUS_SIPARIS_ALINDI, 'Ürün Onaylandı', true],
            self::STATUS_HAZIRLANIYOR    => [self::STATUS_HAZIRLANIYOR, 'Ürün Hazırlanıyor', true],
            self::STATUS_HAZIRLANDI      => [self::STATUS_HAZIRLANDI, 'Ürün Hazırlandı', true],
            self::STATUS_KARGOYA_VERILDI => [self::STATUS_KARGOYA_VERILDI, 'Ürün Kargoya Verildi', true],
            self::STATUS_IADE_EDILDI     => [self::STATUS_IADE_EDILDI, 'Ürün İade Edildi', false],
            self::STATUS_IPTAL_EDILDI    => [self::STATUS_IPTAL_EDILDI, 'Ürün İptal Edildi', false],
            self::STATUS_TAMAMLANDI      => [self::STATUS_TAMAMLANDI, 'Ürün Tamamlandı', true],
            self::STATUS_IADE_TALEP      => [self::STATUS_IADE_TALEP, 'İade Talep Edildi', false],
            self::STATUS_KISMI_IADE      => [self::STATUS_KISMI_IADE, 'Ürün Kısmen İade edildi', false],
        ];
    }

    public static function statusLabelStatic($param): string
    {
        $list = self::listStatusWithId();

        return isset($list[$param]) ? $list[$param][1] : '-';
    }

    public function statusLabel(): string
    {
        $list = self::listStatusWithId();

        return isset($list[$this->status]) ? $list[$this->status][1] : '-';
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function basket(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Basket::class, 'basket_id', 'id');
    }

    /**
     * get attribute text from sub attribute id's.
     *
     * @param null|array $subAttributeIdList
     *
     * @return string
     */
    public static function getAttributesText(?array $subAttributeIdList): string
    {
        if (! $subAttributeIdList) {
            return '';
        }
        $attributeText = '';
        foreach ($subAttributeIdList as $item) {
            $productSubAttribute = ProductSubAttribute::with('attribute')->find($item);
            $attributeText .= "{$productSubAttribute->attribute->title} : {$productSubAttribute->title} ";
        }

        return $attributeText;
    }

    /**
     * get attribute text from sub attribute id's by lang.
     *
     * @param null|array $subAttributeIdList
     *
     * @return string
     */
    public static function getAttributesTextByLang(?array $subAttributeIdList): string
    {
        if (! $subAttributeIdList) {
            return '';
        }
        $attributeText = '';
        foreach ($subAttributeIdList as $index => $item) {
            $productSubAttribute = ProductSubAttribute::with('attribute')->find($item);
            $attributeText .= "{$productSubAttribute->attribute->title_lang} : {$productSubAttribute->title_lang} ";
        }

        return $attributeText;
    }

    public function getSubTotalAttribute(): float
    {
        return $this->qty * $this->price;
    }

    public function getTotalAttribute(): float
    {
        return $this->qty * ($this->price + $this->cargo_price);
    }

    public function getCargoTotalAttribute(): float
    {
        return $this->cargo_price * $this->qty;
    }

    public function getRefundableAmountAttribute(): float
    {
        return $this->total - $this->refunded_amount;
    }
}
