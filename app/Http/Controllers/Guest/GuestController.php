<?php

namespace App\Http\Controllers\Guest;

use App\Helpers\Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\Guest\ContactRequest;
use Illuminate\Support\Facades\Mail;

class GuestController extends Controller
{
    /**
     * GuestController constructor.
     */
    public function __construct()
    {
        $this->middleware(\Spatie\Honeypot\ProtectAgainstSpam::class)->only('submitContact');
    }

    /**
     * Show the home page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function homepage()
    {
        return view('guest.homepage');
    }

    /**
     * Show the about page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function about()
    {
        return view('guest.about');
    }

    /**
     * Show the contact page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function contact()
    {
        return view('guest.contact');
    }

    /**
     * Submit the contact form.
     *
     * @param \App\Http\Requests\Guest\ContactRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitContact(ContactRequest $request)
    {
        $form = $request->validated();

        Mail::send(new \App\Mail\ContactGuestMail($form));

        Mail::send(new \App\Mail\ContactAdminMail($form));

        Alert::success('Message sent successfully!');

        return redirect()->back();
    }

    /**
     * Testing area.
     *
     * @return mixed|void
     * @throws \ReflectionException
     */
    public function test()
    {
        if (!\Illuminate\Support\Facades\App::isLocal()) {
            return redirect('/', 301);
        }

        if ($user = \App\Models\User::first()) {
            return (new \App\Mail\TestMail($user))->render();
        }

        abort(404);
    }
}
