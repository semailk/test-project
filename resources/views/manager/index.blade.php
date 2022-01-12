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
                    <form action="" class="d-flex">
                        <input value="{{ $manager->plain['quarter_' . Illuminate\Support\Carbon::now()->quarter] }}" type="number" name="plain"
                               placeholder="Укажите план за квартал" class="form-control">
                        <button type="button" data-value="{{ $manager->plain['quarter_' . Illuminate\Support\Carbon::now()->quarter] }}" data-id="{{ $manager->id }}"
                                class="btn btn-outline-danger">OK!
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
            integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('.btn-outline-danger').click(function () {
                var params = {
                    id: $(this).attr('data-id'),
                    plain: $(this).parent().find('input').val()
                }
                $.ajax({
                    url: "/manager/plain/edit",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    data: params
                    , success: function () {
                        location.reload()
                    }
                })
            })
        });
    </script>
@endsection

