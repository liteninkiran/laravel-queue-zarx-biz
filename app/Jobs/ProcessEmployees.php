<?php

namespace App\Jobs;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessEmployees implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $employeeData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($employeeData)
    {
        $this->employeeData = $employeeData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->employeeData as $employeeData) {
            $employee = new Employee();
            $employee->name = $employeeData["First Name"] . ' ' . $employeeData["Last Name"];
            $employee->save();
        }
    }
}
