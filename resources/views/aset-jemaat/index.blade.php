@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Form Jemaat
@endsection

@section('contentheader_title')
    Jemaat Induk
@endsection

@section('script-stats')
<script src="{{ url('assets/demo/default/custom/components/portlets/tools.js') }}" type="text/javascript"></script>
<script>
let dailySales = function() {
    let chartContainer = $('#m_chart_daily_sales');

    if (chartContainer.length == 0) {
        return;
    }

    let chartData = {
        labels: ["Label 1", "Label 2", "Label 3", "Label 4", "Label 5", "Label 6", "Label 7", "Label 8", "Label 9", "Label 10", "Label 11", "Label 12", "Label 13", "Label 14", "Label 15", "Label 16"],
        datasets: [{
            //label: 'Dataset 1',
            backgroundColor: mUtil.getColor('success'),
            data: [
                {{ $chiko1 }}, 20, 25, 30, 25, 20, 15, 20, 25, 30, 25, 20, 15, 10, 15, 20
            ]
        }, {
            //label: 'Dataset 2',
            backgroundColor: '#f3f3fb',
            data: [
                15, 20, 25, 30, 25, 20, 15, 20, 25, 30, 25, 20, 15, 10, 15, 20
            ]
        }]
    };

    let chart = new Chart(chartContainer, {
        type: 'bar',
        data: chartData,
        options: {
            title: {
                display: false,
            },
            tooltips: {
                intersect: false,
                mode: 'nearest',
                xPadding: 10,
                yPadding: 10,
                caretPadding: 10
            },
            legend: {
                display: false
            },
            responsive: true,
            maintainAspectRatio: false,
            barRadius: 4,
            scales: {
                xAxes: [{
                    display: false,
                    gridLines: false,
                    stacked: true
                }],
                yAxes: [{
                    display: false,
                    stacked: true,
                    gridLines: false
                }]
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            }
        }
    });
}


let profitShare = function() {
    if ($('#m_chart_profit_share').length == 0) {
        return;
    }

    let chart = new Chartist.Pie('#m_chart_profit_share', {
        series: [{
                value: 32,
                className: 'custom',
                meta: {
                    color: mUtil.getColor('brand')
                }
            },
            {
                value: 32,
                className: 'custom',
                meta: {
                    color: mUtil.getColor('accent')
                }
            },
            {
                value: 36,
                className: 'custom',
                meta: {
                    color: mUtil.getColor('warning')
                }
            }
        ],
        labels: [1, 2, 3]
    }, {
        donut: true,
        donutWidth: 17,
        showLabel: false
    });

    chart.on('draw', function(data) {
        if (data.type === 'slice') {
            // Get the total path length in order to use for dash array animation
            var pathLength = data.element._node.getTotalLength();

            // Set a dasharray that matches the path length as prerequisite to animate dashoffset
            data.element.attr({
                'stroke-dasharray': pathLength + 'px ' + pathLength + 'px'
            });

            // Create animation definition while also assigning an ID to the animation for later sync usage
            var animationDefinition = {
                'stroke-dashoffset': {
                    id: 'anim' + data.index,
                    dur: 1000,
                    from: -pathLength + 'px',
                    to: '0px',
                    easing: Chartist.Svg.Easing.easeOutQuint,
                    // We need to use `fill: 'freeze'` otherwise our animation will fall back to initial (not visible)
                    fill: 'freeze',
                    'stroke': data.meta.color
                }
            };

            // If this was not the first slice, we need to time the animation so that it uses the end sync event of the previous animation
            if (data.index !== 0) {
                animationDefinition['stroke-dashoffset'].begin = 'anim' + (data.index - 1) + '.end';
            }

            // We need to set an initial value before the animation starts as we are not in guided mode which would do that for us

            data.element.attr({
                'stroke-dashoffset': -pathLength + 'px',
                'stroke': data.meta.color
            });

            // We can't use guided mode as the animations need to rely on setting begin manually
            // See http://gionkunz.github.io/chartist-js/api-documentation.html#chartistsvg-function-animate
            data.element.animate(animationDefinition, false);
        }
    });

    // For the sake of the example we update the chart every time it's created with a delay of 8 seconds
    chart.on('created', function() {
        if (window.__anim21278907124) {
            clearTimeout(window.__anim21278907124);
            window.__anim21278907124 = null;
        }
        window.__anim21278907124 = setTimeout(chart.update.bind(chart), 15000);
    });
}


