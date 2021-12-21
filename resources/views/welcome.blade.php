@extends('layouts.main')
@section('content')
    <div class="container">
        <h3>Сумма активных клиентов:{{ $clientInfo['count'] }}</h3>
        <h3>Сумма удаленных клиентов:{{ $clientInfo['deleted'] }}</h3>
        @if(request()->path() === '/')
        <h3>Сумма клиентов у которых нету source: <a href="{{ route('dont.source') }}">{{ count($clientInfo['dont_source']) }}</a></h3>
        @endif
            <table class="table">
            <thead>
            <tr>
                <th scope="col">Клиент</th>
                <th scope="col">Email</th>
                <th scope="col">Телефон</th>
                <th scope="col">Source</th>
                <th scope="col">Managers</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clients as $client)
                <tr>
                    <th scope="row">{{ $client->fullName }}</th>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone }}</td>

                    <td>@if(isset($client->source->title))
                            {{ $client->source->title }}@endif
                    </td>

                    <td>
                        <?php $client->managers->each(function ($client) {
                            echo $client->name . ' (Fee)-  ' . $client->fee->fee  . '<br>';
                        }) ?>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
