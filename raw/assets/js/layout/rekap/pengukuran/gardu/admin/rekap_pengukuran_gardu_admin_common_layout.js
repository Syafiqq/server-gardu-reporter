/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 04 August 2017, 9:29 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

(function ($) {
    $(function () {
        var table_report = 'table#tabel_pengukuran';
        var table = $(table_report).DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": true,
            "autoWidth": true,
            "sScrollX": "100%",
            "bScrollCollapse": true,
            "sScrollXInner": "100%",
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

                        if (response['data']['rekap_pengukuran_gardu'] !== undefined)
                        {
                            moment.locale('id');
                            var contents = response['data']['rekap_pengukuran_gardu'];
                            table.clear();
                            for (i = table.data().count() - 1, is = contents.length; ++i < is;)
                            {
                                var content = contents[i];
                                table.row.add([
                                    content['no_gardu'],
                                    content['gardu_induk'],
                                    content['gardu_penyulang'],
                                    content['lokasi'],
                                    content['latitude'],
                                    content['longitude'],
                                    content['petugas_1'],
                                    content['petugas_2'],
                                    content['no_kontrak'],
                                    moment(content['date'], "YYYY-MM-DD").tz('Asia/Jakarta').format('dddd, D MMMM YYYY'),
                                    moment(content['time'], "HH:mm:ss").tz('Asia/Jakarta').format('HH:mm:ss zz'),
                                    content['ir'],
                                    content['is'],
                                    content['it'],
                                    content['in'],
                                    content['vrn'],
                                    content['vsn'],
                                    content['vtn'],
                                    content['vrs'],
                                    content['vrt'],
                                    content['vst'],
                                    content['id_u1'],
                                    content['ir_u1'],
                                    content['is_u1'],
                                    content['it_u1'],
                                    content['in_u1'],
                                    content['vrn_u1'],
                                    content['vsn_u1'],
                                    content['vtn_u1'],
                                    content['vrs_u1'],
                                    content['vrt_u1'],
                                    content['vst_u1'],
                                    content['id_u2'],
                                    content['ir_u2'],
                                    content['is_u2'],
                                    content['it_u2'],
                                    content['in_u2'],
                                    content['vrn_u2'],
                                    content['vsn_u2'],
                                    content['vtn_u2'],
                                    content['vrs_u2'],
                                    content['vrt_u2'],
                                    content['vst_u2'],
                                    content['id_u3'],
                                    content['ir_u3'],
                                    content['is_u3'],
                                    content['it_u3'],
                                    content['in_u3'],
                                    content['vrn_u3'],
                                    content['vsn_u3'],
                                    content['vtn_u3'],
                                    content['vrs_u3'],
                                    content['vrt_u3'],
                                    content['vst_u3'],
                                    content['id_u4'],
                                    content['ir_u4'],
                                    content['is_u4'],
                                    content['it_u4'],
                                    content['in_u4'],
                                    content['vrn_u4'],
                                    content['vsn_u4'],
                                    content['vtn_u4'],
                                    content['vrs_u4'],
                                    content['vrt_u4'],
                                    content['vst_u4'],
                                    content['id_k1'],
                                    content['ir_k1'],
                                    content['is_k1'],
                                    content['it_k1'],
                                    content['in_k1'],
                                    content['vrn_k1'],
                                    content['vsn_k1'],
                                    content['vtn_k1'],
                                    content['vrs_k1'],
                                    content['vrt_k1'],
                                    content['vst_k1'],
                                    content['id_k2'],
                                    content['ir_k2'],
                                    content['is_k2'],
                                    content['it_k2'],
                                    content['in_k2'],
                                    content['vrn_k2'],
                                    content['vsn_k2'],
                                    content['vtn_k2'],
                                    content['vrs_k2'],
                                    content['vrt_k2'],
                                    content['vst_k2']
                                ]);
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
            retreiveData(table, retriever, NProgress);
        }
    });
    /*
     * Run right away
     * */
})(jQuery);

