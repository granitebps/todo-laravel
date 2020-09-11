<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Section;
use App\Task;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::with('section')->latest()->get();
        return Helpers::apiResponse(true, '', $tasks);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id'
        ]);

        DB::beginTransaction();
        try {
            $section = Section::find($data['section_id']);
            if (!$section) {
                return Helpers::apiResponse(false, 'Section Not Found', [], 404);
            }
            Task::create($data);
            DB::commit();
            return Helpers::apiResponse(true, 'Task Created', [], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::apiResponse(false, $th->getMessage(), [], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id'
        ]);

        DB::beginTransaction();
        try {
            $task = Task::find($id);
            if (!$task) {
                return Helpers::apiResponse(false, 'Task Not Found', [], 404);
            }

            $section = Section::find($data['section_id']);
            if (!$section) {
                return Helpers::apiResponse(false, 'Section Not Found', [], 404);
            }
            $task->update($data);
            DB::commit();
            return Helpers::apiResponse(true, 'Task Updated');
        } catch (\Throwable $th) {
            DB::rollBack();
            return Helpers::apiResponse(false, $th->getMessage(), [], 500);
        }
    }
}
