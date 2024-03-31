<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EstadoEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $contentData;
    public $viewName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $contentData, $viewName)
    {
        $this->subject = $subject;
        $this->contentData = $contentData;
        $this->viewName = $viewName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
            ->view($this->viewName)
            ->with($this->contentData);
    }
}
