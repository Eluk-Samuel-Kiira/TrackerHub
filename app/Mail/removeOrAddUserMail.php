<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class removeOrAddUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $content;

    /**
     * Create a new message instance.
     */
    public function __construct(array $content)
    {
        $this->content = $content;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->content['subject'], // Use the dynamic subject
        );
    }

    
    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->subject($this->content['subject'])
                    ->view('mail.remove-add-user')
                    ->with([
                        'projectName' => $this->content['projectName'],
                        'companyName' => $this->content['companyName'],
                        'username' => $this->content['username'],
                        'emailMessage' => $this->content['emailMessage'],
                        'subject' => $this->content['subject'],
                    ]);
    }

}
