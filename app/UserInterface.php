<?php

namespace EPP;

interface UserInterface
{
    /**
     * @return bool
     */
    public function isAdmin();

    /**
     * @return array
     */
    public function getTelescopes();
}