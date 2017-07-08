/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 28 June 2017, 11:03 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

(function ($)
{
    $(function ()
    {
        NProgress.configure({
            showSpinner: false,
            template: '<div class="bar" role="bar" style="background-color: red"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div>'
        });

        $('form#login').on('submit', function (event)
        {
            event.preventDefault();
            var form = $(this);

            var input = form.serializeObject();

            input['remember_me'] = $(form).find('input:checkbox[name=remember_me]').prop('checked');
            if ((input['remember_me'] === undefined) || (input['remember_me'] === null))
            {
                input['remember_me'] = 0;
            }
            else
            {
                input['remember_me'] = input['remember_me'] ? 1 : 0;
            }

            NProgress.start();
            $.post(
                form.attr('action'),
                input,
                null,
                'json')
                .done(function (response)
                {
                    var status = ['danger', 'info', 'warning', 'success'];
                    var type = ['login', 'validation'];
                    if (response['data'] !== undefined)
                    {
                        if (response['data']['message'] !== undefined)
                        {
                            for (var i = -1, is = type.length; ++i < is;)
                            {
                                if (response['data']['message'][type[i]] !== undefined)
                                {
                                    for (var j = -1, js = status.length; ++j < js;)
                                    {
                                        if (response['data']['message'][type[i]][status[j]] !== undefined)
                                        {
                                            var template = '<div class="alert alert-' + status[j] + ' alert-dismissible">'
                                                + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                                                + '<ul>';
                                            for (var k = -1, ks = response['data']['message'][type[i]][status[j]].length; ++k < ks;)
                                            {
                                                template += '<li>' + response['data']['message'][type[i]][status[j]][k] + '</li>'
                                            }
                                            template += '</ul>'
                                                + '</div>';
                                            $("div#form-message-container").empty().append(template);
                                        }
                                    }
                                }
                            }
                        }

                        if (response['data']['redirect'] !== undefined)
                        {
                            location.href = response['data']['redirect'];
                        }

                        if (response['data']['csrf'] !== undefined)
                        {
                            $(form).find('input:hidden[name=' + response['data']['csrf']['name'] + ']').val(response['data']['csrf']['hash']);
                        }
                    }
                })
                .fail(function ()
                {
                })
                .always(function ()
                {
                    NProgress.done();
                });
        });

        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

        if ((sessionFlashdata !== undefined) && (sessionFlashdata !== null))
        {
            for (var i = -1, is = sessionFlashdata.length; ++i < is;)
            {
                $.notify({
                    message: sessionFlashdata[i]
                }, {
                    type: 'info'
                });
            }
        }
    });
    /*
     * Run right away
     * */
})(jQuery);
