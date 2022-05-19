@component('mail::message')
# Hello,{{$user['first_name'] }}

You're receiving this e-mail because you requested a password reset for your user account at {{ config('app.name')}}.

Your Verification Code Is : {{$user['code']}}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
