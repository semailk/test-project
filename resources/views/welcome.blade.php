@extends('layouts.main')
@section('content')
    <div class="container row">
        <h3>Сумма активных клиентов:{{ $clientInfo['count'] }}</h3>
        <h3>Сумма удаленных клиентов:{{ $clientInfo['deleted'] }}</h3>
        @if(request()->path() === '/')
            <h3>Сумма клиентов у которых нету source: <a
                    href="{{ route('dont.source') }}">{{ count($clientInfo['dont_source']) }}</a></h3>
        @endif
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Клиент</th>
                <th scope="col">Email</th>
                <th scope="col">Телефон</th>
                <th scope="col">Source</th>
                <th scope="col">Deposits</th>
            </tr>
            </thead>
            <tbody>
            @foreach($managers as $manager)
                @foreach($manager->clients as $client)
                {{--                @can(auth()->user()->role->name,$client, auth()->user())--}}
                @if(!is_array($client))
                    <tr>
                        <th scope="row">{{ $client->fullName }}</th>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->phone }}</td>

                        <td>@if(isset($client->source->title))
                                {{ $client->source->title }}@endif
                        </td>

                        <td>
                            {{ $client->depositsSum }}

                        </td>
                    </tr>
                    {{--                @endcan--}}
                @else
                    <tr>
                        <th scope="row">{{ $client['client']->fullName }}</th>
                        <td>{{ $client['client']->email }}</td>
                        <td>{{ $client['client']->phone }}</td>

                        <td>@if(isset($client['client']->source->title))
                                {{ $client['client']->source->title }}@endif
                        </td>

                    </tr>
                @endif
            @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
