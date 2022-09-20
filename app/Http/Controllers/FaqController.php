<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        return view('main.user.faq.index', [
            'title' => 'FAQ',
        ]);
    }
}
