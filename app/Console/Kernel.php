<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Listing;

include "insertListings.php";

class Kernel extends ConsoleKernel
{
    protected $commands = [
        // Commands\Inspire::class,
    ];


//Here is the schedule which will run at 2AM PST.
    protected function schedule(Schedule $schedule)
    {
	$schedule->call(function(){
		insertListings();
	})->dailyAt('2:00')->timezone('America/New_York');
    }

}
