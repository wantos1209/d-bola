<?php

use Illuminate\Console\Scheduling\Schedule;

$schedule = app(Schedule::class); 
$schedule->command("migration-period-to-old-data-command")->cron("26 19 * * *");