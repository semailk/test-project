@extends('layouts.main')
@section('content')
    <style>
        .container {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        form {
            margin: 20px 0 0;
            width: 50%;
        }

        h3 {
            text-align: center;
        }

        table {
            width: 100%;
            margin-bottom: 200px;
        }

    </style>
    <div class="container">
        <form id="form" action="{{ route('sanction.edit') }}" method="POST">
            @csrf
            <h3>Search Sanction</h3>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control">

            <label for="ind">Individual / Organization</label>
            <select name="ind_org" id="ind" class="form-select">
                <option value="1">Individual</option>
                <option value="2">Organization</option>
            </select>

            <button type="button" class="btn btn-outline-warning w-50 mt-3">Search</button>
        </form>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Birthdate</th>
            </tr>
            </thead>
            <tbody id="column">
            @if(isset($response))
                @foreach($response as $data)
                    <tr class="tr-columns">
                        <th scope="row"><a target="_blank" href="{{$data['url']}}">
                                {{ $data['entity_name'] }} </a></th>
                        <td>{{ $data['birthdate'] }}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

@endsection




<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $("form button").click(function () {
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: "POST",
                url: "/sanction-search",
                data: {
                    _token: _token,
                    name: $('#name').val(),
                    ind: $('#ind').val()
                },
                success: function (response) {
                    $('.tr-columns').remove();
                    $.each(response, function (index) {
                        $('#column').append('<tr class="tr-columns"> <th scope="row"><a target="_blank" href="' + response[index]['url'] + '">' + response[index]['entity_name'] + '</a></th> <td>' + response[index]['birthdate'] + '</td> </tr>');
                    })
                }
            })
        })
    })
</script>
