//修正・取消モード切替
const transition = (form, action, method) => {
    const beforeAction = form.attr('action') || '';
    const beforeMethod = form.attr('method') || '';
    form.attr('action', action);
    form.attr('method', method);
    form.submit();
    form.attr('action', beforeAction);
    form.attr('method', beforeMethod);
}

//修正・取消切替え
$(function () {
    $('.update').on('click', function () {
        transition($('#edit'), $('.update').data('href'), 'get');
    });

    $('.delete').on('click', function () {
        transition($('#edit'), $('.delete').data('href'), 'post');
    })

    $('.calendar').on('dp.change', function () { totalBusinessDays() });


})