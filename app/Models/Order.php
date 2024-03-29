<?php

namespace App\Models;

use App\Repositories\Traits\ModelCurrencyTrait;
use App\Utils\Concerns\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use Filterable;
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
    public const STATUS_ODEME_ALINAMADI = 12;
    public const STATUS_3D_BASLATILDI = 13;

    protected $perPage = 20;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'snapshot' => 'array',
    ];

    protected $appends = [
        'code',
        'status_label',
    ];

    public function scopeGetOrderCountByStatus($query, $status_type)
    {
        return $query->where('status', $status_type)->count();
    }

    public function statusLabel(): string
    {
        $list = self::listStatusWithId();

        return $list[$this->status][1] ?? '-';
    }

    public static function statusLabelStatic($param): string
    {
        $list = self::listStatusWithId();

        return $list[$param][1] ?? '-';
    }

    public function basket(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Basket::class, 'basket_id');
    }


    public function cargo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cargo::class);
    }

    public function iyzico(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Iyzico::class, 'siparis_id', 'id')->withDefault();
    }


    public function delivery_address(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UserAddress::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice_address()
    {
        return $this->belongsTo(UserAddress::class);
    }

    public static function listStatusWithId()
    {
        return [
            // value => [ value,label,can_editable]
            self::STATUS_BASARISIZ => [self::STATUS_BASARISIZ, 'Sipariş Başarısız', false],
            self::STATUS_ONAY_BEKLIYOR => [self::STATUS_ONAY_BEKLIYOR, 'Sipariş Onay Bekliyor', true],
            self::STATUS_SIPARIS_ALINDI => [self::STATUS_SIPARIS_ALINDI, 'Sipariş Alındı', true],
            self::STATUS_HAZIRLANIYOR => [self::STATUS_HAZIRLANIYOR, 'Sipariş Hazırlanıyor', true],
            self::STATUS_HAZIRLANDI => [self::STATUS_HAZIRLANDI, 'Sipariş Hazırlandı', true],
            self::STATUS_KARGOYA_VERILDI => [self::STATUS_KARGOYA_VERILDI, 'Sipariş Kargoya Verildi', true],
            self::STATUS_IADE_EDILDI => [self::STATUS_IADE_EDILDI, 'Sipariş İade Edildi', false],
            self::STATUS_IPTAL_EDILDI => [self::STATUS_IPTAL_EDILDI, 'Sipariş İptal Edildi', false],
            self::STATUS_TAMAMLANDI => [self::STATUS_TAMAMLANDI, 'Sipariş Tamamlandı', true],
            self::STATUS_ODEME_ALINAMADI => [self::STATUS_ODEME_ALINAMADI, 'Ödeme İşlemi Sırasında hata oluştu', false],
            self::STATUS_3D_BASLATILDI => [self::STATUS_3D_BASLATILDI, '3d Onayı Bekliyor', false],
        ];
    }

    public function getCodeAttribute(): string
    {
        return "SP-{$this->id}";
    }

    public function notify($notification)
    {
        return $this->basket->user->notify($notification);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::listStatusWithId()[$this->status][1] ?? '-';
    }
}
