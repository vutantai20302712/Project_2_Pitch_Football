<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        Commands\UpdateOrderStatus::class,
    ];
    protected function schedule(Schedule $schedule): void
    {
        // Lên kế hoạch thực hiện lệnh cập nhật trạng thái đơn hàng hàng ngày vào lúc 00:00 AM
        $schedule->command('scheduling_froms:update-status')->dailyAt('00:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    
    
}
