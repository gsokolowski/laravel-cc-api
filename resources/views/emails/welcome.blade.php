@component('mail::message')
# Hello {{ $user->name }}

Thank you for creating an account with Code Creators. Please verify your email address using this link:

@component('mail::button', ['url' => route('users.verify', $user->verification_token) ])
    Verify account
@endcomponent

Thanks,<br>
Code Creators

@endcomponent
