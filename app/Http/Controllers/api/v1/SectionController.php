<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
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

    public function show($id)
    {
        $section = Section::with('tasks')->find($id);
        if (!$section) {
            return Helpers::apiResponse(false, 'Section Not Found', [], 404);
        }
        return Helpers::apiResponse(true, '', $section);
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

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255'
        ]);

        DB::beginTransaction();
        try {
            $section = Section::find($id);
            if (!$section) {
                return Helpers::apiResponse(false, 'Section Not Found', [], 404);
            }

            $section->update($data);
            DB::commit();

            return Helpers::apiResponse(true, 'Section Updated');
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::apiResponse(false, $th->getMessage(), [], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $section = Section::find($id);
            if (!$section) {
                return Helpers::apiResponse(false, 'Section Not Found', [], 404);
            }

            $section->delete();
            DB::commit();

            return Helpers::apiResponse(true, 'Section Deleted');
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::apiResponse(false, $th->getMessage(), [], 500);
        }
    }
}
