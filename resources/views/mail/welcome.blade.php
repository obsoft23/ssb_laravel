@component('mail::message')
# Welcome {{ $name }} 
 
Your account has been successfully created!
 
@component('mail::button', ['url' => ""])
Enjoy
@endcomponent
 
Thanks,<br>
{{ config('app.name') }}
@endcomponent