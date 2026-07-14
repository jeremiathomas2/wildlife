@php
    echo '<' . '?xml version="1.0" encoding="UTF-8"?>';
@endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    <!-- Homepage -->
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- Destinations Page -->
    <url>
        <loc>{{ url('/destinations') }}</loc>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>

    <!-- About Page -->
    <url>
        <loc>{{ url('/about') }}</loc>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>

    <!-- Reviews Page -->
    <url>
        <loc>{{ url('/reviews') }}</loc>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>

    <!-- Gallery Page -->
    <url>
        <loc>{{ url('/gallery') }}</loc>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <!-- Contact Page -->
    <url>
        <loc>{{ url('/contact') }}</loc>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>

    <!-- Terms Page -->
    <url>
        <loc>{{ url('/terms') }}</loc>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.6</priority>
    </url>

    <!-- Privacy Page -->
    <url>
        <loc>{{ url('/privacy') }}</loc>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.6</priority>
    </url>

    <!-- Destination Detail Pages -->
    @foreach($destinations as $destination)
    <url>
        <loc>{{ route('destination.detail', $destination->slug ?? \Illuminate\Support\Str::slug($destination->name)) }}</loc>
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