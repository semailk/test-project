@extends('layouts.main')
@section('content')
    <style>
        form {
            width: 100%;
            height: 100%;
            display: flex;
            justify-items: center;
            justify-content: center;
            align-items: end;
        }

        .container {
            margin-top: 100px;
            max-height: 50px;
            display: flex;
            flex-direction: column;
        }

        table.blueTable {
            border: 1px solid #1C6EA4;
            background-color: #EEEEEE;
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }

        table.blueTable td, table.blueTable th {
            border: 1px solid #AAAAAA;
            padding: 3px 2px;
        }

        table.blueTable tbody td {
            font-size: 13px;
        }

        table.blueTable tr:nth-child(even) {
            background: #D0E4F5;
        }

        .blueTable {
            max-width: 600px;
            margin-top: 30px;
        }

        table.blueTable thead th:first-child {
            border-left: none;
        }

        table.blueTable tfoot {
            font-size: 14px;
            font-weight: bold;
            color: #FFFFFF;
            background: #D0E4F5;
            background: -moz-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
            background: -webkit-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
            background: linear-gradient(to bottom, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
            border-top: 2px solid #444444;
        }

        table.blueTable tfoot td {
            font-size: 14px;
        }
    </style>
    <div class="container">
        <form action="{{ route('managers.plain.create') }}" method="post">
            @csrf
            <div class="col-md-3">
                <label for="manager">Менеджер</label>
                <select name="manager_id" id="manager" class="form-control">
                    @foreach($managers as $manager)
                        <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="year">Год</label>
                <select name="year" id="year" class="form-control">
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="quarter">Квартал</label>
                <select name="quarter" id="quarter" class="form-control">
                    <option value="1">Квартал 1</option>
                    <option value="2">Квартал 2</option>
                    <option value="3">Квартал 3</option>
                    <option value="4">Квартал 4</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="plain">План</label>
                <input type="number" class="form-control" name="plain" id="plain">
            </div>
            <button class="btn btn-secondary">Сохранить</button>
        </form>
        <div class="row">
            <div class="response col-md-12">
                <table class="blueTable">
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('#manager').change(function () {
                $.ajax({
                    url: "/managers/get/plain",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: $(this).val(),
                    },
                    success: function (response) {
                        $('.blueTable tbody').empty()
                        $.each(response, function (index){
                            $('.blueTable tbody').append('<tr>' +
                                '<td>'+ response[index]['date'] +'</td>'+
                                '<td>'+ response[index]['plain'] +'</td>'
                            )
                        })
                    }
                })
            })
        })
    </script>
@endsection
