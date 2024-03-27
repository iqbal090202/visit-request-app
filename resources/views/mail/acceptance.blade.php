<x-mail::message>
Halo Guys!!!<br>

your request visit is {{ $action }}

@if ($action == 'accepted')
<hr>
Berikut QR Code yang bisa anda gunakan:<br><br>
<img src="{{ $message->embed(public_path() . '/storage/' . $filename) }}">
@endif

</x-mail::message>
