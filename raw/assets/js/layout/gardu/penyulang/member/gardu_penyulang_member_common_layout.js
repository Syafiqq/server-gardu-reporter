/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 19 July 2017, 6:08 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

(function ($) {
    $(function () {
        var table_report = 'table#table_gardu_penyulang';
        var table        = $(table_report).DataTable({
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
        var retriever    = $('meta[name="retriever"]').attr('content');
        var deleter      = $('meta[name="deleter"]').attr('content');
        var editer       = $('meta[name="editer"]').attr('content');
        var creator      = $('meta[name="creator"]').attr('content');

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

            var user_id      = $(this).attr('dx-user');
            var user_content = $(this).attr('dx-content');
            if (user_id !== undefined
                && user_content !== undefined
                && editer !== undefined)
            {
                var update_form_selector = 'form#update_gardu_penyulang';
                $(update_form_selector).find("input#update_id").val(user_id);
                $(update_form_selector).find("input#update_name").val(user_content);
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

                        if (response['data']['gardu_penyulang'] !== undefined)
                        {
                            var contents = response['data']['gardu_penyulang'];
                            table.clear();
                            for (i = table.data().count() - 1, is = contents.length; ++i < is;)
                            {
                                var content = contents[i];
                                var del     = "<button class='btn btn-danger btn-xs c-del-button' dx-user='" + content['id'] + "' type='button' data-toggle='tooltip' data-placement='right' title='Hapus'><i class='fa fa-trash-o'></i></button></a>";
                                var upd     = "<button class='btn btn-info btn-xs c-upd-button' dx-user='" + content['id'] + "' dx-content='" + content['name'] + "' type='button' data-toggle='tooltip' data-placement='right' title='Edit'><i class='fa fa-edit'></i></button></a>";
                                table.row.add([content['id'], content['name'], upd + "&nbsp;&nbsp;" + del]);
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

        $('form#create_gardu_penyulang').on('submit', function (event) {
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

        $('form#update_gardu_penyulang').on('submit', function (event) {
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

        $('div#create_item').on('hide.bs.modal', function (e) {
            retreiveData(table, retriever, NProgress);
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

