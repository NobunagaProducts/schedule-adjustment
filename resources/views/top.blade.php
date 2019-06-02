<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>タイトル</title>
</head>
<body>
<form method="POST" action="/">
    @csrf
    <div>
        イベント名：<input type="text" name="event_name" size="40">
    </div>
    <div>
        詳細: <input type="text" name="detail" size="40">
    </div>
    <div>
        候補日:<input type="datetime-local" name="input" id="input-date">
        <input type="button" name="input" onclick="OnButtonClick();" value="入力">
    </div>
    <div id="possible_dates_list">
    </div>
    <input type="submit" id="create-event-button">
</form>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script>
    function OnButtonClick() {
        var dateList = document.getElementById('possible_dates_list');
        var dateElement =
            `<div class="input-group mb-3">
                <input type="datetime-local" class="form-control"  aria-describedby="basic-addon2" name="possible_dates[]">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" onclick="OnButtonDelete(this)">☓</button>
                </div>
            </div>`;
        // 日付入力結果の枠を作成。
        dateList.insertAdjacentHTML('afterbegin', dateElement);
        // 日付入力欄の値を結果欄に反映。
        document.getElementById('possible_dates_list').children[0].children[0].value = document.getElementById("input-date").value;
    }

    //
    function OnButtonDelete(deleteButton) {
        deleteButton.parentNode.parentNode.remove();
    }

    function setAttributes(el, attrs) {
        for (var key in attrs) {
            el.setAttribute(key, attrs[key]);
        }
    }
</script>
</body>
</html>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<title>Hello, world!</title>
