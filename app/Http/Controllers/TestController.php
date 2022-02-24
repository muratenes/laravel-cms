<?php

namespace App\Http\Controllers;

use App\Models\Ayar;
use App\Models\Blog;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $blog = Blog::first();
        $langs = $blog->languages;
        $blog->languages()->first()->update([
            'lang_id'           => Ayar::LANG_EN,
            'languageable_id'   => $blog->id,
            'languageable_type' => Blog::class,
            'data'              => $blog,
        ]);
        dd($langs);
    }
}
