<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{-- url (mix('/js/app.js')) --}}" type="text/javascript"></script>
<script src="{{ url('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/demo/demo3/base/scripts.bundle.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/demo/default/custom/components/forms/widgets/select2.js') }}" type="text/javascript"></script>

<!--begin::Page Vendors -->
<script src="//www.amcharts.com/lib/3/amcharts.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/serial.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/radar.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/pie.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/plugins/tools/polarScatter/polarScatter.min.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/plugins/animate/animate.min.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/plugins/export/export.min.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/themes/light.js" type="text/javascript"></script>
<!--end::Page Vendors -->

<script src="{{ url('assets/demo/default/custom/components/charts/amcharts/charts.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/app/js/dashboard.js') }}" type="text/javascript"></script>

<script src="https://comet-server.com/CometServerApi.js" type="text/javascript"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->

<script type="text/javascript">
$(document).ready(function() {

    function HtmlEncode(str)
    {
        var el = document.createElement("div");
        el.innerText = el.textContent = str;
        str = el.innerHTML;
        return str;
    }

    function getExpiredHGBs()
    {
        let urlRequest = "{{ url('aset-jemaat/check-masa-expired-hgb') }}"

        $.ajax({
            url: urlRequest,
            // data: {
            //     inputAdditionalVal: inputAdditionalVal
            // },
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .done(function( data ) {
            let result = JSON.parse(data)
            let $strRes = ''

            result.forEach(element => {
                $strRes += '<div class="m-list-timeline__item">'
                $strRes += '<span class="m-list-timeline__badge"></span>'
                $strRes += '<span class="m-list-timeline__text">Data aset dengan kode <a href="/aset-jemaat/' + element.id + '" style="text-decoration: underline">' + HtmlEncode(element.kode_aset) + '</a> akan kadaluwarsa pada tanggal ' + HtmlEncode(element.tgl_expired) + '</span>'
                $strRes += '<span class="m-list-timeline__time">5 hrs</span>'
                $strRes += '</div>'
            });

            // data.forEach(element => {
            //     console.log(element);
            // });

            // for (var key in data) {
            //     console.log(key.kode_aset);
            // }


            $(".m-list-timeline__items.hgb").html($strRes)
            $("#hgb_notifications").text(result.length + " New")
            $("#m_topbar_notification_icon > .m-badge--accent").text(result.length)
        });
    }

    // cometApi.start({node:"app.comet-server.ru", dev_id:15 })

    // cometApi.subscription("simplechat.newMessage", function(event) {

    //     let $strRes = '';
    //     $strRes += '<div class="m-list-timeline__item">';
    //     $strRes += '<span class="m-list-timeline__badge"></span>';
    //     $strRes += '<span class="m-list-timeline__text">Data aset dengan kode ' + HtmlEncode(event.data.kode_aset) + ' akan kadaluwarsa pada tanggal ' + HtmlEncode(event.data.tgl_expired) + '</span>';
    //     $strRes += '<span class="m-list-timeline__time">5 hrs</span>';
    //     $strRes += '</div>';

    //     $(".m-list-timeline__items.hgb").append($strRes)
    // })
    
    getExpiredHGBs()

    // var doStuff = function() {
    //         getExpiredHGBs()
    //         setTimeout(doStuff, 60000);
    // };
    // doStuff();

    // (function doStuff() {
    //     // Do stuff
    //     setTimeout(doStuff, 1000);
    // }());
});
</script>