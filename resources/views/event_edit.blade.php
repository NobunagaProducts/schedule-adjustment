<form action="/event/edit" method="post">
    @csrf
    <h1>イベント名:<input type="text" name="event_name" value="{{$event_name}}"></h1>
    <h1>詳細:<input type="text" name="detail" value="{{$detail}}"></h1>
    <h1>候補日:<input type="text" name="possible_date" value="{{$possible_date}}"></h1>
    <button type="submit">編集</button>
</form>
