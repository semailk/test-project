<style>
    th, td, tr {
        border: solid 1px black;
    }

    h2 {
        color: blue;
    }

    h3 {
        color: red;
    }
</style>

<div class="">
    <h2>Hi , {{ $client->getFullNameAttribute() }}</h2>
</div>
<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
    <h3>History of your shares</h3>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Number of shares</th>
            <th scope="col">Bred</th>
            <th scope="col">Date</th>
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
        <h3>Amount of active shares: {{ $client->certificatesSum() }}</h3>
        </tbody>
    </table>
</div>
