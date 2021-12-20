@extends('layouts.main')
@section('content')
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <form action="{{ route('clients.store') }}" method="post" class="row g-3">
            @csrf
            <div class="col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>

            <div class="col-md-6">
                <label for="surname" class="form-label">Surname</label>
                <input type="text" class="form-control" name="surname" id="surname">
            </div>

            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="inputEmail4">
            </div>

            <div class="col-md-6">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone" id="phone">
            </div>

            <div class="col-md-6">
                <label for="Source" class="form-label">Source</label>
                <select class="form-control" name="source_id" id="Source">
                    @foreach($sources as $source)
                        <option value="{{ $source->id }}">{{ $source->title }}</option>
                    @endforeach
                </select>

            </div>

            <div class="select-managers">
            <div class="col-md-12 mt-2 d-flex">
                <label for="Manager" class="form-label">Manager</label>
                <select class="form-control" name="manager_id[]" id="Manager">
                    <option value="">Select manager</option>
                    @foreach($managers as $manager)
                    <option value="{{ $manager->id }}">{{ \App\Models\Manager::getFullName($manager) }}</option>
                    @endforeach
                </select>
                <label for="fee">Fee</label>
                <input type="number" name="fee[]" id="fee" class="form-control">
            </div>

                <div class="col-md-12 mt-2 d-flex">
                    <label for="Manager" class="form-label">Manager</label>
                    <select class="form-control" name="manager_id[]" id="Manager">
                        <option value="">Select manager</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager->id }}">{{ \App\Models\Manager::getFullName($manager) }}</option>
                        @endforeach
                    </select>
                    <label for="fee">Fee</label>
                    <input type="number" name="fee[]" id="fee" class="form-control">
                </div>

                <div class="col-md-12 mt-2 d-flex">
                    <label for="Manager" class="form-label">Manager</label>
                    <select class="form-control" name="manager_id[]" id="Manager">
                        <option value="">Select manager</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager->id }}">{{ \App\Models\Manager::getFullName($manager) }}</option>
                        @endforeach
                    </select>
                    <label for="fee">Fee</label>
                    <input type="number" name="fee[]" id="fee" class="form-control">
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Create Client</button>
            </div>
        </form>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert-danger">{{$error}}</div>
            @endforeach
        @endif
    </div>
@endsection
