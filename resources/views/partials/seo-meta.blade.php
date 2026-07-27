@php
    $locales = ['en', 'pt'];
    $defaultLocale = 'pt';
    $segments = request()->segments();
    $pathWithoutLocale = implode('/', array_slice($segments, 1));
    $buildUrl = fn (string $locale) => url(trim($locale . '/' . $pathWithoutLocale, '/'));
@endphp
<link rel="canonical" href="{{ $buildUrl(app()->getLocale()) }}" />
@foreach ($locales as $altLocale)
    <link rel="alternate" hreflang="{{ $altLocale }}" href="{{ $buildUrl($altLocale) }}" />
@endforeach
<link rel="alternate" hreflang="x-default" href="{{ $buildUrl($defaultLocale) }}" />
