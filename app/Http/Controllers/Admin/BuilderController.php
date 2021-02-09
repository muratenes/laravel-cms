<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BuilderController extends AdminController
{
    use ResponseTrait;

    public function edit()
    {
        if (config('admin.config_driver') == 'file') {
            error('Config loaded from file,you can change from .env file');
        }
        $admin = Admin::first();
        $theme = $admin['site']['theme'];

        return view('admin.builder.edit', [
            'item' => Admin::first(),
            'currencies' => $this->currencies(),
            'themes' => array_map('basename', File::directories(resource_path('views/themes'))),
            'banners' => $theme['name'] ? array_map('basename', File::files(resource_path("views/themes/{$theme['name']}/partials/banner"))) : [],
            'headers' => $theme['name'] ? array_map('basename', File::files(resource_path("views/themes/{$theme['name']}/partials/header"))) : [],
            'footers' => $theme['name'] ? array_map('basename', File::files(resource_path("views/themes/{$theme['name']}/partials/footer"))) : [],
            'contacts' => $theme['name'] ? array_map('basename', File::files(resource_path("views/themes/{$theme['name']}/partials/contact"))) : [],
        ]);
    }

    public function save(Request $request)
    {
        $data = $request->all();
        $admin = Admin::first();
        foreach ($data['modules_status'] as $index => $status) {
            $data['modules_status'][$index] = (bool)$status;
        }
        foreach (['multi_lang', 'multi_currency', 'force_lang_currency'] as $check) {
            $data[$check] = activeStatus($check);
        }
        foreach ($data['modules'] as $index => $status) {
            foreach ($data['modules'][$index] as $subIndex => $value) {
                $isStringArray = stripos($value, "|") > 0;
                if ($this->isJson($value) && !in_array($value, [0, 1])) {
                    $data['modules'][$index][$subIndex] = json_decode($value);
                } elseif ($isStringArray) {
                    $data['modules'][$index][$subIndex] = $value;
                } elseif ($value == "on" || $value == 0) {
                    $data['modules'][$index][$subIndex] = (boolean)$value;
                } else {
                    $data['modules'][$index][$subIndex] = $value;
                }
            }
//            $data['modules'][$index] = (bool)$status;
        }
//        dd($data);
        $admin->update($data);
        success();

        return back();
    }

    /**
     * @param string $theme theme name
     * @param string $folder container folder name
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFilesByTheme($theme, $folder)
    {
        $path = implode('/', explode('.', $folder));

        try {
            return $this->success([
                'files' => array_map('basename', File::files(resource_path("views/themes/$theme/$path")))
            ]);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * @param string $theme theme name
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllFilesByTheme($theme)
    {
        try {
            return $this->success([
                'headers' => array_map('basename', File::files(resource_path("views/themes/$theme/partials/header"))),
                'banners' => array_map('basename', File::files(resource_path("views/themes/$theme/partials/banner"))),
                'footers' => array_map('basename', File::files(resource_path("views/themes/$theme/partials/footer"))),
                'contacts' => array_map('basename', File::files(resource_path("views/themes/$theme/partials/contact"))),
            ]);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    private function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
