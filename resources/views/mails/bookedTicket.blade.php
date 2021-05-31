<div class="container">
    <h1>User Name : {{ $data->name }}</h1>
    <h2>Movie Name : {{ $data->title }}</h2>
    <h3>City Name : {{ $data->city_name }}</h3>
    <h3>Theater Name : {{ $data->theater_name }}</h3>
    <h3>Show Date & Time : {{ date("d-m-Y", strtotime($data->show_time_date)) ." / ". $data->show  }}</h3>
    <h3>Seats : {{ $data->seats }}</h3>
    <h3>Booking Date : {{  date("d-m-Y", strtotime($data->created_at)) }}</h3>
</div>
