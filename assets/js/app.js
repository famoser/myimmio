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
});