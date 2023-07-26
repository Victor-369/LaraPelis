<?php

namespace App\Listeners;

use App\Events\FirstPeliCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
//use App\Models\Peli;
use App\Mail\Congratulation;


class SendCongratulationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\FirstPeliCreated  $event
     * @return void
     */
    public function handle(FirstPeliCreated $event)
    {
        Mail::to($event->user->email)->send(new Congratulation($event->peli));
    }
}
