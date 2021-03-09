<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactAdminMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Form that was submitted.
     *
     * @var object $form
     */
    public $form;

    /**
     * Create a new message instance.
     *
     * @param array $form
     */
    public function __construct(array $form)
    {
        $this->queue = 'emails';
        $this->delay = 0;

        $this->form = (object) $form;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->to(config('mail.contact.address'));
        $this->replyTo($this->form->email, $this->form->name);
        $this->subject('Website Contact Form');
        $this->markdown('emails.admin.contact');

        return $this;
    }
}
