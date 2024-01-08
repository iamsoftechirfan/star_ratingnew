<?php

namespace App\Mail;

// App\Mail\MyCustomEmail.php

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MyCustomEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Your query';
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->view('emails.my_custom_template')
                    ->with($this->data);
    }
}