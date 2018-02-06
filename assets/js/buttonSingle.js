{
    let selectorName = '#single-' + yiiOptionsSingle.selectorName;

    $(document).on('click', selectorName, function (e) {
        let ids = '{"ids":[' + $('#' + $(this).data('selector').replace('-ids', '')).yiiGridView('getSelectedRows').join(',') + ']}';
        let gridId = $(this).data('selector').replace('-ids', '');
        $(document).trigger("buttonSingle:click", [gridId, JSON.parse(ids)]);
    });
}
