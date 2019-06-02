<form action="/event/edit" method="get">
    <h1>イベント名:{{$event_name}}</h1>
    <h1>詳細:{{$detail}}</h1>
    <h1>イベント作成日:{{$created_at}}</h1>
    <h1>候補日</h1>
    @foreach($possible_dates as $date)
        <h2>{{$date->possible_dates}}</h2>
    @endforeach
    <button type="submit">編集</button>
</form>
