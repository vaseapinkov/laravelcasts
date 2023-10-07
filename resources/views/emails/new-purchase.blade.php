@component('mail::message')
# Thanks for purchasing {{$course->title}}

If this is your firs purchase on {{config('app.name')}}, then a new account was created for you and you have to reset ypur password}}

@component('mail::button', ['url' => route('login')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
