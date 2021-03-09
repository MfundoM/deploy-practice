<dropdown-trigger class="h-9 flex items-center">
    @isset($user->email)
        <img
            src="https://secure.gravatar.com/avatar/{{ md5(\Illuminate\Support\Str::lower($user->email)) }}?size=512"
            class="rounded-full w-8 h-8 mr-3"
        />
    @endisset

    <span class="text-90">
        {{ $user->name ?? $user->email ?? __('Nova User') }}
    </span>
</dropdown-trigger>

<dropdown-menu slot="menu" width="200" direction="rtl">
    <ul class="list-reset">
        <li>
            @if(auth('admin')->user()->super_admin ?? false)
                <a href="/{{ config('horizon.path') }}" class="block no-underline text-90 hover:bg-30 p-3" target="_blank">
                    Queues
                </a>
            @endif
            <a href="{{ route('nova.logout') }}" class="block no-underline text-90 hover:bg-30 p-3">
                Logout
            </a>
        </li>
    </ul>
</dropdown-menu>
