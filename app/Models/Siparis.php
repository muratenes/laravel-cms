<?php

namespace App\Models;

use App\Repositories\Traits\ModelCurrencyTrait;
use App\Utils\Concerns\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siparis extends Model
{
    use  SoftDeletes;
    use ModelCurrencyTrait;
    use Filterable;

    protected $table = "siparisler";
    protected $perPage = 20;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'snapshot' => 'array'
    ];

    protected $appends = [
        'code',
        'status_label'
    ];

    const STATUS_BASARISIZ = 1;
    const STATUS_ONAY_BEKLIYOR = 3;
    const STATUS_SIPARIS_ALINDI = 4;
    const STATUS_HAZIRLANIYOR = 5;
    const STATUS_HAZIRLANDI = 6;
    const STATUS_KARGOYA_VERILDI = 7;
    const STATUS_IADE_EDILDI = 9;
    const STATUS_IPTAL_EDILDI = 10;
    const STATUS_TAMAMLANDI = 11;
    const STATUS_ODEME_ALINAMADI = 12;
    const STATUS_3D_BASLATILDI = 13;


    public function scopeGetOrderCountByStatus($query, $status_type)
    {
        return $query->where('status', $status_type)->count();
    }


    public function statusLabel()
    {
        $list = self::listStatusWithId();
        return $list[$this->status][1] ?? '-';
    }

    public static function statusLabelStatic($param)
    {
        $list = Siparis::listStatusWithId();
        return $list[$param][1] ?? '-';
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function basket()
    {
        return $this->belongsTo(Sepet::class, 'sepet_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function iyzico()
    {
        return $this->hasOne(Iyzico::class, 'siparis_id', 'id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function delivery_address()
    {
        return $this->belongsTo(KullaniciAdres::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice_address()
    {
        return $this->belongsTo(KullaniciAdres::class);
    }


    public static function listStatusWithId()
    {
        return [
            // value => [ value,label,can_editable]
            self::STATUS_BASARISIZ => [Siparis::STATUS_BASARISIZ, "Sipariş Başarısız", false],
            self::STATUS_ONAY_BEKLIYOR => [Siparis::STATUS_ONAY_BEKLIYOR, "Sipariş Onay Bekliyor", true],
            self::STATUS_SIPARIS_ALINDI => [Siparis::STATUS_SIPARIS_ALINDI, "Sipariş Alındı", true],
            self::STATUS_HAZIRLANIYOR => [Siparis::STATUS_HAZIRLANIYOR, "Sipariş Hazırlanıyor", true],
            self::STATUS_HAZIRLANDI => [Siparis::STATUS_HAZIRLANDI, "Sipariş Hazırlandı", true],
            self::STATUS_KARGOYA_VERILDI => [Siparis::STATUS_KARGOYA_VERILDI, "Sipariş Kargoya Verildi", true],
            self::STATUS_IADE_EDILDI => [Siparis::STATUS_IADE_EDILDI, "Sipariş İade Edildi", false],
            self::STATUS_IPTAL_EDILDI => [Siparis::STATUS_IPTAL_EDILDI, "Sipariş İptal Edildi", false],
            self::STATUS_TAMAMLANDI => [Siparis::STATUS_TAMAMLANDI, "Sipariş Tamamlandı", true],
            self::STATUS_ODEME_ALINAMADI => [Siparis::STATUS_ODEME_ALINAMADI, "Ödeme İşlemi Sırasında hata oluştu", false],
            self::STATUS_3D_BASLATILDI => [Siparis::STATUS_3D_BASLATILDI, "3d Onayı Bekliyor", false],

        ];
    }


    /**
     * sipariş kodu için kullanılır
     * @return string
     */
    public function getCodeAttribute()
    {
        return "SP-$this->id";
    }

    /**
     *
     * @param $notification
     */
    public function notify($notification)
    {
        return $this->basket->user->notify($notification);
    }

    /**
     * @return mixed|string
     */
    public function getStatusLabelAttribute()
    {
        return self::listStatusWithId()[$this->status][1] ?? '-';
    }

}
