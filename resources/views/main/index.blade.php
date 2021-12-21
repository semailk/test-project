@extends('layouts.main')
@section('content')
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Full Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Source</th>
            <th scope="col">Managers</th>
            <th scope="col">Salary</th>
            <th scope="col">Operations</th>
        </tr>
        </thead>
        <tbody>
        @foreach($clients as $client)
            <tr>
                <th scope="row">{{ $client->fullName }}</th>
                <td>{{ $client->email }}</td>
                <td>{{ $client->phone }}</td>

                <td>@if(!is_null($client->source_id)){{ $client->source->title }}@endif</td>
                <td>
                    @foreach($client->managers as $manager)
                        {{$manager->name}} - Fee: {{ $manager->fee->fee }} <br>
                    @endforeach
                </td>
                <td>
                    @foreach($client->managers as $manager)
                        {{$manager->salary}} <br>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('clients.edit', $client->id) }}">
                        <button class="btn btn-warning">Edit</button>
                    </a>
                    <form method="post" action="{{ route('clients.destroy', $client->id) }}">@csrf @method('DELETE')
                        <button type="submit" onclick="confirm('Вы точно хотите удалить?')" class="btn btn-danger">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $clients->links() }}
    <h3 style="float: right">Клиентов удалено: {{ $clientInfo['deleted'] }} | Активных
        клиентов:{{ $clientInfo['count'] }}</h3>
    <hr>
    <h1>Клиента у которых нету Source</h1>
    @if($clientInfo['dont_source'])
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Full Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Source</th>
                <th scope="col">Managers</th>
                <th scope="col">Salary</th>
                <th scope="col">Operations</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clientInfo['dont_source'] as $client)
                <tr>
                    <th scope="row">{{ $client->fullName }}</th>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone }}</td>

                    <td>@if(!is_null($client->source_id)){{ $client->source->title }}@endif</td>
                    <td>
                        @foreach($client->managers as $manager)
                            {{$manager->name}} - Fee: {{ $manager->fee->fee }} <br>
                        @endforeach
                    </td>
                    <td>
                        @foreach($client->managers as $manager)
                            {{$manager->salary}} <br>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('clients.edit', $client->id) }}">
                            <button class="btn btn-warning">Edit</button>
                        </a>
                        <form method="post" action="{{ route('clients.destroy', $client->id) }}">@csrf @method('DELETE')
                            <button type="submit" onclick="confirm('Вы точно хотите удалить?')" class="btn btn-danger">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
