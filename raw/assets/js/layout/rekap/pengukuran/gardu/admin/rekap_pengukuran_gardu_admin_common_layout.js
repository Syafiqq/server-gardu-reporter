/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 04 August 2017, 9:29 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

(function ($) {
    $(function () {
        'use strict';
        moment.locale('id');
        var selector = {};
        selector['table_report'] = 'table#tabel_pengukuran';
        selector['timestamp-filter'] = 'span#timestamp-filter';

        var table = $(selector['table_report']).DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": true,
            "sScrollX": "100%",
            "bScrollCollapse": true,
            "sScrollXInner": "100%",
            "language": {
                "url": $('meta[name="datatable_lang"]').attr('content')
            },
            "columnDefs": [
                {
                    "targets": [9],
                    "visible": false
                }
            ]
        });

        yadcf.init(table, [{
            column_number: 9,
            filter_type: "range_date",
            datepicker_type: 'jquery-ui',
            date_format: 'yyyy-mm-dd',
            filter_container_id: 'timestamp-filter'
        }]);


        var retriever = $('meta[name="retriever"]').attr('content');

        $('button#content-download').on('click', function () {
            event.preventDefault();
            var input = {};
            input['from'] = $(selector['timestamp-filter']).find('input#yadcf-filter--tabel_pengukuran-from-date-9').val();
            input['to'] = $(selector['timestamp-filter']).find('input#yadcf-filter--tabel_pengukuran-to-date-9').val();
            input = removeEmptyValues(input);

            var download = $('meta[name="download"]').attr('content');

            if ((retriever !== undefined) && (retriever !== null))
            {
                NProgress.start();
                $.ajax({
                    type: 'get',
                    data: input,
                    url: download,
                    dataType: 'json'
                })
                    .done(function (response) {
                        var kind = ['notify', 'message'];
                        var type = ['validation', 'download'];
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

                            if (response['data']['status'] !== undefined)
                            {
                                if (response['data']['status'] === 1)
                                {
                                    var $a = $("<a>");
                                    $a.attr("href", response['data']['download']['content']);
                                    $("body").append($a);
                                    $a.attr("download", response['data']['download']['filename']);
                                    $a[0].click();
                                    $a.remove();
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
                                    content['date'],
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

