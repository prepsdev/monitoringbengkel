<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $works = Work::all();

        return view('history', compact('works'));
    }
}
