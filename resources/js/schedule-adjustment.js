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

function OnButtonDelete(deleteButton) {
    deleteButton.parentNode.parentNode.remove();

}
