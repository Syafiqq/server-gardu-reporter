/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 01 August 2017, 8:44 AM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

(function ($) {
    $(function () {

        var retriever = $('meta[name="retriever"]').attr('content');

        var retreiveData = function (link, progress) {
            progress.start();
            $.ajax({
                type: 'get',
                url: link,
                dataType: 'json'
            })
                .done(function (response) {
                    var kind = ['notify', 'message'];
                    var type = ['find'];
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
                            for (i = -1, is = contents.length; ++i < is;)
                            {
                                var content = contents[i];
                                $('select#common_no_gardu').append('<option value="' + content['no'] + '">' + content['no'] + '</option>');
                            }
                        }
                    }
                    progress.done();
                })
                .fail(function () {
                    progress.done();
                });
        };

        $('form#create_index_measurement').on('submit', function (event) {
            event.preventDefault();
            var form = $(this);

            var input = form.serializeObject();
            input = removeEmptyValues(input);

            $.confirm({
                title: 'Konfirmasi!',
                content: 'Dengan Ini data yang telah saya masukkan adalah benar dan dapat dipertanggungjawabkan',
                theme: 'bootstrap',
                buttons: {
                    confirm: {
                        btnClass: 'btn-blue',
                        action: function () {
                            NProgress.start();
                            $.post(
                                form.attr('action'),
                                input,
                                null,
                                'json')
                                .done(function (response) {
                                    var kind = ['notify', 'message'];
                                    var type = ['validation', 'register'];
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
                        }
                    },
                    cancel: function () {
                    }
                }
            });


        });

        if ((retriever !== undefined) && (retriever !== null))
        {
            retreiveData(retriever, NProgress);
        }

        setInterval(function () {
            moment.locale('id');
            var mmt = moment().tz('Asia/Jakarta');
            $('input#common_date').val(mmt.format('dddd, D MMMM YYYY'));
            $('input#common_time').val(mmt.format('HH:mm:ss zz'));
        }, 1000);
    });
    /*
     * Run right away
     * */
})(jQuery);
