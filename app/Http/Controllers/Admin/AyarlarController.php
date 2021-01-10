<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ayar;
use App\Repositories\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AyarlarController extends Controller
{
    use ImageUploadTrait;


    public function list()
    {
        return view('admin.config.list_configs', [
            'list' => Ayar::all()
        ]);
    }

    public function show($id)
    {
        $addedLanguages = Ayar::all()->pluck('lang')->toArray();

        if ($id) {
            $config = Ayar::findOrFail($id);
        } else {
            $config = new Ayar();
        }

        return view('admin.config.newOrEditConfigForm', compact('config', 'addedLanguages'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save(Request $request, $id = 0)
    {
        $data = $request->only('title', 'desc', 'domain', 'keywords', 'facebook', 'instagram',
            'twitter', 'instagram', 'youtube', 'footer_text', 'phone', 'mail',
            'adres', 'cargo_price', 'about',
            'full_name', 'company_address', 'company_phone', 'fax', 'lang'
        );
        $sameLangConfig = Ayar::where('lang', $data['lang'])->where('id', '!=', $id)->first();

        if ($sameLangConfig) {
            error('Seçilen  dilde bir ayar  mevcut lütfen farklı dil seçmeyi deneyiniz');
            return back()->withInput();
        }
        if ($id) {
            $entry = Ayar::find($id);
            $entry->update($data);
        } else {
            if ($sameLangConfig) {
                $sameLangConfig->update($data);
                $entry = $sameLangConfig;
                error('Aynı dilde ayarlar olduğu için bu bilger ile güncellendi');
            } else {
                $entry = Ayar::create($data);
            }
        }

        if ($entry) {
            $imageTitle = "{$entry->title}-{$entry->lang}";
            $logo = $this->uploadImage($request->file('logo'), "$imageTitle-logo", 'public/config', $entry->logo);
            $footer_logo = $this->uploadImage($request->file('footer_logo'), "$imageTitle-footer-logo", 'public/config', $entry->footer_logo);
            $icon = $this->uploadImage($request->file('icon'), "$imageTitle-icon", 'public/config', $entry->icon);
            $entry->update([
                'icon' => $icon,
                'footer_logo' => $footer_logo,
                'logo' => $logo
            ]);
            Ayar::setCache($entry, $entry->lang);
        }
        return redirect(route('admin.config.show', $entry->id))->with('message', 'güncellendi');
    }

}
