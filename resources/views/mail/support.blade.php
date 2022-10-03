@component('mail::message')
# User Report / Business Account Support Email
 
@component('mail::panel')

From user email {{ $email }} with username {{ $name }}

@endcomponent


@component('mail::table')
| Query       | Description   |
| ------------- |:-------------:| 
| {{ $query_topic}}      | {{ $query_description}}      | $10      |

@endcomponent
 
 
Thanks,<br>
{{ $email }}
@endcomponent