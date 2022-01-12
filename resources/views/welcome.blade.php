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
                <th scope="col">Managers</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clients as $client)
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
                        @foreach($client->managers as $manager)
                            {{ $manager->name . ' (Fee)-  ' . $manager->fee->fee }} <br>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $manager->completed }}%;" aria-valuenow="{{ $manager->completed }}" aria-valuemin="0" aria-valuemax="100">{{ $manager->completed }}%</div>
                                </div> <br>
                            <h5>Plain-{{ $manager->plain['quarter_' . Illuminate\Support\Carbon::now()->quarter] }}  Deposits Sum - {{ $manager->deposits }}</h5>
                        @endforeach

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

                        <td>
                            <?php $client['client']->managers->each(function ($client) {
                                echo $client->name . ' (Fee)-  ' . $client->fee->fee . '<br>';
                            }) ?>
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
