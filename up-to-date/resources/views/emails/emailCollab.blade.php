@component('mail::message')
# Invitaion to Collaborator

Hey,

{{$owner}} added you as a Collaborator to their plan {{$planName}}.

Login to Up-to-Date or Sign Up to access the Plan.
@component('mail::button', ['url' => $url])
Collab
@endcomponent
Click the above button to access the plan.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
