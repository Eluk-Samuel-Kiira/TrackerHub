<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BudgetLimitMail extends Mailable
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
        return $this->view('mail.budget-limit')
            ->with([
                'projectName' => $this->content['projectName'],
                'projectBudgetLimit' => $this->content['projectBudgetLimit'],
                'requisitionName' => $this->content['requisitionName'],
                'requisitionAmount' => $this->content['requisitionAmount'],
                'currency' => $this->content['currency'],
                'description' => $this->content['description'],
                'companyName' => $this->content['companyName'],
                'subject' => $this->content['subject'],
            ]);
    }


}