let revenueChange = function () {
    if ($('#m_chart_revenue_change').length == 0) {
        return;
    }

    Morris.Donut({
        element: 'm_chart_revenue_change',
        data: [{
                label: "{{ $percentJumlahAsetBukanMilikGPIB }}%",
                value: {{ $statJumlahAsetBukanMilikGPIB }}
            },
            /*{
                label: "Aset di Pos Pelkes",
                value: {{-- $statJumlahAsetPosPelkes --}}
            },
            {
                label: "Aset Memiliki IMB",
                value: {{-- $statJumlahAsetMemilikiIMB --}}
            }*/
        ],
        colors: [
            mUtil.getColor('black'),
            /*mUtil.getColor('warning'),
            mUtil.getColor('success')*/
        ],
        //resize: true
    });
}

let revenueChange0 = function () {
    if ($('#m_chart_revenue_change0').length == 0) {
        return;
    }

    Morris.Donut({
        element: 'm_chart_revenue_change0',
        data: [{
                label:"{{ $percentJumlahAsetAtasNamaPribadi }}%",
                value: {{ $statJumlahAsetAtasNamaPribadi }}
            },
        ],
        colors: [
            mUtil.getColor('danger'),
        ],
    });
}

let revenueChange1 = function () {
    if ($('#m_chart_revenue_change1').length == 0) {
        return;
    }

    Morris.Donut({
        element: 'm_chart_revenue_change1',
        data: [{
            label: "{{ $percentJumlahAsetAtasNamaGPIBSetempat }}%",
            value: {{ $statJumlahAsetAtasNamaGPIBSetempat }}
        },
        ],
        colors: [
            mUtil.getColor('warning'),
        ],
    });
}

let revenueChange2 = function () {
    if ($('#m_chart_revenue_change2').length == 0) {
        return;
    }

    Morris.Donut({
        element: 'm_chart_revenue_change2',
        data: [{
            label: "{{ $percentJumlahAsetAtasNamaGPIB }}%",
            value: {{ $statJumlahAsetAtasNamaGPIB }}
        },
        ],
        colors: [
            mUtil.getColor('success'),
        ],
    });
}

let revenueChange3 = function () {
    if ($('#m_chart_revenue_change3').length == 0) {
        return;
    }

    Morris.Donut({
        element: 'm_chart_revenue_change3',
        data: [{
                label: "{{ $percentTanpaStatusKepemilikan }}%",
                value: {{ $statJumlahAsetTanpaStatusKepemilikan }}
            },
        ],
        colors: [
            mUtil.getColor('nostatus'),
        ],
    });
}

let $statJumlahAsetBukanMilikGPIB = {{ $statJumlahAsetBukanMilikGPIB }};
let $statJumlahAsetAtasNamaPribadi = {{ $statJumlahAsetAtasNamaPribadi }};
let $statJumlahAsetAtasNamaGPIBSetempat = {{ $statJumlahAsetAtasNamaGPIBSetempat }};
let $statJumlahAsetAtasNamaGPIB = {{ $statJumlahAsetAtasNamaGPIB }};
let $statJumlahAsetTanpaStatusKepemilikan = {{ $statJumlahAsetTanpaStatusKepemilikan }};

let demo12 = function() {
    let chart = AmCharts.makeChart("m_amcharts_12", {
        "type": "pie",
        "theme": "light",
        "dataProvider": [{
            "country": "Bukan Milik GPIB",
            "color": "black",
            "litres": $statJumlahAsetBukanMilikGPIB
        }, {
            "country": "Atas Nama Pribadi",
            "litres": $statJumlahAsetAtasNamaPribadi
        }, {
            "country": "Atas Nama GPIB Setempat",
            "litres": $statJumlahAsetAtasNamaGPIBSetempat
        }, {
            "country": "Atas Nama GPIB",
            "litres": $statJumlahAsetAtasNamaGPIB
        }, {
            "country": "Tanpa Status Kepemilikan",
            "litres": $statJumlahAsetTanpaStatusKepemilikan
        }],
        "valueField": "litres",
        "titleField": "country",
        "balloon": {
            "fixedPosition": true
        },
        "export": {
            "enabled": true
        }
    });
}

