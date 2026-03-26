<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (str_starts_with($request->path(), 'livewire')) {
            return $next($request);
        }
        if ($request->is('login') || $request->is('logout') || $request->is('register')) {
            return $next($request);
        }
        // Verifica se o primeiro segmento da URL é um idioma válido
        $locale = $request->segment(1);
        URL::defaults(['locale' => $request->segment(1)]);

        // Define os idiomas suportados
        $supportedLocales = ['en', 'pt'];

        // Se o idioma for suportado, define o locale da aplicação
        if (in_array($locale, $supportedLocales)) {
            app()->setLocale($locale);
        } else {
            // Se o idioma não for suportado, redireciona para o idioma padrão (por exemplo, 'en')
            return redirect()->to('pt/' . $request->path());
        }

        return $next($request);
    }
}
