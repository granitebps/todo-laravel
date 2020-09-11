<?php

namespace App\Http\Controllers;

use App\Section;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::with('tasks')->latest()->get();

        return Helpers::apiResponse(true, '', $sections);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255'
        ]);

        DB::beginTransaction();
        try {
            Section::create($data);
            DB::commit();

            return Helpers::apiResponse(true, 'Section Created', [], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::apiResponse(false, $th->getMessage(), [], 500);
        }
    }
}
