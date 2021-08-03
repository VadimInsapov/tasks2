let today = new Date();
let dd = today.getDate();
let mm = today.getMonth() + 1; //January is 0 so need to add 1 to make it 1!
let yyyy = today.getFullYear();
let hour = today.getHours();
let minute = today.getMinutes();
if (dd < 10) {
    dd = '0' + dd
}
if (mm < 10) {
    mm = '0' + mm
}
if (hour < 10) {
    hour = '0' + hour
}
if (minute < 10) {
    minute = '0' + minute
}
today = yyyy + '-' + mm + '-' + dd + "T" + hour + ":" + minute;
$('.min-date-today').attr('min', today);

$('.task').each(function () {
    let datetimeFinish = $(this).find('.date-finish').text();
    let dateFinish = datetimeFinish.split(' ')[0];
    let timeFinish = datetimeFinish.split(' ')[1];

    let ddF = +(dateFinish.split('.')[0]);
    let mmF = +(dateFinish.split('.')[1]);
    let yyF = +('20' + dateFinish.split('.')[2]);
    let hourF = +(timeFinish.split(':')[0]);
    let minuteF = +(timeFinish.split(':')[1]);

    if (+ddF < 10) {
        ddF = '0' + ddF;
    }
    if (+mmF < 10) {
        mmF = '0' + mmF;
    }
    if (+hourF < 10) {
        hourF = '0' + hourF;
    }
    if (+minuteF < 10) {
        minuteF = '0' + minuteF;
    }

    let s = yyF + '-' + mmF + '-' + ddF + "T" + hourF + ":" + minuteF;
    let DateFinish = new Date(s);
    let DateToday = new Date();
    let status = $(this).find('.choose-status').text();
    if (DateFinish < DateToday && status != "выполнена") $(this).css('background', '#F37B57');
    if (status == "выполнена") $(this).css('background', '#57f37b');
    $(this).next().next().find('.fill-update-date').attr('value', s);
});