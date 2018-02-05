let selectorName = '';
let key;
let comma = false;
for (key = 0; key < yiiOptions.length; ++key) {
    if (comma) {
        selectorName += ', .' + yiiOptions[key].selectorName;
    } else {
        comma = true;
        selectorName += '.' + yiiOptions[key].selectorName;
    }
}

$(document).on('click', selectorName, function (e) {
    e.preventDefault();
    let buttonSelector = '#parent-' + $(this).attr('class');
    if (confirm('Are you sure you want to "' + $(buttonSelector).text() + '" to "' + $(this).text() + '" for selected items?')) {
        let data = '{"status":' + $(this).data('status') + ',"ids":[' + $('#' + $(this).attr('class').replace('-ids', '')).yiiGridView('getSelectedRows').join(',') + ']}';
        let selectorSearch = 'input[name=' + $(this).data('field') + ']';
        $(selectorSearch).val(data);
        $(selectorSearch).change();
    }
});
