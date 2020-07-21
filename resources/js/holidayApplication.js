/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
var moment = require('moment')


//time-pickerの値を受け取り差の時間を返す
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

//活性・非活性判定
const disabled = () => {     
    if ($('#types option:selected').data("code") == 'half') {　//option:selected data属性の選択
        $('#date_to').prop('disabled', true);
        $('#date').prop('disabled', true);
        $('#time_from').prop('disabled', false);
        $('#time_to').prop('disabled', false);
        $('#time').prop('disabled', false);
    }
    else {
        $('#date_to').prop('disabled', false);
        $('#date').prop('disabled', false);
        $('#time_from').prop('disabled', true);
        $('#time_to').prop('disabled', true);
        $('#time').prop('disabled', true);
    }
}
//種別の変更時、非活性の値をクリアする
const clear = () => {
    if ($('#types option:selected').data("code") == 'half') {
        $('#date_to').val("");
        $('#date').val("");
    }
    else if($('#types option:selected').data("code") != 'half'){
        $('#time_from').val("");
        $('#time_to').val("");
        $('#time').val("");
    }
}

$(document).ready(function () {
    disabled();

    var date_start_val = $('#date_start').val();
        var date_end_val = $('#date_end').val();
        if (date_start_val != '' && date_end_val != '') {
            $('#dateSpan').val(getBussinessDays($('#date_start').val(), $('#date_end').val()));
    };
    var start = $('#time_start').val();
        var end = $("#time_end").val();
        if (start != "" && end != "") {
            $('#timeSpan').val(getBussinessHours($('#time_start').val(), $('#time_end').val()));
    };
    $('#time_from').datepicker({
        format: 'H:i',
    });
    $('#time_to').datepicker({
        format:'H:i',
    });
});
$(function () {    
    $('#types').on('change', function () {      
        disabled();
        clear();
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

    //日数計算
    $('#date_from').on('change', function () {  
        var date_from_val = $('#date_from').val();
        var date_to_val = $('#date_to').val();
        if (date_from_val != '' && date_to_val != '') {
            $('#date').val(getBussinessDays($('#date_from').val(), $('#date_to').val()));
        }
    });
    $('#date_to').on('change', function () {
        var date_from_val = $('#date_from').val();
        var date_to_val = $('#date_to').val();
        if (date_from_val != '' && date_to_val != '') {
            $('#date').val(getBussinessDays($('#date_from').val(), $('#date_to').val()));
        }
    });

    //時間の取得
    myTimePicker.initTime($('#time_from'), '08:00', '24:00', 15); 
    myTimePicker.initTime($('#time_to'), '08:00', '24:00', 15);
    
    //時間の計算
    $('#time_from').on('change', function () {  
        var start = $('#time_from').val();
        var end = $("#time_to").val();
        if (start != "" && end != "") {
            $('#time').val(getBussinessHours($('#time_from').val(), $('#time_to').val()));
        }        
    });   
    $('#time_to').on('change', function () {
        var start = $('#time_from').val();
        var end = $("#time_to").val();
        if (start != "" && end != "") {
            $('#time').val(getBussinessHours($('#time_from').val(), $('#time_to').val()));
        }
    });
})
