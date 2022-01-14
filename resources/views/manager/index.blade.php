@extends('layouts.main')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Surname</th>
            <th scope="col">Salary</th>
            <th scope="col">Students</th>
            <th scope="col">Plain</th>
        </tr>
        </thead>
        <tbody>
        @foreach($managers as $manager)
            <tr>
                <th scope="row">{{ $manager->name }}</th>
                <td>{{ $manager->surname }}</td>
                <td>{{ $manager->salary }}</td>
                <td>
                    @foreach($manager->clients as $client)
                        {{ $client->name }}  {{ $client->surname }} <br>
                    @endforeach
                </td>
                <td>
                    @foreach($manager->managerPlains as $managerPlain)
                        @if($managerPlain->CheckQuarter)
                           {{ $manager->clientsSumDeposits }} из {{ round($managerPlain->plain) }} ({{round( round($manager->clientsSumDeposits) /  round($managerPlain->plain) * 100) . '%' }})
                        @else
                            <h6>Нету плана на текущий квартал.</h6>
                        @endif
                    @endforeach

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

