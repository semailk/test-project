@extends('layouts.main')
@section('content')
<div class="container">
    <form action="{{ route('clients.update', $client->id) }}" method="post">
        @method('PUT')
        @csrf
        <div class="mb-3 w-50">
            <label for="name" class="form-label">Name</label>
            <input type="text" value="{{ $client->name }}" class="form-control" name="name" id="name"
                   aria-describedby="nameHelp">
            <div id="nameHelp" class="form-text">Edit name.</div>
        </div>

        <div class="mb-3 w-50">
            <label for="surname" class="form-label">Surname</label>
            <input type="text" value="{{ $client->surname }}" class="form-control" name="surname" id="surname"
                   aria-describedby="surnameHelp">
            <div id="surnameHelp" class="form-text">Edit surname.</div>
        </div>

        <div class="mb-3 w-50">
            <label for="surname" class="form-label">Phone</label>
            <input type="text" value="{{ $client->phone }}" class="form-control" name="phone" id="phone"
                   aria-describedby="phoneHelp">
            <div id="phoneHelp" class="form-text">Edit phone.</div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert-danger">{{$error}}</div>
        @endforeach
    @endif
</div>
@endsection
