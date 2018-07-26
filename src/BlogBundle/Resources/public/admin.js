$(function () {
    $('.delete-tag').click(function (e) {
        $(this).parent().remove();
    });

    $('#add-tag').click(function (e) {
        var list = $($(this).attr('data-list'));
        var counter = list.data('widget-counter') | list.children().length;
        if (!counter) { counter = list.children().length; }

        var newWidget = list.attr('data-prototype');
        newWidget = newWidget.replace(/__name__/g, counter);
        counter++;
        list.data(' widget-counter', counter);

        var newElem = $(list.attr('data-widget-tags')).html(newWidget);
        newElem.appendTo(list);
    });
});