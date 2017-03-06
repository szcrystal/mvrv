<?php

namespace App\Console;

use App\Totalize;
use App\TotalizeAll;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //\App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $num = env('TOTALIZE_TIME', 3);
        $time = $num . ':00';
        
        $schedule->call(function () use($num) {
 
            if($num >= 0 && $num < 12) {
            	$date = date('Y-m-d', strtotime('-1 day'));
            }
            else {
            	$date = date('Y-m-d', time());
            }
            
        
        	$dayTotal = Totalize::where(['view_date' => $date])->get();
            $atclGroup = $dayTotal->groupBy('atcl_id')->toArray();
            
            foreach($atclGroup as $key => $val) {
            	$totalAll = TotalizeAll::where(['atcl_id' => $key])->first();
                $count = count($val);
                
                if($totalAll) {
                	$totalAll->increment('total_count', $count);
                }
                else {
                	$totalAll = TotalizeAll::create(
                        [
                            'atcl_id' => $key,
                            'total_count' => $count,
                        ]
                    );
                }
            }
            
        })->dailyAt($time);
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
