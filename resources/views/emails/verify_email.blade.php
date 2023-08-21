@component('mail::message')
# Verify Your Email

Please click the button below to verify your email.

@component('mail::button', ['url' => $emailVerifyUrl])
Verify
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
