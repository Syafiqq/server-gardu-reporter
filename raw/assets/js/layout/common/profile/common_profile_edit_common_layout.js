/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 17 July 2017, 1:32 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

(function ($) {
    $(function () {
        var update_selector = 'form#update_form';

        $(update_selector).on('submit', function (event) {
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
                    var kind = ['notify', 'message'];
                    var type = ['validation', 'update'];
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
                                                        $("div#form-message-container").empty().append(template);
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

                        if (response['data']['csrf'] !== undefined)
                        {
                            $(form).find('input:hidden[name=' + response['data']['csrf']['name'] + ']').val(response['data']['csrf']['hash']);
                        }
                    }
                })
                .fail(function () {
                })
                .always(function () {
                    NProgress.done();
                });
        });

        $('a#edit-user').on('click', function () {
            var username = $(this).data('username');
            var email = $(this).data('email');
            var role = $(this).data('role');

            $(update_selector).find("input#update_username").val(username);
            $(update_selector).find("input#update_email").val(email);
            $(update_selector).find("input#update_role").val(role);
        });
    });
    /*
     * Run right away
     * */
})(jQuery);
