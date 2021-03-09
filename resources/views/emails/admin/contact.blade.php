@component('mail::message')
# Contact Form

Someone sent you a message from {{ route('guest.contact') }}

**Name:** {{ $form->name }}<br>
**Email:** {{ $form->email }}<br>
**IP Address:** [{{ $form->ip }}](https://extreme-ip-lookup.com/{{ $form->ip }})<br>

{{ $form->message }}

@component('mail::subcopy')
<small>To respond to their message, simply reply to this email.</small>
@endcomponent
@endcomponent
