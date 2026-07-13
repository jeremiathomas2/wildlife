@php header('Content-Type: text/xml'); @endphp
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    <!-- Homepage -->
    <url>
        <loc>https://www.tanzaniadailytoursandsafari.com/</loc>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    
    <!-- Destinations Page -->
    <url>
        <loc>https://www.tanzaniadailytoursandsafari.com/destinations</loc>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    
    <!-- About Page -->
    <url>
        <loc>https://www.tanzaniadailytoursandsafari.com/about</loc>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    
    <!-- Reviews Page -->
    <url>
        <loc>https://www.tanzaniadailytoursandsafari.com/reviews</loc>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    
    <!-- Gallery Page -->
    <url>
        <loc>https://www.tanzaniadailytoursandsafari.com/gallery</loc>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    
    <!-- Contact Page -->
    <url>
        <loc>https://www.tanzaniadailytoursandsafari.com/contact</loc>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    
    <!-- Terms Page -->
    <url>
        <loc>https://www.tanzaniadailytoursandsafari.com/terms</loc>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.6</priority>
    </url>
    
    <!-- Privacy Page -->
    <url>
        <loc>https://www.tanzaniadailytoursandsafari.com/privacy</loc>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.6</priority>
    </url>
    
    <!-- Destination Detail Pages -->
    @foreach($destinations as $destination)
    <url>
        <loc>{{ url('destination.detail', $destination->slug ?? \Illuminate\Support\Str::slug($destination->name)) }}</loc>
        <lastmod>{{ $destination->updated_at ? $destination->updated_at->format('Y-m-d') : now()->format('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
        @if($destination->image)
        <image:image>
            <image:loc>{{ $destination->image }}</image:loc>
            <image:title>{{ $destination->name }}</image:title>
            <image:caption>{{ \Illuminate\Support\Str::limit(strip_tags($destination->desc ?? ''), 200) }}</image:caption>
        </image:image>
        @endif
    </url>
    @endforeach
</urlset>