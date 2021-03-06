<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Contracts\Mail\Mailer;
use App\Droit\Shop\Order\Entities\Order;

class NotifyAdminNewOrder extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $order;
    protected $mailer;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order  = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $infos = [
            'name'  => $this->order->user->name,
            'what'  => 'commande',
            'order' => $this->order->order_no,
            'link'  => 'admin/orders'
        ];

        \Mail::send('emails.notification', $infos, function ($m) {
            $m->from('droit.formation@unine.ch', 'Administration');
            $m->to('cindy.leschaud@gmail.com', 'Administration')->subject('Notification');
        });
    }
}
