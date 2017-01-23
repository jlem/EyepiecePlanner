<?php

namespace EPP;

use EPP\Http\Validators\TelescopeValidator;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TelescopeService
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var CookieJar
     */
    private $cookieJar;

    public function __construct(Request $request, CookieJar $cookieJar)
    {
        $this->request = $request;
        $this->cookieJar = $cookieJar;
    }

    public function hasTelescopesInCookies()
    {
        return !empty($this->request->hasCookie('epp_telescope'));
    }

    public function getTelescopesFromCookies()
    {
        return $this->request->cookie('epp_telescope');
    }

    public function saveCookieTelescopesToDatabase()
    {
        if (Auth::check() && $this->hasTelescopesInCookies()) {
            $telescopes = $this->getTelescopesFromCookies();

            foreach($telescopes as $telescope) {
                $validator = TelescopeValidator::make($telescope);
                if ($validator->passes()) {
                    Auth::user()->telescopes()->create($telescope);
                }
            }

            $this->cookieJar->queue($this->cookieJar->forget('epp_telescope'));
        }
    }

    public function findTelescope($id)
    {
        $telescope = Telescope::find($id);

        if (!$telescope) {
            $telescopes = $this->getTelescopesFromCookies();

            if (array_key_exists($id, $telescopes)) {
                return $telescopes[$id];
            }
        }
    }
}