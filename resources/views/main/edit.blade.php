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

            <div class="select-managers">
                @foreach($client->managers as $manager)
                    <div class="col-md-12 mt-2 d-flex">
                        <label for="Manager" class="form-label">Manager</label>
                        <select class="form-control" name="manager_id[]" id="Manager">
                            <option value="{{ $manager->id }}">{{ \App\Models\Manager::getFullName($manager) }}</option>
                            @foreach($managers as $man)
                                <option value="{{ $man->id }}">{{ \App\Models\Manager::getFullName($man) }}</option>
                            @endforeach
                        </select>
                        <label for="fee">Fee</label>
                        <input type="number" value="{{ $manager->fee->fee }}" name="fee[]" id="fee"
                               class="form-control">
                    </div>
                @endforeach
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
