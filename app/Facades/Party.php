<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Party extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'PartyService';
    }
}
