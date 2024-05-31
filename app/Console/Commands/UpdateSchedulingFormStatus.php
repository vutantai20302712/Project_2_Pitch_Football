<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Scheduling_from;

class UpdateOrderStatus extends Command
{
    protected $signature = 'scheduling_froms:update-status';
    protected $description = 'Update order status based on current date';

    public function handle()
    {
        // Lấy các đơn hàng cần cập nhật trạng thái
        $scheduling_froms = Scheduling_from::where('scheduling_form_status', '!=', 'Cancelled')
            ->where('scheduling_form_date', '<', now())
            ->get();

        foreach ($scheduling_froms as $order) {
            // Kiểm tra trạng thái của đơn hàng và ngày hiện tại
            if ($order->scheduling_form_status === 'Paid') {
                // Nếu đơn hàng đã thanh toán và đã qua ngày hiện tại, cập nhật thành đã hoàn thành
                $order->scheduling_form_status = 'Completed';
            } else {
                // Nếu đơn hàng chưa thanh toán và đã qua ngày hiện tại, cập nhật thành bị hủy
                $order->scheduling_form_status = 'Cancelled';
            }
            // Lưu thay đổi vào cơ sở dữ liệu
            $order->save();
        }

        $this->info('Order statuses updated successfully.');
    }
}
