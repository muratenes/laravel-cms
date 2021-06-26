<?php

namespace App\Http\Middleware;

use Closure;

class CheckModuleActive
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // todo : module status olayı kontrol edilecek
//        $moduleConfigName = $this->_getModuleConfigName($request);
//        $url = $request->url();
//        if (!$moduleConfigName)
//            return $next($request);
//        elseif (admin($moduleConfigName) == true || route('admin.home_page') == $url)
        return $next($request);

        return redirect(route('admin.home_page'))->withErrors('Bu modül aktif değil');
    }

    private function _getModuleConfigName($request)
    {
        $url = $request->url();

        switch ($url) {
            case $url === route('admin.banners'):
                $moduleConfigName = 'modules_status.banner';

                break;
            case $url === route('admin.sss'):
                $moduleConfigName = 'modules_status.sss';

                break;
            case $url === route('admin.products'):
                $moduleConfigName = 'modules.product';

                break;
            case $url === route('admin.product.comments.list'):
                $moduleConfigName = 'modules.product.comment';

                break;
            case $url === route('admin.product.brands.list'):
                $moduleConfigName = 'modules.product.brand';

                break;
            case $url === route('admin.categories'):
                $moduleConfigName = 'modules.product.category';

                break;
            case $url === route('admin.blog'):
                $moduleConfigName = 'modules_status.blog';

                break;
            case $url === route('admin.blog_category'):
                $moduleConfigName = 'modules.blog.use_categories';

                break;
            default:
                $moduleConfigName = null;
        }

        return $moduleConfigName;
    }
}
