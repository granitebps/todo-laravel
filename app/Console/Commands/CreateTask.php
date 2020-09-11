<?php

namespace App\Console\Commands;

use App\Section;
use App\Task;
use Illuminate\Console\Command;

class CreateTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Task';

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
            $sections,
            0,
            $maxAttempts = null,
            $allowMultipleSelections = false
        );
        $task_name = $this->ask('What is your task?');
        $section = Section::where('title', $section_name)->first();
        $task = Task::create([
            'name' => $task_name,
            'section_id' => $section->id
        ]);
        $this->info('Task "' . $task->name . '", successfully created in ' . $section->title . ' section');
    }
}
