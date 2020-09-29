/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
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
    if ($('#date_from').val() != '' && ($('#date_to').val() != '')) {
        $.ajax({
            url: 'dcfportal/get_holiday_duration',
            type: 'get',
            data: {
                'date_from': $('#date_from').val(),
                'date_to': $('#date_to').val()
            }
        }).done(data => $('#days').val(data));
    }
}

//これを廃止し、Ajax通信へ移行
//日付型の文字列を与え、土日を除いた日数を計算する
const getBussinessDays = (start, end) => {
    let businessDays = 0;
    let startDate = new Date(start);
    let endDate = new Date(end);
    
    if(startDate > endDate){
        return 'エラー';
    }  
    while(startDate <= endDate) {
        if (startDate.getDay() != 0 && startDate.getDay() != 6) {
            businessDays++;
        }
        startDate.setDate(startDate.getDate() + 1);
    }
    return businessDays;
}

//種別:半休選択時 関数
const dateAndTime = () => {     
    if ($('#types option:selected').data("code") == 'half') {　//option:selected data属性の選択
        $('#date_to').prop('disabled', true);
        $('#date_to').val(null);
        $('#total_days').val(0.5);
        $('.timepicker').prop('disabled', false);
        $('#time').prop('disabled', false);
        totalBusinessHours();

    }
    else {
        $('#date_to').prop('disabled', false);
        $('#total_days').val(null);
        $('.timepicker').prop('disabled', true);
        $('.timepicker').val(null);
        $('#time').prop('disabled', true);
        $('#time').val(null);
        totalBusinessDays();

    }
}
const time = () => {
    if ($('#time_from').val() != '' && $('#time_to').val() != '') {
        $('#time').val()(totalBusinessHours($('#time_from').val(), $('#time_to').val()));
    }
}
//画面遷移時
$(document).ready(function () {
    dateAndTime();
    time();
    //時間の取得
    myTimePicker.initTime($('#time_from'), '09:00', '18:00', 15); 
    myTimePicker.initTime($('#time_to'), '09:00', '18:00', 15);
    
    //時間のフォーマット
    $('#time_from').datepicker({
        format: 'H:i',
    });
    $('#time_to').datepicker({
        format:'H:i',
    });    
});
$(function () {
    //種別変更時
    $('#types').on('change', function () {      
        dateAndTime();
        
    });

    //カレンダー追加と土日の非活性
    $('#date_from').datepicker({
        beforeShowDay: function (date) {
            if (date.getDay() == 0 || date.getDay() == 6) {
                return [false, 'ui-state-disabled'];
            }else {
                return [true, ''];
            }
        }
    });
    
    $('#date_to').datepicker({
        beforeShowDay: function (date) {
            if (date.getDay() == 0 || date.getDay() == 6) {
                return [false, 'ui-state-disabled'];
            }else {
                return [true, ''];
            }
        }        
    });
    $('#submit_from').datepicker({
        beforeShowDay: function (date) {
            if (date.getDay() == 0 || date.getDay() == 6) {
                return [false, 'ui-state-disabled'];
            } else {
                return [true, ''];
            }
        }
    });
    $('#submit_to').datepicker({
        beforeShowDay: function (date) {
            if (date.getDay() == 0 || date.getDay() == 6) {
                return [false, 'ui-state-disabled'];
            } else {
                return [true, ''];
            }
        }
    });

    //Ajax通信に移行したら不要になる?
    //日数計算
    $('#date_from').on('change', function () {
        if ($('#date_from').val() != '' && $('#date_to').val() != '') {
            $('#total_days').val(getBussinessDays($('#date_from').val(), $('#date_to').val()));
        }
    });   
    $('#date_to').on('change', function () {
        if ($('#date_from').val() != '' && $('#date_to').val() != '') {
            $('#total_days').val(getBussinessDays($('#date_from').val(), $('#date_to').val()));
        }
    });    

    
    $('.calendar').on('dp.change', function () { totalBusinessDays() });
    $('.timepicker').on('change', function () { totalBusinessHours() });
})
