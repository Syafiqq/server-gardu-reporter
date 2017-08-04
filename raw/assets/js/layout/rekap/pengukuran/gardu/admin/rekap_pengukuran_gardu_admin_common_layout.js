/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 04 August 2017, 9:29 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

(function ($) {
    $(function () {
        var table_report = 'table#table_gardu_index';
        var table = $(table_report).DataTable({
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
        var retriever = $('meta[name="retriever"]').attr('content');

        var retreiveData = function (table, link, progress) {
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
                            table.clear();
                            for (i = table.data().count() - 1, is = contents.length; ++i < is;)
                            {
                                var content = contents[i];
                                var del = "<button class='btn btn-danger btn-xs c-del-button' dx-user='" + content['no'] + "' type='button' data-toggle='tooltip' data-placement='right' title='Hapus'><i class='fa fa-trash-o'></i></button>";
                                var upd = "<button class='btn btn-info btn-xs c-upd-button' " +
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
                                var dtl = "<a class='btn btn-info btn-xs' type='button' href='" + sprintf(detail, content['no']) + "' data-toggle='tooltip' data-placement='right' title='Detail'><i class='fa fa-search'></i></a>";
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

        if ((retriever !== undefined) && (retriever !== null))
        {
            //retreiveData(table, retriever, NProgress);
        }
    });
    /*
     * Run right away
     * */
})(jQuery);

