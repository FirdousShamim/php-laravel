<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AddCollab extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $url, $planName, $owner;
    
    public function __construct($url , $planName, $owner)
    {
        //
        $this->url=$url;
        $this->planName=$planName;
        $this->owner=$owner;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.emailCollab')
            ->subject('Invite for Collab')
            ;
    }
}
