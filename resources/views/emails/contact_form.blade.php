<h2>Новое сообщение</h2>
@foreach($data as $key => $value)
    <p><strong>{{ $key }}:</strong> {{ $value }}</p>
@endforeach
