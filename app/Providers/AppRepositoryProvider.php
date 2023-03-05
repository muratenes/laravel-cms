<?php

namespace App\Providers;

use App\Repositories\Concrete\Eloquent\ElAccountDal;
use App\Repositories\Concrete\Eloquent\ElBannerDal;
use App\Repositories\Concrete\Eloquent\ElBasketDal;
use App\Repositories\Concrete\Eloquent\ElBlogDal;
use App\Repositories\Concrete\Eloquent\ElCampaignDal;
use App\Repositories\Concrete\Eloquent\ElCategoryDal;
use App\Repositories\Concrete\Eloquent\ElCityTownDal;
use App\Repositories\Concrete\Eloquent\ElContentDal;
use App\Repositories\Concrete\Eloquent\ElCouponDal;
use App\Repositories\Concrete\Eloquent\ElEBultenDal;
use App\Repositories\Concrete\Eloquent\ElFAQDal;
use App\Repositories\Concrete\Eloquent\ElGalleryDal;
use App\Repositories\Concrete\Eloquent\ElLogDal;
use App\Repositories\Concrete\Eloquent\ElOrderDal;
use App\Repositories\Concrete\Eloquent\ElOurTeamDal;
use App\Repositories\Concrete\Eloquent\ElPaymentDal;
use App\Repositories\Concrete\Eloquent\ElProductAttributeDal;
use App\Repositories\Concrete\Eloquent\ElProductBrandDal;
use App\Repositories\Concrete\Eloquent\ElProductCommentDal;
use App\Repositories\Concrete\Eloquent\ElProductCompanyDal;
use App\Repositories\Concrete\Eloquent\ElProductsDal;
use App\Repositories\Concrete\Eloquent\ElReferenceDal;
use App\Repositories\Concrete\Eloquent\ElUserDal;
use App\Repositories\Interfaces\AccountInterface;
use App\Repositories\Interfaces\BannerInterface;
use App\Repositories\Interfaces\BasketInterface;
use App\Repositories\Interfaces\BlogInterface;
use App\Repositories\Interfaces\CampaignInterface;
use App\Repositories\Interfaces\CategoryInterface;
use App\Repositories\Interfaces\CityTownInterface;
use App\Repositories\Interfaces\ContentInterface;
use App\Repositories\Interfaces\CouponInterface;
use App\Repositories\Interfaces\EBultenInterface;
use App\Repositories\Interfaces\GalleryInterface;
use App\Repositories\Interfaces\LogInterface;
use App\Repositories\Interfaces\OrderInterface;
use App\Repositories\Interfaces\OurTeamInterface;
use App\Repositories\Interfaces\PaymentInterface;
use App\Repositories\Interfaces\ProductAttributeInterface;
use App\Repositories\Interfaces\ProductBrandInterface;
use App\Repositories\Interfaces\ProductCommentInterface;
use App\Repositories\Interfaces\ProductCompanyInterface;
use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Interfaces\ReferenceInterface;
use App\Repositories\Interfaces\SSSInterface;
use App\Repositories\Interfaces\UserInterface;
use Illuminate\Support\ServiceProvider;

class AppRepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot()
    {
    }

    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(CategoryInterface::class, ElCategoryDal::class);
        $this->app->bind(ProductInterface::class, ElProductsDal::class);
        $this->app->bind(OrderInterface::class, ElOrderDal::class);
        $this->app->bind(LogInterface::class, ElLogDal::class);
        $this->app->bind(BasketInterface::class, ElBasketDal::class);
        $this->app->bind(PaymentInterface::class, ElPaymentDal::class);
        $this->app->bind(ProductAttributeInterface::class, ElProductAttributeDal::class);
        $this->app->bind(AccountInterface::class, ElAccountDal::class);
        $this->app->bind(CityTownInterface::class, ElCityTownDal::class);
        $this->app->bind(UserInterface::class, ElUserDal::class);
        $this->app->bind(BannerInterface::class, ElBannerDal::class);
        $this->app->bind(CouponInterface::class, ElCouponDal::class);
        $this->app->bind(CampaignInterface::class, ElCampaignDal::class);
        $this->app->bind(ProductCommentInterface::class, ElProductCommentDal::class);
        $this->app->bind(ProductBrandInterface::class, ElProductBrandDal::class);
        $this->app->bind(ProductCompanyInterface::class, ElProductCompanyDal::class);
        $this->app->bind(SSSInterface::class, ElFAQDal::class);
        $this->app->bind(ReferenceInterface::class, ElReferenceDal::class);
        $this->app->bind(GalleryInterface::class, ElGalleryDal::class);
        $this->app->bind(ContentInterface::class, ElContentDal::class);
        $this->app->bind(OurTeamInterface::class, ElOurTeamDal::class);
        $this->app->bind(EBultenInterface::class, ElEBultenDal::class);
        $this->app->bind(BlogInterface::class, ElBlogDal::class);
    }
}
