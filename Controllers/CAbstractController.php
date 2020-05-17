<?php


namespace Glas\Controllers;


use Glas\Models\CUserModel;

abstract class CAbstractController
{
    protected $currentUser;

    public function __construct(CUserModel $currentUser) {
        $this->currentUser = $currentUser;
    }
}