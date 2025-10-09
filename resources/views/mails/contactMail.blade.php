@component('mail::message')
# Novo Contato
Nome : {{$name}} <br>
Email : {{$email}} <br>
Telefone : {{$number}} <br>
Url : {{$url}} <br>
Message: {{$message}} <br>

Obrigado,<br>
{{ config('app.name') }}
@endcomponent