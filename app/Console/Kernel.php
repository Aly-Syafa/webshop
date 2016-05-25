<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
		'App\Console\Commands\SendReminder',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('reminder')->everyMinute();

		// Monitor queue listen
/*		$path = base_path();
		$schedule->call(function() use($path) {
			if (file_exists($path . '/queue.pid')) {
				$pid = file_get_contents($path . '/queue.pid');
				$result = exec("ps -p $pid --no-heading | awk '{print $1}'");
				$run = $result == '' ? true : false;
			} else {
				$run = true;
			}
			if($run) {
				$command = '/usr/bin/php -c ' . $path .'/php.ini ' . $path . '/artisan queue:listen --tries=3 > /dev/null & echo $!';
				$number = exec($command);
				file_put_contents($path . '/queue.pid', $number);
			}
		})->name('monitor_queue_listener')->everyFiveMinutes();*/

		$schedule->command('queue:work --daemon')->everyMinute()->withoutOverlapping();
	}

}
