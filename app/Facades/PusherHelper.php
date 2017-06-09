<?php
namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class PusherHelper extends Facade{
    protected static function getFacadeAccessor() { return 'pusherhelper'; }
}
