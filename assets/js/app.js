require("../sass/app.sass");
$ = require("jquery");
global.$ = $;
global.jQuery = $;
var bootstrap = require("bootstrap");
var dataTables = require("datatables.net");

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
    window.location = $tr.attr("data-href");
};

$(document).ready(function () {
    $("form").on("submit", disableFormButton);
    $("tr[data-href]").on("click", navigateTable);
    initializeLeafView();
    $(".add-another-applicant-widget").click(function (e) {
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

$(document).ready(function () {
    $('[data-labels]').each(function () {
        var $this = $(this);
        $this.css('width', $this.width());
    }).find('[data-id]').click(function (evt) {
        evt.preventDefault();
        evt.stopPropagation();
        var applicationId = this.parentNode.parentNode.dataset.id;
        var labelId = this.dataset.id;
        $(this).toggleClass('label-absent label-present');
        $.ajax({
            url: location.href + applicationId + '/toggleLabel/' + labelId
        });
    });

    $('[data-status] i').click(function (evt) {
        evt.preventDefault();
        evt.stopPropagation();
        var applicationId = this.parentNode.parentNode.dataset.id;
        var status = this.dataset.status;
        var $this = $(this);
        if ($this.hasClass('status-active')) {
            $this.removeClass('status-active');
        } else {
            $this.parent().find('.status-active').removeClass('status-active');
            $this.addClass('status-active');
        }
        $.ajax({
            url: location.href + applicationId + '/toggleStatus/' + status
        });
    });

    $('[data-table]').DataTable({
        paging: false,
        info: false,
        oLanguage: {
            sSearch: "Suchen"
        }
    });
    $('div.dataTables_filter input').addClass('form-control');
});

function initializeLeafView() {
    var leafActive = 0;
    var leafes = $(".leaf-view .leaf");
    $(leafes.get(0)).css("display", "block");

    var forwardButton = $(".leaf-view .go-forward");
    var backButton = $(".leaf-view .go-back");

    forwardButton.on("click", function (e) {
        e.preventDefault();
        $(leafes.get(leafActive)).css("display", "none");
        leafActive++;
        $(leafes.get(leafActive)).css("display", "block");
        backButton.css("display", "block");
        if (leafActive === leafes.length - 1) {
            forwardButton.css("display", "none")
        }
    });

    backButton.on("click", function (e) {
        e.preventDefault();
        $(leafes.get(leafActive)).css("display", "none");
        leafActive--;
        $(leafes.get(leafActive)).css("display", "block");
        backButton.css("display", "block");
        if (leafActive === 0) {
            backButton.css("display", "none");

        }
    })
}