// $('#m_select2_1', '#m_select2_2').change( function() {
$('#m_select2_1').change( function(e, mupelExistVal ) {
// $('#m_select2_1').change( function(e) {

    if (mupelExistVal !== undefined) $(this).val(mupelExistVal)

    let $targetInputElem = $('#m_select2_2')
    let urlRequest = "{{ url('aset-jemaat/get-jemaat-by-mupel') }}"

    $.ajax({
        url: urlRequest,
        data: {
            inputVal: $(this).val()
        },
        type: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    .done( function(data) {
        $targetInputElem.html(data.input_template)

        // if (mupelExistVal != 'undefined') {
        //     let jemaatSelectedVal = '{{ $jemaat_selected }}'
        //     $targetInputElem.trigger("change", [jemaatSelectedVal])
        // }
    });
});

$('#m_select2_2').change( function(e) {
    // if (mupelExistVal != 'undefined') {
    //     $(this).val(mupelExistVal)
    // }

    if ( $(this).val() != 'no action' )
        $('#filter_form').submit()
});

// let userAccessObj = {$userAccessData}
// let mupelRoleVal = userAccessObj.mupel || undefined
// if (mupelRoleVal != 'undefined') {
//     $('#m_select2_1').trigger("change", [mupelRoleVal])
// }

let mupelSelectedVal = '{{$mupel_selected}}'
if (mupelSelectedVal !== 'undefined') {
    
    $('#m_select2_1').trigger("change", [mupelSelectedVal])
}




// text displaying
let mupelFilterSelected = $('#m_select2_1').val()
let jemaatIndukFilterSelected = $('#m_select2_2').val()
let defaultStatistikDescription = "Statistik Jumlah Aset "

if ( mupelFilterSelected == 0 && jemaatIndukFilterSelected == 0 ) {

    $('#report_title').text(defaultStatistikDescription + "Sinode ");
} else if ( mupelFilterSelected > 0 && jemaatIndukFilterSelected == 0 ) {
    
    let mupelFilterCaption = defaultStatistikDescription + "Mupel "+ $('#m_select2_1 option:selected').text();
    $('#report_title').text(mupelFilterCaption);
} else if ( mupelFilterSelected > 0 && jemaatIndukFilterSelected > 0 ) {

    let jemaatFilterCaption = defaultStatistikDescription + "Jemaat "+ $('#m_select2_2 option:selected').text();
    $('#report_title').text(jemaatFilterCaption);
}

// end text displaying
</script>
@endsection

@section('main-content')
<div class="m-content" >

    @can('create-new-jemaat')
        <!--begin::Portlet-->
        <div class="m-portlet" id="m_portlet_tools_1">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">Filter</h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href=""  data-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="la la-angle-down"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {!! Form::open(['route' => 'aset-jemaat.stats-by-mupel', 'class' => "m-form m-form--fit m-form--label-align-right", 'id' => 'filter_form']) !!}
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="m-portlet__body">

                    @can('show-aset-jemaat-mupel')
                        <div class="form-group m-form__group {{ $errors->has('mupel') ? 'has-error' : '' }}">
                            {!! Form::label('mupel', 'Pilih Berdasarkan Mupel', ['class' => 'control-label']) !!}
                            {!! Form::select('mupel', $list_mupel, @$mupel_selected, ['class' => 'form-control m-input m-input--square select2', 'id' => 'm_select2_1']) !!}
                            {!! $errors->first('mupel', '<p class="m--font-danger">:message</p>') !!}
                        </div>
                    @endcan

                    @can('show-aset-jemaat-induk')
                        <div class="form-group m-form__group {{ $errors->has('jemaat') ? 'has-error' : '' }}">
                            {!! Form::label('jemaat', 'Pilih Berdasarkan Jemaat', ['class' => 'control-label']) !!}
                            {!! Form::select('jemaat', $list_jemaat_induk, @$jemaat_selected, ['class' => 'form-control m-input m-input--square select2', 'id' => 'm_select2_2']) !!}
                            {!! $errors->first('jemaat', '<p class="m--font-danger">:message</p>') !!}
                        </div>
                    @endcan
                </div>
            {!! Form::close() !!}
        </div>
        <!--end::Portlet-->
    @endcan

    <!--Begin::Section-->
    <div class="row">
        <div class="col-xl-12">
            <!--begin:: Widgets/Product Sales-->
            <div class="m-portlet m-portlet--bordered-semi m-portlet--space m-portlet--full-height m-portlet--rounded">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text" id="report_title">
                                {{ $statistic_caption }}
                            </h3>
                        </div>
                    </div>

                </div>
                <div class="m-portlet__body">
                <!-- div class="m-widget25--progress">
                            <div class="m-widget25__progress" -->
                    <div class="m-widget25">

                        <div class="row align-items-center">

                            <div class="col-xl-12">

                                <table style="vertical-align: text-bottom" class="table">
                                    <tr>
                                        <th class="m-widget25__price m--font-brand" style="font-size: 2rem">Jumlah Fisik Aset</th>
                                        <th class="m-widget25__price m--font-brand" style="font-size: 2rem">Nilai Aset sesuai NJOP</th>
                                    </tr>
                                    <tr>
                                        <td class="m-widget25__desc" style="font-size: 2rem;">{{$statJumlahFisikAset}}</td>
                                        <td class="m-widget25__desc" style="font-size: 2rem;">Rp. {{$statTotalNJOP}}</td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <br/><br/><br/>

                        @can('show-aset-jemaat-mupel')
                            <div class="row align-items-center">

                                <div class="col-xl-12">

                                    <table style="vertical-align: text-bottom" class="table">
                                        <tr>
                                            <th class="m-widget25__price m--font-brand" style="font-size: 1rem">
                                                <a data-toggle="modal" data-target="#m_modal_jumlah_jemaat_induk" style="cursor: pointer; text-decoration: underline; ">
                                                    Jumlah jemaat induk
                                                </a>
                                            </th>
                                            <th class="m-widget25__price m--font-brand" style="font-size: 1rem">
                                                <a data-toggle="modal" data-target="#m_modal_jumlah_jemaat_yang_sudah_menyerahkan_data_aset" style="cursor: pointer; text-decoration: underline; "> 
                                                    Jemaat yang sudah menyerahkan data aset
                                                </a>
                                            </th>
                                            <th class="m-widget25__price m--font-brand" style="font-size: 1rem">
                                                <a data-toggle="modal" data-target="#m_modal_jumlah_jemaat_yang_belum_menyerahkan_data_aset" style="cursor: pointer; text-decoration: underline; "> 
                                                    Jemaat yang belum sama sekali menyerahkan data aset
                                                </a>
                                            </th>
                                            
                                        </tr>
                                        <tr>
                                            <td class="m-widget25__desc" style="font-size: 1rem;">
                                                {{$statJumlahJemaatInduk}}

                                                <div class="row align-items-center">

                                                    <div class="col" style="font-weight:bold; text-align:center">
                                                        
                                                        <!--begin::Modal-->
                                                        <div class="modal fade" id="m_modal_jumlah_jemaat_induk" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" >Jumlah jemaat induk</h5>

                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        
                                                                        <div class="m-section">

                                                                            <div class="table-responsive">
                                                                                <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th>#</th>
                                                                                        <th>Mupel</th>
                                                                                        <th>Nama Jemaat</th>
                                                                                        <th>Lihat</th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    @forelse($jemaatInduk as $idx => $item)
                                                                                        <tr>
                                                                                            <th scope="row">{{ $idx + 1 }}</th>
                                                                                            <td>{{ $item->mupel->nama }}</td>
                                                                                            <td>{{ $item->nama }}</td>
                                                                                            <td>
                                                                                                <a href="{{ route('form-jemaat-induk.show', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-archive"></i></a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @empty
                                                                                        <tr>
                                                                                            <td colspan="6">
                                                                                                <div class="panel panel-default">
                                                                                                    <div class="panel-body text-center">Tidak ada data.</div>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforelse
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end::Modal-->
                                                    </div>
                                                </div>

                                            </td>
                                            @if ( ($statJemaatYangSudahMenyerahkanAset + $statJemaatYangBelumMenyerahkanAset) == 0 ) 
                                                <td class="m-widget25__desc" style="font-size: 1rem;">0 ( 0% )</td>
                                                <td class="m-widget25__desc" style="font-size: 1rem;">0 ( 0% )</td>
                                            @else
                                                <td class="m-widget25__desc" style="font-size: 1rem;">
                                                    {{$statJemaatYangSudahMenyerahkanAset}} ( {{ number_format($statJemaatYangSudahMenyerahkanAset / ($statJumlahJemaatInduk) * 100, 2, '.', '') }}% )

                                                    <div class="row align-items-center">

                                                        <div class="col" style="font-weight:bold; text-align:center">
                                                            
                                                            <!--begin::Modal-->
                                                            <div class="modal fade" id="m_modal_jumlah_jemaat_yang_sudah_menyerahkan_data_aset" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" >Jemaat yang sudah menyerahkan data aset</h5>

                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>

                                                                        <div class="modal-body">
                                                                            
                                                                            <div class="m-section">

                                                                                <div class="table-responsive">
                                                                                    <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
                                                                                        <thead>
                                                                                        <tr>
                                                                                            <th>#</th>
                                                                                            <th>Mupel</th>
                                                                                            <th>Nama Jemaat</th>
                                                                                            <th>Lihat</th>
                                                                                        </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                        @forelse($jemaatYangSudahMenyerahkanAset as $idx => $item)
                                                                                            <tr>
                                                                                                <th scope="row">{{ $idx + 1 }}</th>
                                                                                                <td>{{ $item->nama_mupel }}</td>
                                                                                                <td>{{ $item->nama }}</td>
                                                                                                <td>
                                                                                                    <a href="{{ route('form-jemaat-induk.show', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-archive"></i></a>
                                                                                                </td>
                                                                                            </tr>
                                                                                        @empty
                                                                                            <tr>
                                                                                                <td colspan="6">
                                                                                                    <div class="panel panel-default">
                                                                                                        <div class="panel-body text-center">Tidak ada data.</div>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        @endforelse
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end::Modal-->
                                                        </div>
                                                    </div>

                                                </td>

                                                <td class="m-widget25__desc" style="font-size: 1rem;">
                                                    {{$statJemaatYangBelumMenyerahkanAset}} ( {{ number_format($statJemaatYangBelumMenyerahkanAset / ($statJumlahJemaatInduk) * 100, 2, '.', '') }}% )

                                                    <div class="row align-items-center">

                                                        <div class="col" style="font-weight:bold; text-align:center">
                                                            
                                                            <!--begin::Modal-->
                                                            <div class="modal fade" id="m_modal_jumlah_jemaat_yang_belum_menyerahkan_data_aset" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" >Jemaat yang belum menyerahkan data aset</h5>

                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>

                                                                        <div class="modal-body">
                                                                            
                                                                            <div class="m-section">

                                                                                <div class="table-responsive">
                                                                                    <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
                                                                                        <thead>
                                                                                        <tr>
                                                                                            <th>#</th>
                                                                                            <th>Mupel</th>
                                                                                            <th>Nama Jemaat</th>
                                                                                            <th>Lihat</th>
                                                                                        </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                        @forelse($jemaatYangBelumMenyerahkanAset as $idx => $item)
                                                                                            <tr>
                                                                                                <th scope="row">{{ $idx + 1 }}</th>
                                                                                                <td>{{ $item->mupel->nama }}</td>
                                                                                                <td>{{ $item->nama }}</td>
                                                                                                <td>
                                                                                                    <a href="{{ route('form-jemaat-induk.show', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-archive"></i></a>
                                                                                                </td>
                                                                                            </tr>
                                                                                        @empty
                                                                                            <tr>
                                                                                                <td colspan="6">
                                                                                                    <div class="panel panel-default">
                                                                                                        <div class="panel-body text-center">Tidak ada data.</div>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        @endforelse
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end::Modal-->
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    </table>
                                </div>

                            </div>
                            <br/><br/><br/>
                        @endcan

                        <div class="row align-items-center">

                            <div class="col" style="font-weight:bold; text-align:center">
                                <button type="button" class="btn btn-black m-btn--wide" data-toggle="modal" data-target="#m_modal_bukan_milik_gpib" >Bukan Milik GPIB</button>

                                <div id="m_chart_revenue_change" style="height: 300px"></div>

                                <!--begin::Modal-->
                                <div class="modal fade" id="m_modal_bukan_milik_gpib" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" >Bukan Milik GPIB</h5>

                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                
                                                <div class="m-section">

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Mupel</th>
                                                                <th>Nama Jemaat</th>
                                                                <th>Nama Bangunan</th>
                                                                <th>Kode Aset</th>
                                                                <th>Lihat</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @forelse($asetBukanMilikGPIB as $idx => $item)
                                                                <tr>
                                                                    <th scope="row">{{ $idx+1 }}</th>
                                                                    <td>{{ $item->nama_mupel }}</td>
                                                                    <td>{{ $item->nama_jemaat_induk }}</td>
                                                                    <td>{{ $item->nama_bangunan }}</td>
                                                                    <td>{{ $item->kode_aset }}</td>
                                                                    <td>
                                                                        <a href="{{ route('aset-jemaat.show', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-archive"></i></a>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="6">
                                                                        <div class="panel panel-default">
                                                                            <div class="panel-body text-center">Tidak ada data.</div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Modal-->
                            </div>

                            <div class="col" style="font-weight:bold; text-align:center">
                                <button type="button" class="btn btn-danger m-btn--wide" data-toggle="modal" data-target="#m_modal_atas_nama_pribadi" >Atas Nama Pribadi</button>

                                <div id="m_chart_revenue_change0" style="height: 300px"></div>

                                <!--begin::Modal-->
                                <div class="modal fade" id="m_modal_atas_nama_pribadi" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" >Atas Nama Pribadi</h5>

                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                
                                                <div class="m-section">

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Mupel</th>
                                                                <th>Nama Jemaat</th>
                                                                <th>Nama Bangunan</th>
                                                                <th>Kode Aset</th>
                                                                <th>Lihat</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @forelse($asetAtasNamaPribadi as $idx => $item)
                                                                <tr>
                                                                    <th scope="row">{{ $idx+1 }}</th>
                                                                    <td>{{ $item->nama_mupel }}</td>
                                                                    <td>{{ $item->nama_jemaat_induk }}</td>
                                                                    <td>{{ $item->nama_bangunan }}</td>
                                                                    <td>{{ $item->kode_aset }}</td>
                                                                    <td>
                                                                        <a href="{{ route('aset-jemaat.show', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-archive"></i></a>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="6">
                                                                        <div class="panel panel-default">
                                                                            <div class="panel-body text-center">Tidak ada data.</div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Modal-->
                            </div>

                            <div class="col" style="font-weight:bold; text-align:center">
                                <button type="button" class="btn btn-warning m-btn--wide" data-toggle="modal" data-target="#m_modal_atas_nama_gpib_setempat" >Atas Nama GPIB Setempat</button>

                                <div id="m_chart_revenue_change1" style="height: 300px"></div>

                                <!--begin::Modal-->
                                <div class="modal fade" id="m_modal_atas_nama_gpib_setempat" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" >Atas Nama GPIB Setempat</h5>

                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                
                                                <div class="m-section">

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Mupel</th>
                                                                <th>Nama Jemaat</th>
                                                                <th>Nama Bangunan</th>
                                                                <th>Kode Aset</th>
                                                                <th>Lihat</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @forelse($asetAtasNamaGPIBSetempat as $idx => $item)
                                                                <tr>
                                                                    <th scope="row">{{ $idx+1 }}</th>
                                                                    <td>{{ $item->nama_mupel }}</td>
                                                                    <td>{{ $item->nama_jemaat_induk }}</td>
                                                                    <td>{{ $item->nama_bangunan }}</td>
                                                                    <td>{{ $item->kode_aset }}</td>
                                                                    <td>
                                                                        <a href="{{ route('aset-jemaat.show', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-archive"></i></a>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="6">
                                                                        <div class="panel panel-default">
                                                                            <div class="panel-body text-center">Tidak ada data.</div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Modal-->
                            </div>

                            <div class="col">
                                <div class="m-widget1 m-widget1--paddingless">
                                    <div class="m-widget1__item">
                                        <div class="row m-row--no-padding align-items-center">
                                            <div class="col">
                                                <h3 class="m-widget1__title">
                                                    <a href="{{ URL::to(action('AsetJemaatController@listAsetPosPelkes') . '?' . $queryString) }}">Aset di Pos Pelkes</a>
                                                </h3>
                                            </div>
                                            <div class="col m--align-right">
                                                <span class="m-widget1__number m--font-danger">
                                                    {{ $statJumlahAsetPosPelkes }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-widget1__item">
                                        <div class="row m-row--no-padding align-items-center">
                                            <div class="col">
                                                <h3 class="m-widget1__title">
                                                    <a href="{{ URL::to(action('AsetJemaatController@listAsetMemilikiIMB') . '?' . $queryString) }}">Aset memiliki IMB</a>
                                                </h3>
                                            </div>
                                            <div class="col m--align-right">
                                                <span class="m-widget1__number m--font-success">
                                                    {{ $statJumlahAsetMemilikiIMB }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Form Wizard Step 4-->
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col" style="font-weight:bold; text-align:center">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#m_modal_atas_nama_gpib" >Atas Nama GPIB</button>

                                <div id="m_chart_revenue_change2" style="height: 300px"></div>

                                <!--begin::Modal-->
                                <div class="modal fade" id="m_modal_atas_nama_gpib" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" >Atas Nama GPIB</h5>

                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                
                                                <div class="m-section">

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Mupel</th>
                                                                <th>Nama Jemaat</th>
                                                                <th>Nama Bangunan</th>
                                                                <th>Kode Aset</th>
                                                                <th>Lihat</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @forelse($asetAtasNamaGPIB as $idx => $item)
                                                                <tr>
                                                                    <th scope="row">{{ $idx+1 }}</th>
                                                                    <td>{{ $item->nama_mupel }}</td>
                                                                    <td>{{ $item->nama_jemaat_induk }}</td>
                                                                    <td>{{ $item->nama_bangunan }}</td>
                                                                    <td>{{ $item->kode_aset }}</td>
                                                                    <td>
                                                                        <a href="{{ route('aset-jemaat.show', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-archive"></i></a>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="6">
                                                                        <div class="panel panel-default">
                                                                            <div class="panel-body text-center">Tidak ada data.</div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Modal-->
                            </div>

                            <div class="col" style="font-weight:bold; text-align:center">
                                <button type="button" class="btn btn-nostatus m-btn--wide" data-toggle="modal" data-target="#m_modal_tanpa_status_kepemilikan" >Tanpa Status Kepemilikan</button>
                                
                                <div id="m_chart_revenue_change3" style="height: 300px"></div>

                                <!--begin::Modal-->
                                <div class="modal fade" id="m_modal_tanpa_status_kepemilikan" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" >Tanpa Status Kepemilikan</h5>

                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                
                                                <div class="m-section">

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Mupel</th>
                                                                <th>Nama Jemaat</th>
                                                                <th>Nama Bangunan</th>
                                                                <th>Kode Aset</th>
                                                                <th>Lihat</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @forelse($asetTanpaStatusKepemilikan as $idx => $item)
                                                                <tr>
                                                                    <th scope="row">{{ $idx+1 }}</th>
                                                                    <td>{{ $item->nama_mupel }}</td>
                                                                    <td>{{ $item->nama_jemaat_induk }}</td>
                                                                    <td>{{ $item->nama_bangunan }}</td>
                                                                    <td>{{ $item->kode_aset }}</td>
                                                                    <td>
                                                                        <a href="{{ route('aset-jemaat.show', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-archive"></i></a>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="6">
                                                                        <div class="panel panel-default">
                                                                            <div class="panel-body text-center">Tidak ada data.</div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Modal-->
                            </div>

                            <div class="col"></div>

                            <div class="col"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end:: Widgets/Product Sales-->
        </div>
    </div>
    <!--End::Section-->
</div>
@stop