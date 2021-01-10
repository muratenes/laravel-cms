<?php

namespace App\Providers;

use App\Repositories\Concrete\Eloquent\ElAccountDal;
use App\Repositories\Concrete\Eloquent\ElAracMarkaDal;
use App\Repositories\Concrete\Eloquent\ElAyarlarDal;
use App\Repositories\Concrete\Eloquent\ElBannerDal;
use App\Repositories\Concrete\Eloquent\ElBlogDal;
use App\Repositories\Concrete\Eloquent\ElCityTownDal;
use App\Repositories\Concrete\Eloquent\ElEBultenDal;
use App\Repositories\Concrete\Eloquent\ElFavorilerDal;
use App\Repositories\Concrete\Eloquent\ElFotoGalleryDal;
use App\Repositories\Concrete\Eloquent\ElIcerikYonetimDal;
use App\Repositories\Concrete\Eloquent\ElKampanyaDal;
use App\Repositories\Concrete\Eloquent\ElKategoriDal;
use App\Repositories\Concrete\Eloquent\ElKullaniciDal;
use App\Repositories\Concrete\Eloquent\ElKuponDal;
use App\Repositories\Concrete\Eloquent\ElLogDal;
use App\Repositories\Concrete\Eloquent\ElOdemeDal;
use App\Repositories\Concrete\Eloquent\ElOurTeamDal;
use App\Repositories\Concrete\Eloquent\ElReferenceDal;
use App\Repositories\Concrete\Eloquent\ElSepetDal;
use App\Repositories\Concrete\Eloquent\ElSiparisDal;
use App\Repositories\Concrete\Eloquent\ElSSSDal;
use App\Repositories\Concrete\Eloquent\ElUrunFirmaDal;
use App\Repositories\Concrete\Eloquent\ElUrunlerDal;
use App\Repositories\Concrete\Eloquent\ElUrunMarkaDal;
use App\Repositories\Concrete\Eloquent\ElUrunOzellikDal;
use App\Repositories\Concrete\Eloquent\ElUrunYorumDal;
use App\Repositories\Interfaces\AccountInterface;
use App\Repositories\Interfaces\AracMarkaInterface;
use App\Repositories\Interfaces\AyarlarInterface;
use App\Repositories\Interfaces\BannerInterface;
use App\Repositories\Interfaces\BlogInterface;
use App\Repositories\Interfaces\CityTownInterface;
use App\Repositories\Interfaces\EBultenInterface;
use App\Repositories\Interfaces\FavorilerInterface;
use App\Repositories\Interfaces\FotoGalleryInterface;
use App\Repositories\Interfaces\IcerikYonetimInterface;
use App\Repositories\Interfaces\KampanyaInterface;
use App\Repositories\Interfaces\KategoriInterface;
use App\Repositories\Interfaces\KullaniciInterface;
use App\Repositories\Interfaces\KuponInterface;
use App\Repositories\Interfaces\LogInterface;
use App\Repositories\Interfaces\OdemeInterface;
use App\Repositories\Interfaces\OurTeamInterface;
use App\Repositories\Interfaces\ReferenceInterface;
use App\Repositories\Interfaces\SepetInterface;
use App\Repositories\Interfaces\SiparisInterface;
use App\Repositories\Interfaces\SSSInterface;
use App\Repositories\Interfaces\UrunFirmaInterface;
use App\Repositories\Interfaces\UrunlerInterface;
use App\Repositories\Interfaces\UrunMarkaInterface;
use App\Repositories\Interfaces\UrunOzellikInterface;
use App\Repositories\Interfaces\UrunYorumInterface;
use Illuminate\Support\ServiceProvider;

class AppRepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AyarlarInterface::class, ElAyarlarDal::class);
        $this->app->bind(KategoriInterface::class, ElKategoriDal::class);
        $this->app->bind(UrunlerInterface::class, ElUrunlerDal::class);
        $this->app->bind(SiparisInterface::class, ElSiparisDal::class);
        $this->app->bind(LogInterface::class, ElLogDal::class);
        $this->app->bind(SepetInterface::class, ElSepetDal::class);
        $this->app->bind(OdemeInterface::class, ElOdemeDal::class);
        $this->app->bind(UrunOzellikInterface::class, ElUrunOzellikDal::class);
        $this->app->bind(AccountInterface::class, ElAccountDal::class);
        $this->app->bind(CityTownInterface::class, ElCityTownDal::class);
        $this->app->bind(KullaniciInterface::class, ElKullaniciDal::class);
        $this->app->bind(BannerInterface::class, ElBannerDal::class);
        $this->app->bind(KuponInterface::class, ElKuponDal::class);
        $this->app->bind(KampanyaInterface::class, ElKampanyaDal::class);
        $this->app->bind(UrunYorumInterface::class, ElUrunYorumDal::class);
        $this->app->bind(UrunMarkaInterface::class, ElUrunMarkaDal::class);
        $this->app->bind(UrunFirmaInterface::class, ElUrunFirmaDal::class);
        $this->app->bind(SSSInterface::class, ElSSSDal::class);
        $this->app->bind(ReferenceInterface::class, ElReferenceDal::class);
        $this->app->bind(FotoGalleryInterface::class, ElFotoGalleryDal::class);
        $this->app->bind(IcerikYonetimInterface::class, ElIcerikYonetimDal::class);
        $this->app->bind(OurTeamInterface::class, ElOurTeamDal::class);
        $this->app->bind(EBultenInterface::class, ElEBultenDal::class);
        $this->app->bind(BlogInterface::class, ElBlogDal::class);
    }
}
