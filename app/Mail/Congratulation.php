<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Peli;

class Congratulation extends Mailable {
    use Queueable, SerializesModels;

    public $peli;

    public function __construct(Peli $peli) {
        $this->peli = $peli;
    }

    public function build() {
        return $this->from('no-reply@larapelis.com')
                    ->subject('¡Felicidades!')
                    ->view('emails.congratulation');
    }
}