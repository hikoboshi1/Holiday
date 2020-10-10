/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('jquery-timepicker/jquery.timepicker');
require('bootstrap4-datetimepicker/build/js/bootstrap-datetimepicker.min');
require('./my-timepicker');

var moment = require('moment')


//timepickerの値を受け取り差の時間を返す
const getBussinessHours = function (start, end) {
    if ((start != '') && (end != '') && (end > start)) {
        let startMoment = moment(start, "HH:mm");
        let endMoment = moment(end, "HH:mm");
        let bussinessHours = endMoment.diff(startMoment, 'h', true);
        return bussinessHours;
    } else {
        return 'エラー';
    }
}
//timepicker変更時、時間を取得 関数
const totalBusinessHours = () => {
    if ($('#time_from').val() != "" && $('#time_to').val() != "") {
        $('#time').val(getBussinessHours($('#time_from').val(), $('#time_to').val()))
    }    
}

//Ajax通信で合計期間算出 関数
const totalBusinessDays = () => {
    if ($('#holiday_date_from').val() != '' && ($('#holiday_date_to').val() != '')) {
        $.ajax({
            url: '/dcfportal/get_holiday_duration',
            type: 'GET',
            data: {
                'holiday_date_from': $('#holiday_date_from').val(),
                'holiday_date_to': $('#holiday_date_to').val()
            }
        }).done(data => $('#total_date').val(data));
    }
}

//種別:半休選択時 関数
const dateAndTime = () => {     
    if ($('#types option:selected').data("code") == 'half') {　//option:selected data属性の選択
        $('#holiday_date_to').prop('disabled', true);
        $('#holiday_date_to').val(null);
        $('#total_date').val(0.5);
        $('.timepicker').prop('disabled', false);
        $('#time').prop('disabled', false);
        totalBusinessHours();

    }
    else {
        $('#holiday_date_to').prop('disabled', false);
        $('#total_date').val(null);
        $('.timepicker').prop('disabled', true);
        $('.timepicker').val(null);
        $('#time').prop('disabled', true);
        $('#time').val(null);
        totalBusinessDays();

    }
}

$(function () {
    //時間のフォーマット
    $('#time_from').datepicker({
        format: 'H:i',
    });
    $('#time_to').datepicker({
        format:'H:i',
    });    
    
    //種別変更時
    $('#types').on('change', function () {      
        dateAndTime();    
    });

    //画面遷移時
    dateAndTime();

    //時間の取得
    myTimePicker.initTime($('#time_from'), '09:00', '18:00', 15); 
    myTimePicker.initTime($('#time_to'), '09:00', '18:00', 15);
    $('.timepicker').on('change', function () { totalBusinessHours() });
    
    //詳細:total時間取得
    if ($('#time_from').val() != '' && $('#time_to').val() != '') {
        $('#time').val()(totalBusinessHours($('#time_from').val(), $('#time_to').val()));
    } 
});

$(function () { 
    //カレンダー追加と土日の非活性
    $('.calendar').datepicker({
        beforeShowDay: function (date) {
            if (date.getDay() == 0 || date.getDay() == 6) {
                return [false, 'ui-state-disabled'];
            } else {
                return [true, ''];
            }
        }
    });

    //Ajaxで期間取得
    $('.calendar').on('change',  totalBusinessDays);

})  