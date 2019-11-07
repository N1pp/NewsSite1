<?php

namespace App\Jobs;

use App\Notifications\NewPost;
use App\Sub;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    private $news;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($news)
    {
        $this->news = $news;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mail = new NewPost($this->news,User::find($this->news->user_id)->name,'/news/' . $this->news->id);
        foreach (Sub::where('author_id',$this->news->user_id)->get() as $sub){
            User::find($sub->user_id)->notify($mail);
        }
    }
}
