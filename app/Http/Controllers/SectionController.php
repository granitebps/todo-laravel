<?php

namespace App\Http\Controllers;

use App\Section;
use App\Traits\Helpers;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::with('task')->latest()->get();

        return Helpers::apiResponse(true, '', $sections);
    }
}
