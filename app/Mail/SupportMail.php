<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        //
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                 ->subject('Query - Report Email Thread')
                 ->markdown('mail.support', [
                "name" => $this->user["name"],
                "email" =>  $this->user["email"],
                "query_topic" => $this->user["query_topic"], 
                "query_description" => $this->user["query_description"],
           ]);
    }
}
