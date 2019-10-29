<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\NewPost;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $message;
    protected $user;
    /*public function __construct($user,$news,$us,$url)
    {
        $this->user = $user;
        $this->message = new NewPost($news,$us,$url);
    }*/
    public function __construct($user,$message)
    {
        $this->user = $user;
        $this->message = $message;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->notify($this->message);
    }
}
