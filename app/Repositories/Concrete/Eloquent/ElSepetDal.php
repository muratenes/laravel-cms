<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Product\Urun;
use App\Models\Product\UrunVariant;
use App\Models\Sepet;
use App\Models\SepetUrun;
use App\Models\Siparis;
use App\Repositories\Concrete\ElBaseRepository;
use App\Repositories\Interfaces\SepetInterface;

class ElSepetDal implements SepetInterface
{
    protected $model;

    public function __construct(Sepet $model)
    {
        $this->model = app()->makeWith(ElBaseRepository::class, ['model' => $model]);
    }

    public function all($filter = null, $columns = ['*'], $relations = null)
    {
        return $this->model->all($filter, $columns, $relations)->get();
    }

    public function allWithPagination($filter = null, $columns = ['*'], $perPageItem = null, $relations = null)
    {
    }

    public function getById($id, $columns = ['*'], $relations = null)
    {
        return $this->model->getById($id, $columns, $relations);
    }

    public function getByColumn(string $field, $value, $columns = ['*'], $relations = null)
    {
        return $this->model->getByColumn($field, $value, $columns, $relations);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->update($data, $id);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }

    public function with($relations, $filter = null, bool $paginate = null, int $perPageItem = null)
    {
        return $this->model->with($relations, $filter, $paginate, $perPageItem);
    }

    /**
     *  Parametre olarak gönderilen $checkedQty $subAttributesIdList göre Ürün varyantlarında stok durumu kontrol edilir
     * sonra kullanıcının sepetinde bu üründen kaç adet var ve stokda kaç tane var kontrol edilir
     * eğer $checkedQty $maxQty den büyükse   $checkedQty = $maxQty  değeri atanır ve max o adet kadar ekleyebilir veya silebilir
     * kullanıcı sepete eklediği ürün sayısınndan az bir sayı gönderdiyse eksi olarak geri döner örn 4 ürün varken 3 gönderirse -1 döner.
     *
     * @param $productId   Ürün id
     * @param $checkedQty kontrol edilecek ürün adedi
     * @param $subAttributesIdList ürün varyant alt özellik id leri
     * @param mixed $qty
     *
     * @return $checkedQty
     */
    public function checkProductQtyCountCanAddToBasketItemCount($productId, $qty, $subAttributesIdList = null)
    {
        $variant = UrunVariant::urunHasVariant($productId, $subAttributesIdList);
        $product = Urun::findOrFail($productId);
        $maxQty = $product->qty;
        if (false !== $variant) {
            $maxQty = $variant->qty;
        }
        $search = Cart::search(function ($key, $value) use ($product, $subAttributesIdList) {
            return $key->id === $product->id && $key->options->selectedSubAttributesIdList === $subAttributesIdList;
        })->first();
        null !== $search ?: null;
        if (null !== $search) {
            $maxQty = $maxQty - $search->qty;
            0 !== $qty ? $qty -= $search->qty : null;
        }
        if ($qty > $maxQty) {
            $qty = $maxQty;
        }

        return $qty;
    }

    public function cancelBasketItems(Siparis $order)
    {
        $basketItems = SepetUrun::withTrashed()->where('sepet_id', $order->sepet_id)->get();
        foreach ($basketItems as $basketItem) {
            $basketItem->update(['status' => SepetUrun::STATUS_IPTAL_EDILDI, 'refunded_amount' => $basketItem->total]);
        }
    }
}
