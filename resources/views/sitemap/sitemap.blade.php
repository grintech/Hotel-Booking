<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @if(count($data) > 0)
        @foreach($data as $url)
            @include('sitemap.url' , [ 'url' => $url ])
        @endforeach
    @endif
</urlset>
