/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 23 July 2017, 11:59 AM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

(function ($) {
    $(function () {
        var create_selector     = "div#create_item";
        var table_report        = 'table#table_gardu_index';
        var table               = $(table_report).DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "language": {
                "url": $('meta[name="datatable_lang"]').attr('content')
            }
        });
        var retriever           = $('meta[name="retriever"]').attr('content');
        var induk_retriever     = $('meta[name="induk_retriever"]').attr('content');
        var penyulang_retriever = $('meta[name="penyulang_retriever"]').attr('content');
        var deleter             = $('meta[name="deleter"]').attr('content');
        var editer              = $('meta[name="editer"]').attr('content');
        var detail              = $('meta[name="detail"]').attr('content');
        var creator             = $('meta[name="creator"]').attr('content');

        $(table_report).on('click', 'button.c-del-button', function (event) {
            event.preventDefault();
            var user_id = $(this).attr('dx-user');
            if (user_id !== undefined
                && deleter !== undefined)
            {
                var data        = {};
                data['user_id'] = user_id;
                confirm("Yakin ingin menghapus data ini?");
                NProgress.start();
                $.ajax({
                    url: deleter,
                    data: data,
                    type: 'DELETE',
                    dataType: 'json'
                })
                    .done(function (response) {
                        var kind   = ['notify', 'message'];
                        var type   = ['validation', 'delete'];
                        var status = ['danger', 'info', 'warning', 'success'];
                        if (response['data'] !== undefined)
                        {
                            if (response['data']['message'] !== undefined)
                            {
                                for (var i = -1, is = kind.length; ++i < is;)
                                {
                                    if (response['data']['message'][kind[i]] !== undefined)
                                    {
                                        for (var j = -1, js = type.length; ++j < js;)
                                        {
                                            if (response['data']['message'][kind[i]][type[j]] !== undefined)
                                            {
                                                for (var k = -1, ks = status.length; ++k < ks;)
                                                {
                                                    if (response['data']['message'][kind[i]][type[j]][status[k]] !== undefined)
                                                    {
                                                        if (kind[i] === 'notify')
                                                        {
                                                            //noinspection JSDuplicatedDeclaration
                                                            for (var l = -1, ls = response['data']['message'][kind[i]][type[j]][status[k]].length; ++l < ls;)
                                                            {
                                                                $.notify({
                                                                    message: response['data']['message'][kind[i]][type[j]][status[k]][l]
                                                                }, {
                                                                    type: status[k]
                                                                });
                                                            }
                                                        }
                                                        else
                                                        {

                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            if (response['data']['redirect'] !== undefined)
                            {
                                location.href = response['data']['redirect'];
                            }

                            if (response['data']['status'] !== undefined)
                            {
                                if (response['data']['status'] === 1)
                                {
                                    retreiveData(table, retriever, NProgress);
                                }
                            }
                        }
                    })
                    .fail(function () {
                    })
                    .always(function () {
                        NProgress.done();
                    });
            }


        });

        $(table_report).on('click', 'button.c-upd-button', function (event) {
            event.preventDefault();

            var c_jenis   = $(this).attr('dx-jenis');
            var c_no      = $(this).attr('dx-no');
            var c_lokasi  = $(this).attr('dx-lokasi');
            var c_merk    = $(this).attr('dx-merk');
            var c_serial  = $(this).attr('dx-serial');
            var c_fasa    = $(this).attr('dx-fasa');
            var c_tap     = $(this).attr('dx-tap');
            var c_jurusan = $(this).attr('dx-jurusan');
            var c_lat     = $(this).attr('dx-lat');
            var c_long    = $(this).attr('dx-long');
            if (c_jenis !== undefined
                && c_no !== undefined
                && c_lokasi !== undefined
                && c_merk !== undefined
                && c_serial !== undefined
                && c_fasa !== undefined
                && c_tap !== undefined
                && c_jurusan !== undefined
                && c_lat !== undefined
                && c_long !== undefined
                && editer !== undefined)
            {
                var update_form_selector = 'form#update_gardu_index';
                $(update_form_selector).find("input#update_no").val(c_no);
                $(update_form_selector).find("input#update_lokasi").val(c_lokasi);
                $(update_form_selector).find("input#update_merk").val(c_merk);
                $(update_form_selector).find("input#update_serial").val(c_serial);
                $(update_form_selector).find("input#update_fasa").val(c_fasa);
                $(update_form_selector).find("input#update_tap").val(c_tap);
                $(update_form_selector).find("input#update_jurusan").val(c_jurusan);
                $(update_form_selector).find("input#update_lat").val(c_lat);
                $(update_form_selector).find("input#update_long").val(c_long);
                $(update_form_selector).find("select#update_jenis").find("option[value=\"" + c_jenis + "\"]").prop('selected', true);
                $('div#update_item').modal('show');
            }
        });

        var retreiveData = function (table, link, progress) {
            progress.start();
            $.ajax({
                type: 'get',
                url: link,
                dataType: 'json'
            })
                .done(function (response) {
                    var kind   = ['notify', 'message'];
                    var type   = ['find'];
                    var status = ['danger', 'info', 'warning', 'success'];
                    if (response['data'] !== undefined)
                    {
                        var i, j, k, l, is, js, ks, ls;
                        if (response['data']['message'] !== undefined)
                        {
                            for (i = -1, is = kind.length; ++i < is;)
                            {
                                if (response['data']['message'][kind[i]] !== undefined)
                                {
                                    for (j = -1, js = type.length; ++j < js;)
                                    {
                                        if (response['data']['message'][kind[i]][type[j]] !== undefined)
                                        {
                                            for (k = -1, ks = status.length; ++k < ks;)
                                            {
                                                if (response['data']['message'][kind[i]][type[j]][status[k]] !== undefined)
                                                {
                                                    if (kind[i] === 'notify')
                                                    {
                                                        //noinspection JSDuplicatedDeclaration
                                                        for (l = -1, ls = response['data']['message'][kind[i]][type[j]][status[k]].length; ++l < ls;)
                                                        {
                                                            $.notify({
                                                                message: response['data']['message'][kind[i]][type[j]][status[k]][l]
                                                            }, {
                                                                type: status[k]
                                                            });
                                                        }
                                                    }
                                                    else
                                                    {

                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        if (response['data']['gardu_index'] !== undefined)
                        {
                            var contents = response['data']['gardu_index'];
                            table.clear();
                            for (i = table.data().count() - 1, is = contents.length; ++i < is;)
                            {
                                var content = contents[i];
                                var del     = "<button class='btn btn-danger btn-xs c-del-button' dx-user='" + content['no'] + "' type='button' data-toggle='tooltip' data-placement='right' title='Hapus'><i class='fa fa-trash-o'></i></button>";
                                var upd     = "<button class='btn btn-info btn-xs c-upd-button' " +
                                    "dx-jenis='" + content['jenis'] + "' " +
                                    "dx-no='" + content['no'] + "' " +
                                    "dx-lokasi='" + content['lokasi'] + "' " +
                                    "dx-merk='" + content['merk'] + "' " +
                                    "dx-serial='" + content['serial'] + "' " +
                                    "dx-fasa='" + content['fasa'] + "' " +
                                    "dx-tap='" + content['tap'] + "' " +
                                    "dx-jurusan='" + content['jurusan'] + "' " +
                                    "dx-lat='" + content['lat'] + "' " +
                                    "dx-long='" + content['long'] + "' " +
                                    "type='button' data-toggle='tooltip' data-placement='right' title='Edit'><i class='fa fa-edit'></i></button>";
                                var dtl     = "<a class='btn btn-info btn-xs' type='button' href='" + sprintf(detail, content['no']) + "' data-toggle='tooltip' data-placement='right' title='Detail'><i class='fa fa-search'></i></a>";
                                table.row.add([content['induk_id'], content['penyulang_id'], content['no'], content['lokasi'], dtl + "&nbsp;&nbsp;" + upd + "&nbsp;&nbsp;" + del]);
                            }
                            table.draw(true);
                        }
                    }
                    progress.done();
                })
                .fail(function () {
                    progress.done();
                });
        };

        $('form#create_gardu_index').on('submit', function (event) {
            event.preventDefault();
            var form = $(this);

            var input = form.serializeObject();

            NProgress.start();
            $.post(
                form.attr('action'),
                input,
                null,
                'json')
                .done(function (response) {
                    var kind   = ['notify', 'message'];
                    var type   = ['validation', 'register'];
                    var status = ['danger', 'info', 'warning', 'success'];
                    if (response['data'] !== undefined)
                    {
                        if (response['data']['message'] !== undefined)
                        {
                            for (var i = -1, is = kind.length; ++i < is;)
                            {
                                if (response['data']['message'][kind[i]] !== undefined)
                                {
                                    for (var j = -1, js = type.length; ++j < js;)
                                    {
                                        if (response['data']['message'][kind[i]][type[j]] !== undefined)
                                        {
                                            for (var k = -1, ks = status.length; ++k < ks;)
                                            {
                                                if (response['data']['message'][kind[i]][type[j]][status[k]] !== undefined)
                                                {
                                                    if (kind[i] === 'notify')
                                                    {
                                                        //noinspection JSDuplicatedDeclaration
                                                        for (var l = -1, ls = response['data']['message'][kind[i]][type[j]][status[k]].length; ++l < ls;)
                                                        {
                                                            $.notify({
                                                                message: response['data']['message'][kind[i]][type[j]][status[k]][l]
                                                            }, {
                                                                type: status[k]
                                                            });
                                                        }
                                                    }
                                                    else
                                                    {
                                                        var template = '<div class="alert alert-' + status[k] + ' alert-dismissible">'
                                                            + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                                                            + '<ul>';
                                                        //noinspection JSDuplicatedDeclaration
                                                        for (var l = -1, ls = response['data']['message'][kind[i]][type[j]][status[k]].length; ++l < ls;)
                                                        {
                                                            template += '<li>' + response['data']['message'][kind[i]][type[j]][status[k]][l] + '</li>'
                                                        }
                                                        template += '</ul>'
                                                            + '</div>';
                                                        $("div#form-creation-message-container").empty().append(template);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        if (response['data']['csrf'] !== undefined)
                        {
                            $(form).find('input:hidden[name=' + response['data']['csrf']['name'] + ']').val(response['data']['csrf']['hash']);
                        }

                        if (response['data']['status'] !== undefined)
                        {
                            if (response['data']['status'] === 1)
                            {
                                $(form).find('input:text, input:password').each(function () {
                                    $(this).val('');
                                });
                            }
                        }
                    }
                })
                .fail(function () {
                })
                .always(function () {
                    NProgress.done();
                });
        });

        $('form#update_gardu_index').on('submit', function (event) {
            event.preventDefault();
            var form = $(this);

            var input = form.serializeObject();

            NProgress.start();
            $.ajax({
                url: form.attr('action'),
                data: input,
                type: 'PATCH',
                dataType: 'json'
            })
                .done(function (response) {
                    var kind   = ['notify', 'message'];
                    var type   = ['validation', 'update'];
                    var status = ['danger', 'info', 'warning', 'success'];
                    if (response['data'] !== undefined)
                    {
                        if (response['data']['message'] !== undefined)
                        {
                            for (var i = -1, is = kind.length; ++i < is;)
                            {
                                if (response['data']['message'][kind[i]] !== undefined)
                                {
                                    for (var j = -1, js = type.length; ++j < js;)
                                    {
                                        if (response['data']['message'][kind[i]][type[j]] !== undefined)
                                        {
                                            for (var k = -1, ks = status.length; ++k < ks;)
                                            {
                                                if (response['data']['message'][kind[i]][type[j]][status[k]] !== undefined)
                                                {
                                                    if (kind[i] === 'notify')
                                                    {
                                                        //noinspection JSDuplicatedDeclaration
                                                        for (var l = -1, ls = response['data']['message'][kind[i]][type[j]][status[k]].length; ++l < ls;)
                                                        {
                                                            $.notify({
                                                                message: response['data']['message'][kind[i]][type[j]][status[k]][l]
                                                            }, {
                                                                type: status[k]
                                                            });
                                                        }
                                                    }
                                                    else
                                                    {
                                                        var template = '<div class="alert alert-' + status[k] + ' alert-dismissible">'
                                                            + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                                                            + '<ul>';
                                                        //noinspection JSDuplicatedDeclaration
                                                        for (var l = -1, ls = response['data']['message'][kind[i]][type[j]][status[k]].length; ++l < ls;)
                                                        {
                                                            template += '<li>' + response['data']['message'][kind[i]][type[j]][status[k]][l] + '</li>'
                                                        }
                                                        template += '</ul>'
                                                            + '</div>';
                                                        $("div#form-update-message-container").empty().append(template);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        if (response['data']['csrf'] !== undefined)
                        {
                            $(form).find('input:hidden[name=' + response['data']['csrf']['name'] + ']').val(response['data']['csrf']['hash']);
                        }

                        if (response['data']['status'] !== undefined)
                        {
                            if (response['data']['status'] === 1)
                            {
                                $('div#update_item').modal('hide');
                                retreiveData(table, retriever, NProgress);
                            }
                        }
                    }
                })
                .fail(function () {
                })
                .always(function () {
                    NProgress.done();
                });
        });

        $(create_selector).on('hide.bs.modal', function (e) {
            retreiveData(table, retriever, NProgress);
        });

        $(create_selector).on('show.bs.modal', function (e) {

            if ((induk_retriever !== undefined) && (induk_retriever !== null))
            {
                NProgress.start();
                $.ajax({
                    type: 'get',
                    url: induk_retriever,
                    dataType: 'json'
                })
                    .done(function (response) {
                        var i;
                        if (response['data'] !== undefined)
                        {
                            if (response['data']['gardu_induk'] !== undefined)
                            {
                                var contents = response['data']['gardu_induk'];
                                for (var i = -1, is = contents.length; ++i < is;)
                                {
                                    var content = contents[i];
                                    $('select#create_induk_id').append('<option value="' + content['id'] + '">' + content['name'] + '</option>');
                                }
                            }
                        }
                        NProgress.done();
                    })
            }

            if ((penyulang_retriever !== undefined) && (penyulang_retriever !== null))
            {
                NProgress.start();
                $.ajax({
                    type: 'get',
                    url: penyulang_retriever,
                    dataType: 'json'
                })
                    .done(function (response) {
                        var i;
                        if (response['data'] !== undefined)
                        {
                            if (response['data']['gardu_penyulang'] !== undefined)
                            {
                                var contents = response['data']['gardu_penyulang'];
                                for (var i = -1, is = contents.length; ++i < is;)
                                {
                                    var content = contents[i];
                                    $('select#create_penyulang_id').append('<option value="' + content['id'] + '">' + content['name'] + '</option>');
                                }
                            }
                        }
                        NProgress.done();
                    })
            }
        });

        if ((retriever !== undefined) && (retriever !== null))
        {
            retreiveData(table, retriever, NProgress);
        }
    });
    /*
     * Run right away
     * */
})(jQuery);

