<?php

namespace App\Http\Controllers;

use App\Models\Kajian;
use Illuminate\Http\Request;

class UserKajianController extends Controller
{
    public function index()
    {
        $kajians = Kajian::all();
        return view('user.kajians.index', compact('kajians'));
    }

    public function show(Kajian $kajian)
    {
        return view('user.kajians.show', compact('kajian'));
    }
}
