<?php

namespace App\Http\Middleware;

use Closure;

class CheckModuleActive
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $moduleConfigName = $this->_getModuleConfigName($request);
        $url = $request->url();
        if (!$moduleConfigName)
            return $next($request);
        elseif (config('admin.' . $moduleConfigName) == true || route('admin.home_page') == $url)
            return $next($request);
        return redirect(route('admin.home_page'))->withErrors('Bu modül aktif değil');
    }

    private function _getModuleConfigName($request)
    {
        $url = $request->url();

        switch ($url) {
            case $url == route('admin.banners');
                $moduleConfigName = 'module_status.banner';
                break;
            case $url == route('admin.sss');
                $moduleConfigName = 'module_status.sss';
                break;
            case $url == route('admin.products');
                $moduleConfigName = 'module_status.product';
                break;
            case $url == route('admin.product.comments.list');
                $moduleConfigName = 'product.use_comment';
                break;
            case $url == route('admin.product.brands.list');
                $moduleConfigName = 'product.use_brand';
                break;
            case $url == route('admin.categories');
                $moduleConfigName = 'product.use_category';
                break;
            case $url == route('admin.blog');
                $moduleConfigName = 'module_status.blog';
                break;
            case $url == route('admin.blog_category');
                $moduleConfigName = 'blog.use_categories';
                break;
            default;
                $moduleConfigName = null;

        }
        return $moduleConfigName;
    }
}
