<?php

namespace App\Models;

use App\Models\Product\Urun;
use App\Models\Product\UrunAttribute;
use App\Models\Product\UrunSubAttribute;
use App\Repositories\Traits\ModelCurrencyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SepetUrun extends Model
{
    use  SoftDeletes;
    use ModelCurrencyTrait;

    protected $table = "sepet_urun";
    protected $guarded = ['id'];


    const STATUS_BASARISIZ = 1;
    const STATUS_ONAY_BEKLIYOR = 3;
    const STATUS_SIPARIS_ALINDI = 4;
    const STATUS_HAZIRLANIYOR = 5;
    const STATUS_HAZIRLANDI = 6;
    const STATUS_KARGOYA_VERILDI = 7;
    const STATUS_IADE_EDILDI = 9;
    const STATUS_IPTAL_EDILDI = 10;
    const STATUS_TAMAMLANDI = 11;
    const STATUS_IADE_TALEP = 12;
    const STATUS_KISMI_IADE = 13;


    public static function listStatusWithId()
    {
        return [
            // index => [id,label,can_editable]
            self::STATUS_BASARISIZ => [SepetUrun::STATUS_BASARISIZ, "Ürün siparişi Başarısız", false],
            self::STATUS_ONAY_BEKLIYOR => [SepetUrun::STATUS_ONAY_BEKLIYOR, "Ürün Onay Bekliyor", true],
            self::STATUS_SIPARIS_ALINDI => [SepetUrun::STATUS_SIPARIS_ALINDI, "Ürün Onaylandı", true],
            self::STATUS_HAZIRLANIYOR => [SepetUrun::STATUS_HAZIRLANIYOR, "Ürün Hazırlanıyor", true],
            self::STATUS_HAZIRLANDI => [SepetUrun::STATUS_HAZIRLANDI, "Ürün Hazırlandı", true],
            self::STATUS_KARGOYA_VERILDI => [SepetUrun::STATUS_KARGOYA_VERILDI, "Ürün Kargoya Verildi", true],
            self::STATUS_IADE_EDILDI => [SepetUrun::STATUS_IADE_EDILDI, "Ürün İade Edildi", false],
            self::STATUS_IPTAL_EDILDI => [SepetUrun::STATUS_IPTAL_EDILDI, "Ürün İptal Edildi", false],
            self::STATUS_TAMAMLANDI => [SepetUrun::STATUS_TAMAMLANDI, "Ürün Tamamlandı", true],
            self::STATUS_IADE_TALEP => [SepetUrun::STATUS_IADE_TALEP, "İade Talep Edildi", false],
            self::STATUS_KISMI_IADE => [SepetUrun::STATUS_KISMI_IADE, "Ürün Kısmen İade edildi", false],
        ];
    }

    public static function statusLabelStatic($param)
    {
        $list = SepetUrun::listStatusWithId();
        return isset($list[$param]) ? $list[$param][1] : '-';
    }

    public function statusLabel()
    {
        $list = self::listStatusWithId();
        return isset($list[$this->status]) ? $list[$this->status][1] : '-';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Urun::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function basket()
    {
        return $this->belongsTo(Sepet::class, 'sepet_id', 'id');
    }


    /**
     * Sepette oluşturulacak ürünün attributes_text değerini getirir
     * @param array|null $subAttributeIdList
     * @return string
     */
    public static function getAttributesText(?array $subAttributeIdList)
    {
        if (!$subAttributeIdList) return '';
        $attributeText = '';
        foreach ($subAttributeIdList as $index => $item) {
            $productSubAttribute = UrunSubAttribute::with('attribute')->find($item);
            $attributeText .= "{$productSubAttribute->attribute->title} : {$productSubAttribute->title} ";
        }

        return $attributeText;
    }

    /**
     * Sepette oluşturulacak ürünün attributes_text değerini getirir
     * @param int $langID seçili dil ID
     * @param array|null $subAttributeIdList
     * @return string
     */
    public static function getAttributesTextByLang($langID, ?array $subAttributeIdList)
    {
        if (!$subAttributeIdList) return '';
        $attributeText = '';
        foreach ($subAttributeIdList as $index => $item) {
            $productSubAttribute = UrunSubAttribute::with('attribute')->find($item);
            $attributeText .= "{$productSubAttribute->attribute->title_lang} : {$productSubAttribute->title_lang} ";
        }

        return $attributeText;
    }


    /**
     * sepetteki ürünün adet ile hesaplanmış son hali getirir
     */
    public function getSubTotalAttribute()
    {
        return $this->qty * $this->price;
    }

    /**
     * sepetteki ürünün kargo ve adet ile hesaplanmış son hali getirir
     */
    public function getTotalAttribute()
    {
        return $this->qty * ($this->price + $this->cargo_price);
    }

    /**
     * sepetteki ürünün kargo toplam fiyatını belirler.
     */
    public function getCargoTotalAttribute()
    {
        return $this->cargo_price * $this->qty;
    }

    /**
     * iade edilebilir tutar
     * @return float
     */
    public function getRefundableAmountAttribute()
    {
        return $this->total - $this->refunded_amount;
    }
}
