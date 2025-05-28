<?php

namespace App\Console\Commands;

use App\Models\EvaluationCycle;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateEvaluationCyclePhase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cycle:update-phase';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tự động cập nhật phase chu kỳ đánh giá theo tỉ lệ 3:5:7';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        $cycles = EvaluationCycle::all();

        foreach ($cycles as $cycle) {
            $start = Carbon::parse($cycle->start_date);
            $end = Carbon::parse($cycle->end_date);
            $totalDays = $start->diffInDays($end) + 1;

            if ($today->lt($start)) {
                $cycle->phase = 'not_started';
            } elseif ($today->gt($end)) {
                $cycle->phase = 'closed';
            } else {
                // Tính theo tỉ lệ 3:5:7
                $unit = $totalDays / 15.0;
                $employeeEnd = $start->copy()->addDays(floor($unit * 3) - 1);
                $managerEnd = $employeeEnd->copy()->addDays(floor($unit * 5));

                if ($today->lte($employeeEnd)) {
                    $cycle->phase = 'employee';
                } elseif ($today->lte($managerEnd)) {
                    $cycle->phase = 'manager';
                } else {
                    $cycle->phase = 'supervisor';
                }
            }

            $cycle->save();
        }

        $this->info('Cập nhật phase chu kỳ đánh giá thành công!');
    }
}
