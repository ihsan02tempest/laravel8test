<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
        
     //parameter judul artikel dan nama penerima artikel
    public $title;
    public $name;
    public function __construct($title, $name)
    {
        $this->title = $title;
        $this->name = $name;    
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Postingan Terbaru dari Vanillanovela.blogspot.com')->view('emails.posts');
    }
}
