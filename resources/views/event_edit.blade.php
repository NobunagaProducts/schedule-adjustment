<form action="/event/edit" method="post">
    @csrf
    <h1>イベント名:<input type="text" name="event_name" value="{{$event_name}}"></h1>
    <h1>詳細:<input type="text" name="detail" value="{{$detail}}"></h1>
    <h1>候補日:</h1>
    @foreach($possible_dates as $date)
        <input type="datetime-local" name="possible_dates[]" value="{{$date}}">
    @endforeach
    <button type="submit">編集</button>
</form>
