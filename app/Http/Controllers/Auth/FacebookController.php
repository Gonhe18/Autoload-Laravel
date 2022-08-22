<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\OAuthLoginTraits;

class FacebookController extends Controller
{
    use OAuthLoginTraits;

    public function driverType(): string
    {
        return 'facebook';
    }
}