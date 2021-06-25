@component('mail::message')
<h1>{{$details['title']}}</h1> <br>

{{$details['body']}}

@component('mail::button', ['url' => $details['url'], 'color' => 'success'])
View Detail
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
