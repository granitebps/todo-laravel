<?php

use App\Section;
use App\Task;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        DB::beginTransaction();
        try {
            $sections = Section::all();
            $status = ['todo', 'done'];
            foreach ($sections as $section) {
                for ($i = 0; $i < 5; $i++) {
                    Task::create([
                        'name' => $faker->text(30),
                        'section_id' => $section->id,
                        'status' => $status[array_rand($status)]
                    ]);
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }
    }
}
