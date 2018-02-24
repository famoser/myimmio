require("../sass/app.sass");
var $ = require("jquery");
var bootstrap = require("bootstrap");

//prevent double submit & give user instant feedback
var disableFormButton = function () {
    var $form = $(this);
    var $buttons = $(".btn", $form);
    if (!$buttons.hasClass("no-disable")) {
        $buttons.addClass("disabled");
    }
};

//prevent double submit & give user instant feedback
var navigateTable = function () {
    var $tr = $(this);
    var target = $tr.attr("data-href");
    window.location = target;
};

$(document).ready(function () {
    $("form").on("submit", disableFormButton);
    $("tr[data-href]").on("click", navigateTable);

    $(".add-another-applicant-widget").click(function(e) {
        e.preventDefault();
        var list = $($(this).data('list'));
        var counter = list.data('widget-counter') | list.children().length;
        var newWidget = list.data('prototype');
        newWidget = newWidget.replace(/__name__/g, counter);
        counter++;
        list.data('widget-counter', counter);
        var newElem = $(list.data('widget-tags')).html(newWidget);
        newElem.appendTo(list);
    });
});