/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 20 June 2017, 6:15 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

(function ($)
{
    $(function ()
    {
        let table_report = '#table_report';
        let table = $(table_report).DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "language": {
                "url": $('meta[name="datatable_lang"]').attr('content')
            }
        });

        this.retreiveData = function (table, link, progress)
        {
            progress.start();
            $.ajax({
                type: 'get',
                url: link,
                dataType: 'json',
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8; X-Requested-With: XMLHttpRequest'
            })
                .done(function (data)
                {
                    if (data.hasOwnProperty('data'))
                    {
                        if (data['data'].hasOwnProperty('reports'))
                        {
                            let contents = data['data']['reports'];
                            for (let i = table.data().count() - 1; ++i < contents.length;)
                            {
                                let content = contents[i];
                                let location = '<a target="_blank" href="http://www.google.com/maps/place/' + content['location']['latitude'] + ',' + content['location']['longitude'] + '/@' + content['location']['latitude'] + ',' + content['location']['longitude'] + ',17z">Latitude : ' + content['location']['latitude'] + '<br>Longitude : ' + content['location']['longitude'] + '</a>';
                                table.row.add([(i + 1), content['substation'], content['current'], content['voltage'], location]);
                            }
                            table.draw(true);
                        }
                    }
                    progress.done();
                })
                .fail(function ()
                {
                    progress.done();
                });
        };

        NProgress.configure({
            showSpinner: false,
            template: '<div class="bar" role="bar" style="background-color: red"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div>'
        });

        let link = $('meta[name="retriever"]').attr('content');
        if ((link !== undefined) && (link !== null))
        {
            this.retreiveData(table, link, NProgress);
        }

        if ((sessionFlashdata !== undefined) && (sessionFlashdata !== null))
        {
            for (let i = -1, is = sessionFlashdata.length; ++i < is;)
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
