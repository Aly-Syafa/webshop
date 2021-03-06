<?php

namespace App\Jobs;

use App\Jobs\Job;
use Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyJobFinished extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $text;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('emails.notify', ['text' => $this->text], function ($m) {
            $m->from('droit.formation@unine.ch', 'Administration');
            $m->to('cindy.leschaud@gmail.com', 'Administration')->subject('Notification');
        });
    }
}
