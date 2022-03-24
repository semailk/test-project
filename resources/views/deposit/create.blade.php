@extends('layouts.main')
@section('content')
    <div class="container d-flex mt-3">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                        type="button" role="tab" aria-controls="nav-home" aria-selected="true">Добавить депозит
                </button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                        type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Вывести депозит
                </button>
                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                        type="button" role="tab" aria-controls="nav-contact" aria-selected="false">История депозитов
                </button>
            </div>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <form action="{{ route('deposits.store') }}" method="post">
                        @csrf
                        <label for="client">Клиент</label>
                        <input type="text" value="{{ $client->name }}" class="form-control" disabled readonly>

                        <label for="sum">Сумма</label>
                        <input type="number" class="form-control" name="value">

                        <input type="hidden" name="client_id" value="{{ $client->id }}">

                        <button type="submit" class="btn btn-secondary mt-2">Сохранить</button>
                    </form>
                </div>
                <em><a href="{{ route('pdf.store', $client->id) }}" style="text-decoration: none">Скачать в pdf</a></em>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <form action="{{ route('withdraw')}}" method="post">
                        @csrf
                        <label for="balance">Доступно акций</label>
                        <input type="number" name="balance" class="form-control"
                               value="{{ $client->certificatesSum() }}"
                               disabled>

                        <label for="">Баланс</label>
                        <input type="text" readonly disabled class="form-control" value="{{ $client->balance }} $">
                        <em>1000$ = 1-акция</em><br>
                        @if((int)($client->balance / 1000) >= 1)
                            <em>Доступно: {{ (int)($client->balance / 1000) }} акций</em><br>
                            <a href="{{ route('deposits.exchange', $client->id) }}" class="btn btn-outline-danger">Обменять</a>
                        @endif
                        <input type="hidden" value="{{ $client->id }}" name="client_id">
                        <hr>
                        <label for="withdraw">Вывести акций</label>
                        <input type="number" name="withdraw" class="form-control">
                        <button class="btn btn-warning mt-2">Вывести</button>
                    </form>

                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Кол-во акций</th>
                            <th scope="col">Выведено</th>
                            <th scope="col">Дата</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($client->certificates as $certificate)
                            <tr>
                                <th scope="row">{{ $certificate->shares }}</th>
                                <td>{{ $certificate->canceled_shares }}</td>
                                <td>{{ $certificate->canceled_at }}</td>
                            </tr>
                        @endforeach
                        <h3>Сумма активный акций: {{ $client->certificatesSum() }}</h3>
                        </tbody>
                    </table>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger mt-2">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success mt-2">{{ session('success') }}</div>
            @endif
        </nav>
        <div id="adobe-dc-view"></div>
        <script src="https://documentcloud.adobe.com/view-sdk/main.js"></script>
        <script type="text/javascript">
            document.addEventListener("adobe_dc_view_sdk.ready", function(){
                var adobeDCView = new AdobeDC.View({clientId: "ab818492127e406db04324ac72bb4dcf", divId: "adobe-dc-view"});
                adobeDCView.previewFile({
                    content:{location: {url: "https://documentcloud.adobe.com/view-sdk-demo/PDFs/Bodea Brochure.pdf"}},
                    metaData:{fileName: "Bodea Brochure.pdf"}
                }, {});
            });
        </script>

@endsection
