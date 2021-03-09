<?php

namespace App\Mail;

use App\Traits\Unsubscribable;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels, Unsubscribable;

    /**
     * User that will receive the email.
     *
     * @var \Illuminate\Foundation\Auth\User|\App\Models\User $user
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->queue = 'emails';
        $this->delay = 0;

        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this|bool
     */
    public function build()
    {
        $this->to($this->user->email, $this->user->name);
        $this->subject('Test Email');
        $this->markdown('emails.test');

        // TODO: User that is not subscribed should not receive emails!
        return $this->withUnsubscribeHeader();
    }
}
