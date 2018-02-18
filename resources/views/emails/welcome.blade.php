@component('mail::message')
    # Hello {{ $user->name }}

    Thank you for creating an account. Please verify your email address using this link:

    @component('mail::button', ['url' => " route('users.verify', $user->verification_token) "])
        Button Text
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
