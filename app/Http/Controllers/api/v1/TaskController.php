<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Task;
use App\Traits\Helpers;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::with('section')->latest()->get();
        return Helpers::apiResponse(true, '', $tasks);
    }
}
