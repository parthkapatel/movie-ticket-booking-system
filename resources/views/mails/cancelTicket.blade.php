@extends("layouts.app")

@section("content")
    <div class="container">
        <h2 class="text-danger">Your {{ $data->title }} Movie tickets are canceled.</h2>
        <div class="table-responsive">
            <table class="table table-dark table-bordered">
                <thead class="text-dark bg-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Movie Name</th>
                    <th scope="col">City Name</th>
                    <th scope="col">Theater Name</th>
                    <th scope="col">Show Date & Time</th>
                    <th scope="col">Seats</th>
                    <th scope="col">Booking Date</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->title }}</td>
                    <td>{{ $data->city_name }}</td>
                    <th>{{ $data->theater_name }}</th>
                    <td>{{ date("d-m-Y", strtotime($data->show_time_date)) ." / ". $data->show  }}</td>
                    <td>{{ $data->seats }}</td>
                    <td>{{  date("d-m-Y", strtotime($data->created_at)) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
