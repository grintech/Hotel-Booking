@isset($url)
    <url>
        <loc>{{ $url['url'] }}</loc>
        <lastmod>{{ $url['modified'] }}</lastmod>
        <changefreq>{{$url['frequency'] ?? 'monthly'}}</changefreq>
        <priority>{{ $url['priority'] }}</priority>
    </url>
@endisset
