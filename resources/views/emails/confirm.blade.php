@component('mail::message')
    # Hello {{ $user->name }}

    You changed your account, so we need to verify this new address. Please  using this link:

    @component('mail::button', ['url' => route('users.verify', $user->verification_token) ])
        Verify account
    @endcomponent

    Thanks,<br>
    Code Creators

@endcomponent
