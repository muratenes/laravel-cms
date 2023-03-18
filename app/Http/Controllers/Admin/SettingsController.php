<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Repositories\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    use ImageUploadTrait;

    public function list()
    {
        return view('admin.config.list_configs', [
            'list' => Config::all(),
        ]);
    }

    public function show(int $id)
    {
        $addedLanguages = Config::all()->pluck('lang')->toArray();

        if ($id) {
            $config = Config::findOrFail($id);
        } else {
            $config = new Config();
        }

        return view('admin.config.newOrEditConfigForm', compact('config', 'addedLanguages'));
    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save(Request $request, int $id = 0)
    {
        $data = $this->validateRequest($request);
        $data['active'] = activeStatus();
        $sameLangConfig = Config::where('lang', $data['lang'])->where('id', '!=', $id)->first();

        if ($sameLangConfig) {
            $sameLangConfig->update($data);
            success();

            return redirect(route('admin.config.show', $sameLangConfig->id));
        }
        if ($id) {
            $entry = Config::find($id);
            $entry->update($data);
        } else {
            $entry = Config::create($data);
        }

        if ($entry) {
            $imageTitle = "{$entry->title}-{$entry->lang}";
            $logo = $this->uploadImage($request->file('logo'), "{$imageTitle}-logo", 'public/config', $entry->logo);
            $footer_logo = $this->uploadImage($request->file('footer_logo'), "{$imageTitle}-footer-logo", 'public/config', $entry->footer_logo);
            $icon = $this->uploadImage($request->file('icon'), "{$imageTitle}-icon", 'public/config', $entry->icon);
            $entry->update([
                'icon'        => $icon,
                'footer_logo' => $footer_logo,
                'logo'        => $logo,
            ]);
            Config::setCache($entry, $entry->lang);
        }

        return redirect(route('admin.config.show', $entry->id))->with('message', 'güncellendi');
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'title'               => 'required|max:100',
            'desc'                => 'nullable|max:500',
            'domain'              => 'nullable|max:50',
            'keywords'            => 'nullable|max:255',
            'facebook'            => 'nullable|max:255',
            'twitter'             => 'nullable|max:255',
            'instagram'           => 'nullable|max:255',
            'youtube'             => 'nullable|max:255',
            'footer_text'         => 'nullable|max:255',
            'phone'               => 'nullable|max:50',
            'phone_2'             => 'nullable|max:50',
            'email'               => 'nullable|max:50',
            'email_2'             => 'nullable|max:50',
            'address'             => 'nullable|max:255',
            'address_2'           => 'nullable|max:255',
            'about'               => 'nullable',
            'cargo_price'         => 'nullable',
            'full_name'           => 'nullable|max:100',
            'company_address'     => 'nullable|max:250',
            'company_phone'       => 'nullable|max:50',
            'fax'                 => 'nullable|max:255',
            'lang'                => 'nullable|numeric',
        ]);
    }
}
