/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 16 July 2017, 1:16 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

$(document).on("click", "#edit-user", function ()
{

    var id_usr = $(this).data('id');

    var usr_nm = $(this).data('usr');
    var pss_usr = $(this).data('pss');
    var nmf_usr = $(this).data('nmf');
    var lvl_usr = $(this).data('lvl');


    $("#modal-update #kode_user").val(id_usr);

    $("#modal-update #usrnm").val(usr_nm);
    $("#modal-update #pass").val(pss_usr);
    $("#modal-update #nmfull").val(nmf_usr);
    $("#modal-update #level").val(lvl_usr);
});

$(document).ready(function (e)
{
    $("#formx").on("submit", (function (e)
    {
        e.preventDefault();
        $.ajax({
            url: 'models/pcss_edituser.php',
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg)
            {
                $('.table').html(msg);
            }

        });
    }));
});

$(".tmpil-tooltip").tooltip({
    selector: "[data-toggle=tooltip]",
    trigger: "hover"
});
