"use strict";

var Mailer = {

    init: function () {
        Mailer.startLoad()
    },

    startLoad: function () {
        var id_mailer = Core.urlParam('id_mailer');
        if ($.isNumeric(id_mailer)) {
            Mailer.getPreview(id_mailer);
        }
    },

    show_list: function()
    {
        doAjaxLoadContent(window.location.href);
        $(".modal-backdrop").remove();
    },

    preloadPage: function(){
        var preloadHtml = '<div id="table-preloader" class="text-align-center"><i class="fa fa-gear fa-4x fa-spin"></i></div>';
        $("#modal_form .modal-content").html(preloadHtml);
    },

    getPreview: function(thisIdPages)
    {
        $("#modal_form").modal('show');
        Mailer.preloadPage();

        var url_page = "?id_mailer="+thisIdPages;
        window.history.pushState(url_page, '', url_page);

        $.post("/admin/mailer/show_mail", {id:thisIdPages },
            function(data){
                $("#modal_form .modal-content").html(data);
            });
    },

    doDelete: function(id, context) {
        jQuery.SmartMessageBox({
            title: "Удалить?",
            content: "Эту операцию нельзя будет отменить.",
            buttons: '[Нет][Да]'
        }, function (ButtonPressed) {
            if (ButtonPressed === "Да") {
                jQuery.ajax({
                    type: "POST",
                    url: "/admin/mailer/delete",
                    data: {id: id},
                    dataType: 'json',
                    success: function (response) {

                        if (response.status) {

                            TableBuilder.showSuccessNotification("Запись удалена успешно");

                            $(".tr_" + id).remove();
                        } else {

                            TableBuilder.showErrorNotification("Что-то пошло не так, попробуйте позже");
                        }
                    }
                });

            }

        });
    }
};

$(window).load(function(){
    Mailer.init();
    $(document).on('click', '#modal_form .close, .modal-footer button', function (e) {
        var url = Core.delPrm("id_mailer");
        window.history.pushState(url, '', url);
    });
});