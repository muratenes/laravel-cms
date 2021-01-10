<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ $now }}</lastmod>
        <changefreq>Daily</changefreq>
        <priority>0.8</priority>
    </url>
    @foreach($categories as $cat)
        <url>
            <loc> {{ route('product.detail',$cat->slug) }}</loc>
            <lastmod>{{ $now }}</lastmod>
            <changefreq>Daily</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach
    @foreach($products as $product)
        <url>
            <loc> {{ route('product.detail',$product->slug) }}</loc>
            <lastmod>{{ $product->created_at->toAtomString() }}</lastmod>
            <changefreq>Daily</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>
