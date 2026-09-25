{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($staticUrls as $url)
        <url>
            <loc>{{ $url }}</loc>
            <lastmod>{{ date('Y-m-d') }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    @foreach ($posts as $post)
        <url>
            <loc>{{ route('posts.show', $post->slug) }}</loc>
            <lastmod>{{ $post->updated_at->format('Y-m-d') }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach

    @foreach ($activities as $act)
        <url>
            <loc>{{ route('activities.show', $act->slug) }}</loc>
            <lastmod>{{ $act->updated_at->format('Y-m-d') }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach

    @foreach ($events as $ev)
        <url>
            <loc>{{ route('events.show', $ev->slug) }}</loc>
            <lastmod>{{ $ev->updated_at->format('Y-m-d') }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach

    @foreach ($albums as $alb)
        <url>
            <loc>{{ route('gallery.show', $alb->slug) }}</loc>
            <lastmod>{{ $alb->updated_at->format('Y-m-d') }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach

    @foreach ($pages as $p)
        <url>
            <loc>{{ route('pages.show', $p->slug) }}</loc>
            <lastmod>{{ $p->updated_at->format('Y-m-d') }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.5</priority>
        </url>
    @endforeach
</urlset>
