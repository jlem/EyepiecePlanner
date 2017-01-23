<?php

namespace EPP;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Guest implements UserInterface
{

    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return false;
    }

    /**
     * @return Collection
     */
    public function getTelescopes()
    {
        $telescopes = [];
        $telescopeData = $this->request->cookie('epp_telescope');

        if (empty($telescopeData)) {
            return collect($telescopes);
        }

        foreach($telescopeData as $key => $telescope) {
            $telescopes[$key] = (new Telescope())->fill($telescope)->setID($key);
        }

        return collect($telescopes);
    }
}