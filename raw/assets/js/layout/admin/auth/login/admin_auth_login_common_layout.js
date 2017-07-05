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
        $('form#login').on('submit', function (event)
        {
            event.preventDefault();
            var form = $(this);

            var input = form.serializeObject();

            input['remember_me'] = $(this).find('input[type=checkbox][name=remember_me]').prop('checked');
            if ((input['remember_me'] === undefined) || (input['remember_me'] === null))
            {
                input['remember_me'] = false;
            }

            $.post(
                form.attr('action'),
                input,
                null,
                'json')
                .done(function (data)
                {
                })
                .fail(function (data)
                {
                })
                .always(function (data)
                {
                });
        });

        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
    /*
     * Run right away
     * */
})(jQuery);
