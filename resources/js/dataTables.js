const dataTableMyOptions = {
    paging: true,
    lengthChange: false,
    searching: false,
    ordering: true,
    info: true,
    autoWidth: false,
    order: [],
    language: {
      processing: "処理中...",
      search: "検索",
      lengthMenu: "_MENU_件表示",
      info: "_TOTAL_ 件中 _START_ 件目から _END_ 件目まで表示",
      infoEmpty: "データが1件もありません",
      infoFiltered: "（全 _MAX_ 件より抽出）",
      infoPostFix: "",
      zeroRecords: "データが1件もありません",
      emptyTable: "データが1件もありません",
      paginate: {
        first: "最初",
        previous: "前",
        next: "次",
        last: "最後"
      }
    }
};
  
const initJsonDataTable = (table, options) => {
    if (table.length === 0) return;

    const columns = options['columns'] || table.data('title').split(',');
    const renders = options['renders'] || [];
    const widths = options['widths'] || table.data('widths');

    let columnDefs = {};

    columnDefs = columns.map((column, i) => (
        {
            title: column,
            targets: i,
            data: i,
            className: 'align-middle text-center',
            width: widths[i]
        }
    ));
    
    Object.keys(renders).forEach(i => (columnDefs[i]['render'] = renders[i]));
    table.dataTable({
        ...dataTableMyOptions,
        data: table.data('json'),
        columnDefs: columnDefs
    });
    debugger;
};
const showButton = data => {
    return '<a href=' + data + '><button type="button" class="btn btn-block btn-primary">詳細</button></a>';
}
const initialize = () => {
    initJsonDataTable($('#userTable'), {
        renders: {
            4: data => showButton(data)
        }
    });
    initJsonDataTable($('#adminTable'), {
        renders: {
            5: data => showButton(data)
        }
    });
}

$(function () {
    initialize();
})