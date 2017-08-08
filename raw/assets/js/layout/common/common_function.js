/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 17 July 2017, 1:34 PM.
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
