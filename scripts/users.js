$(document).ready(ready);

function ready() {
    user.load();
}

var user = {
    textTimeout: null,
    option: {
        page: 1,
        stext: null,
        limit: 10,
        isdel: false,
    },
    load: function () {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "services/service",
            data: {
                s: 'general',
                f: 'load',
                p: user.option
            },
            success: function (response) {
                if (response.success) {
                    user.option.page = response.page;
                    //---------------------------
                    var tbl = $('#tblUsers tbody');
                    tbl.html("");
                    if (response.count == 0) {
                        $('#tblInfo').html('<i class="fa fa-info-circle fa-fw fa-lg"></i>Kayıt bulunamadı').css({
                            "font-style": "italic",
                            "color": "#9055A2"
                        });
                        return;
                    }
                    for (i in response.data) {
                        tbl.append("<tr><td style='width:90px;'>" + (parseInt(user.option.limit * (user.option.page - 1)) + parseInt(i) + parseInt(1)) + "</td>" +
                            "<td style='width: auto;'>" + response.data[i].isim + " " + response.data[i].soyisim + "</td>" +
                            "<td style='width: auto;' class='hidden-xs'>" + response.data[i].eposta + "</td><td class='hidden-xs' style='width: auto;'>" + response.data[i].sirket + "</td>" +
                            "<td class='hidden-xs' style='width: auto;'>" + response.data[i].yetki + "</td>" +
                            "<td style='width: auto;' class='hidden-xs'>" + response.data[i].ceptel + "</td>" +
                            "<td style='width: auto;'>" + response.data[i].sirkettel +

                            '<div class="btn-group pull-right">' +
                            '<div class="btn-group dropleft" role="group">' +
                            '<a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            '<i class="fa fa-ellipsis-v"></i>' +
                            '</a>' +
                            '<div class="dropdown-menu">' +
                            '<button class="btn btn-sm btn-dark btn-block nom" onclick="user.update(' + response.data[i].id + ',false)">Güncelle</button>' +
                            '<button class="btn btn-sm btn-dark btn-block nom" onclick="user.delete(' + response.data[i].id + ',false)">Sil</button>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</td></tr>');

                    }
                    //---------------------------
                    $('#pnav').html('<li class="page-item" data-val="prev"><a class="page-link"><i class="fa fa-chevron-left"></i></a></li>');
                    for (var i = 1; i <= response.pcount; i++) {
                        $('#pnav').append('<li class="page-item" data-val="' + i + '"><a class="page-link">' + i + '</a></li>');
                    }
                    $('#pnav').append('<li class="page-item" data-val="next"><a class="page-link"><i class="fa fa-chevron-right"></i></a></li>');
                    $('.page-item[data-val="' + response.page + '"]').addClass('active');
                    //---------------------------
                    user.events();
                } else {

                }
            }
        });
    },
    events: function () {
        $('#text').off('keydown').on('keydown', user.setText);
        $('.page-item').off('click').on('click', user.setPage);
        $('#slcLimit').off('change').on('change', user.setLimit);
    },
    setText: function () {
        if (user.textTimeout != null) {
            clearTimeout(user.textTimeout);
            user.textTimeout = null;
        }
        user.textTimeout = setTimeout(function () {
            if ($('#text').val().length > 2) {
                user.option.stext = $('#text').val();
            } else {
                user.option.stext = null;
            }
            user.load();
        }, 500);
    },
    setPage: function () {
        var np = $(this).attr('data-val');
        if (np == "prev") {
            if (user.option.page != 1) user.option.page--;
        } else if (np == "next") {
            if (user.option.page != ($($('.page-item')[$('.page-item').length - 2]).attr('data-val') * 1)) user.option.page++;
        } else {
            user.option.page = np * 1;
        }
        user.load();
    },
    setLimit: function () {
        user.option.limit = $(this).val();
        user.load();
    },
    add: function () {
        var modal = $('#mdlAddUser');
        $.ajax({
            url: "./services/service",
            type: "POST",
            dataType: "JSON",
            data: {
                s: "general",
                f: "UserAdd",
                p: {
                    firstname: modal.find('#firstname').val().trim(),
                    lastname: modal.find('#lastname').val().trim(),
                    mail: modal.find('#mail').val().trim(),
                    company: modal.find('#company').val(),
                    password: modal.find('#password').val().trim(),
                    again: modal.find('#again').val().trim(),
                    phone: modal.find('#phone').val().trim(),
                    phone_company: modal.find('#phone_company').val().trim(),
                    permission: modal.find('#permission').val()
                }
            },
            success: function (response) {
                if (response.success) {
                    modal.modal("hide");
                    user.load();
                } else {
                    alert(response.message);
                }
            }
        });
    },
    update: function (id, soru = false) {
        if (soru == false) {
            alert("güncelle");
        } else {

        }
    },
    delete: function (id, soru = false) {
        if (soru == false) {
            alert("güncelle");
        } else {

        }
    }
};
