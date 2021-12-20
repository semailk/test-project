@extends('layouts.main')
@section('content')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Surname</th>
            <th scope="col">Salary</th>
            <th scope="col">Students</th>
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
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection
