<x-mail::message>
    # Nouveau message de contact de: {{ $name }}

    *E-mail*:`{{ $email }}`
    *Objet*:`{{ $subject }}`
    *Message*: {{ $message }}


    Merci,
    {{ config('app.name') }}
</x-mail::message>
