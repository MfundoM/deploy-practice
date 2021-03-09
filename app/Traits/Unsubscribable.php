<?php

namespace App\Traits;

trait Unsubscribable
{
    /**
     * User that will receive the email.
     *
     * @var \Illuminate\Foundation\Auth\User|\App\Models\User $user
     */
    public $user;

    /**
     * Add "unsubscribe" option to emails.
     *
     * @return $this|bool
     */
    public function withUnsubscribeHeader()
    {
        // TODO: User that is not subscribed should not receive emails!
        if (empty($this->user) || !$this->user->subscribed) {
            return true;
        }

        $parts = [];

        foreach (['getMailto', 'getHttp'] as $part) {
            if ($link = $this->{$part}()) {
                $parts[] = $link;
            }
        }

        if (count($parts)) {
            return $this->withSwiftMessage(function (\Swift_Message $message) use ($parts) {
                $message->getHeaders()->addTextHeader('List-Unsubscribe', implode(', ', $parts));
            });
        }

        return $this;
    }

    /**
     * Get "http" part for List-Unsubscribe header.
     *
     * @return string|null
     */
    private function getHttp() : ?string
    {
        if (method_exists($this->user, 'linkUnsubscribe')) {
            return sprintf('<%s>', $this->user->linkUnsubscribe());
        }

        return null;
    }

    /**
     * Get "mailto" part for List-Unsubscribe header.
     *
     * @return string|null
     */
    private function getMailto() : ?string
    {
        if ($email = config('mail.unsubscribe.email')) {
            return sprintf('<mailto:%s?subject=unsubscribe>', $email);
        }

        return null;
    }
}
