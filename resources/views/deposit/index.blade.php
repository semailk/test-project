@extends('layouts.main')
@section('content')
    <style>
        .list-group {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
        }
    </style>
    <ul class="list-group">
        @foreach($clients as $client)
             <li class="list-group-item"><a href="{{ route('deposits.show', $client->id) }}">{{ $client->name }}</a></li>
        @endforeach
    </ul>
@endsection
