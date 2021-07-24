<?php 

namespace Synder\Redirects\Middleware;

use Closure;
use Illuminate\Http\Request;
use Synder\Redirects\Models\Settings;

class RedirectsMiddleware
{
    /**
     * Redirection is External
     * 
     * @var bool
     */
    protected $isExternal = false;

    /**
     * Final Redirect Status
     * 
     * @var int
     */
    protected $finalStatus = 0;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $url = $uri = $request->getUri();
        $path = explode('?', $request->getRequestUri())[0];

        $this->checkRedirect($url, $path);
        $this->checkHostname($url, $path);
        $this->checkHttpsSSL($url, $path);

        if ($uri !== $url && $this->finalStatus !== 0) {
            return redirect($url, $this->finalStatus, [], strpos($url, 'https') === 0);
        } else {
            return $next($request);
        }
    }

    /**
     * Check Custom Redirects
     *
     * @param string $url
     * @param string $path
     * @return void
     */
    protected function checkRedirect(&$url, $path)
    {
        $redirects = Settings::get('custom_redirects');
        if (empty($redirects) || !is_array($redirects)) {
            return;
        }

        $skip = array_key_exists('noRedirect', $_GET);
        $origin = parse_url($url, \PHP_URL_HOST);

        foreach ($redirects AS $data) {
            if (strtolower($data['source']) !== strtolower($path)) {
                continue;
            }
            if ($skip && $data['get_mode'] === '1') {
                continue;
            }

            $url = $data['destination'];
            $this->finalStatus = $data['status_code'];
            break;
        }

        // Set External Host
        if ($this->finalStatus !== 0) {
            $this->isExternal = parse_url($url, \PHP_URL_HOST) !== $origin;
        }
    }

    /**
     * Check (Non-)WWW Location
     *
     * @param string $url
     * @param string $path
     * @return void
     */
    protected function checkHostname(&$url, $path)
    {
        if ($this->isExternal) {
            return;
        }
        if (Settings::get('www_force') === '0') {
            return;
        }

        // Force Non-WWW Hostname
        if (($offset = strpos($url, '://www.')) !== false) {
            if (Settings::get('www_mode') === '1') {
                $url = substr($url, 0, $offset) . '://' . substr($url, $offset+7);
                $this->finalStatus = Settings::get('www_status_code');
            }
            return;
        }

        // Force WWW Hostname
        if (Settings::get('www_mode') === '0') {
            $url = str_replace('://', '://www.', $url);
            $this->finalStatus = Settings::get('www_status_code');
        }
    }

    /**
     * Check HTTPS Location
     *
     * @param string $url
     * @param string $path
     * @return void
     */
    protected function checkHttpsSSL(&$url, $path)
    {
        if ($this->isExternal) {
            return;
        }
        if (Settings::get('https_force') === '0' || strpos($url, 'https') === 0) {
            return;
        }
        if (Settings::get('http_get_mode') === '1' && array_key_exists('noSSL', $_GET)) {
            return;
        }

        // Force HTTPs
        $url = 'https' . substr($url, 4);
        $this->finalStatus = Settings::get('https_status_code');
    }
}
