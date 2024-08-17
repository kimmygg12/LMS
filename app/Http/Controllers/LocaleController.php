<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;

class LocaleController extends Controller
{
    public function set($locale)
    {
        if (in_array($locale, ['kh', 'en'])) {
            App::setLocale($locale);
            session()->put('locale', $locale);
        }

        return Redirect::back();
    }
}
