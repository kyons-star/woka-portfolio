<?php

namespace App\Http\Controllers;

use App\Support\PortfolioSchema;
use App\Support\SamplePortfolio;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('home', [
            'styles' => PortfolioSchema::STYLES,
            'sample' => SamplePortfolio::data(),
        ]);
    }
}