<?php

namespace App\Console\Commands;

use App\Section;
use App\Task;
use Illuminate\Console\Command;

class StatusTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change Task Status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sections = Section::pluck('title')->all();
        $section_name = $this->choice(
            'Select a Section',
            $sections
        );
        $section = Section::where('title', $section_name)->first();
        $tasks = Task::where('section_id', $section->id)->get();
        $tasks->transform(function ($item) {
            return $item->name . ' - ' . $item->status;
        });
        $task_name = $this->choice(
            'Select a Task to change the status',
            $tasks->toArray()
        );
        $task_name = explode(' - ', $task_name);
        $task = Task::where('section_id', $section->id)->where('name', $task_name[0])->first();
        $prev_status = $task->status;
        $status = $prev_status === 'todo' ? 'done' : 'todo';
        $task->status = $status;
        $task->save();
        $this->info('Task "' . $task->name . '" status successfully changed to ' . $task->status);
    }
}
