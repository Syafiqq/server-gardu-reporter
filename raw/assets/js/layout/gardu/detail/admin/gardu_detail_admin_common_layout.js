/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 24 July 2017, 5:15 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

(function ($) {
    $(function () {
        var retriever = $('meta[name="retriever"]').attr('content');
        var location = {};

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

                        if (response['data']['gardu_index_detail'] !== undefined)
                        {
                            var contents = response['data']['gardu_index_detail'];
                            for (i = -1, is = contents.length; ++i < is;)
                            {
                                var content = contents[i];
                                $.each(content, function (key, value) {
                                    $('dl#detail_content').find('dd[x-c-item="' + key + '"]').text(value);
                                });
                                if ((map !== undefined) && (map !== null))
                                {
                                    map.addMarker({
                                        lat: content['lat'],
                                        lng: content['long'],
                                        icon: "/assets/img/map/gardu-marker(32).png"
                                    });
                                    map.setZoom(16);
                                    map.setCenter(
                                        content['lat'],
                                        content['long']
                                    );

                                    location['destination'] = {};
                                    location['destination']['lat'] = content['lat'];
                                    location['destination']['lng'] = content['long'];
                                }
                            }
                        }
                    }
                    progress.done();
                })
                .fail(function () {
                    progress.done();
                });
        };

        $('button#setrute').on('click', function () {
            GMaps.geolocate({
                success: function (position) {
                    map.setCenter(position.coords.latitude, position.coords.longitude);

                    location['origin'] = {};
                    location['origin']['lat'] = position.coords.latitude;
                    location['origin']['lng'] = position.coords.longitude;

                    // Creating marker of user location
                    map.addMarker({
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                        icon: "/assets/img/map/gardu-marker(32).png"
                    });

                    if (((location['origin'] !== undefined) && (location['origin'] !== null))
                        && ((location['destination'] !== undefined) && (location['destination'] !== null)))
                    {
                        map.cleanRoute();
                        map.drawRoute({
                            origin: [location['origin']['lat'], location['origin']['lng']],
                            destination: [location['destination']['lat'], location['destination']['lng']],
                            travelMode: 'driving',
                            strokeColor: '#252525',
                            strokeOpacity: 0.6,
                            strokeWeight: 6
                        });
                        map.fitZoom();
                    }

                },
                error: function (error) {
                    $.notify({
                        message: 'Set Current Location Failed'
                    }, {
                        type: 'warning'
                    });
                },
                not_supported: function () {
                    $.notify({
                        message: 'Your browser does not support geolocation'
                    }, {
                        type: 'warning'
                    });
                }
            });
        });

        if ((retriever !== undefined) && (retriever !== null))
        {
            retreiveData(retriever, NProgress);
        }

        var map = new GMaps({
            el: '#map',
            lat: 0,
            lng: 0,
            zoom: 1
        });
    });
    /*
     * Run right away
     * */
})(jQuery);
