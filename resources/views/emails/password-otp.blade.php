@component('mail::message')
# {{ __('Password Reset OTP') }}

{{ __('Use the following OTP to reset your password:') }}

@component('mail::panel')
**{{ $otp }}**
@endcomponent

{{ __('This code will expire in 10 minutes.') }}

{{ __('If you did not request a password reset, you can safely ignore this email.') }}

{{ __('Thanks,') }}<br>
{{ config('app.name') }}
@endcomponent
