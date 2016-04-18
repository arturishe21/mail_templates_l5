"use strict";

var Emails = {

    init: function()
    {
        Emails.startLoad()
    },

    startLoad: function()
    {
        var id_edit_page = Core.urlParam('id_template');
        if($.isNumeric(id_edit_page)){
            Emails.getEdit(id_edit_page);
        }
    },

    loadForm: function()
    {
        var $checkoutForm = $('#form_page').validate({
            submitHandler: function(form) {
                /*
                 $( ".text_block" ).each(function( index ) {
                 var text = $(this).editable("getHTML", true, true);
                 $("textarea[name="+$(this).attr("name")+"]").val(text);
                 });*/

                Emails.AddRec();

            },
            rules : {
                title : {
                    required : true
                },
                slug : {
                    required : true
                }
            },

            // Messages for form validation
            messages : {
                title : {
                    required : 'Нужно заполнить заголовок'
                },
                slug : {
                    required : 'Нужно заполнить алиас '
                }

            },
            // Do not change code below
            errorPlacement : function(error, element) {
                error.insertAfter(element.parent());
            }
        });

        TableBuilder.initFroalaEditor();
    },

    Create: function()
    {
        $("#modal_form").modal('show');
        Emails.preloadPage();
        $.post("/admin/emails/create_pop", {},
            function(data){
                $("#modal_form .modal-content").html(data);
                Emails.loadForm();
            });
    },

    show_list: function()
    {
        doAjaxLoadContent(window.location.href);
        $(".modal-backdrop").remove();
    },

    AddRec: function()
    {
        $.post("/admin/emails/add_record", {data : $('#form_page').serialize() },
            function(data){
                if (data.status=="ok") {

                    TableBuilder.showSuccessNotification(data.ok_messages);

                    $("#modal_form").modal('hide');
                    Emails.show_list(1);
                }else{

                    var mess_error = ""
                    $.each( data.errors_messages, function( key, value ) {
                        mess_error+= value+"<br>";
                    });

                    TableBuilder.showErrorNotification(mess_error);

                }
            },"json");
    },

    getEdit: function(this_id_pages)
    {
        $("#modal_form").modal('show');
        Emails.preloadPage();

        var url_page = "?id_template="+this_id_pages;
        window.history.pushState(url_page, '', url_page);

        $.post("/admin/emails/edit_record", {id:this_id_pages },
            function(data){
                $("#modal_form .modal-content").html(data);
                Emails.loadForm();
            });
    },

    preloadPage: function(){
        var preloadHtml = '<div id="table-preloader" class="text-align-center"><i class="fa fa-gear fa-4x fa-spin"></i></div>';
        $("#modal_form .modal-content").html(preloadHtml);
    },

    doDelete: function(id, context)
    {
        jQuery.SmartMessageBox({
            title : "Удалить?",
            content : "Эту операцию нельзя будет отменить.",
            buttons : '[Нет][Да]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Да") {
                jQuery.ajax({
                    type: "POST",
                    url: "/admin/emails/delete",
                    data: { id: id},
                    dataType: 'json',
                    success: function(response) {

                        if (response.status) {

                            TableBuilder.showSuccessNotification("Запись удалена успешно");

                            $(".tr_"+id).remove();
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
    Emails.init();
    $(document).on('click', '#modal_form .close, .modal-footer button', function (e) {
        var url = Core.delPrm("id_template");
        window.history.pushState(url, '', url);
    });
});
