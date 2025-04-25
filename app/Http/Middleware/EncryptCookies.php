<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;
use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;
use HP;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
    */
    protected $except = [];

    public function __construct(EncrypterContract $encrypter)
    {

        $this->encrypter = $encrypter;
 
        //ไม่ต้องเข้ารหัส cookie session login
        $config = HP::getConfig();
        // dd($config);
        $this->except = [$config->sso_name_cookie_login];
    }
    
}
