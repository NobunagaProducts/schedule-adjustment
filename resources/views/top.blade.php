<h1>トップ画面です。</h1>
<form method="POST" action="/">
    @csrf
    <div>
        イベント名：<input type="text" name="event_name" size="40">
    </div>
    <div>
        詳細: <input type="text" name="detail" size="40">
    </div>
    <div>
        候補日: <input type="datetime-local" name="possible_dates">
    </div>
    <input type="submit">
</form>
