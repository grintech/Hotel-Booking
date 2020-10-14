@extends('layouts.user')
@section('head')
    <link rel="stylesheet" href="{{asset('libs/fullcalendar-4.2.0/core/main.css')}}">
    <link rel="stylesheet" href="{{asset('libs/fullcalendar-4.2.0/daygrid/main.css')}}">
    <link rel="stylesheet" href="{{asset('libs/daterange/daterangepicker.css')}}">

    <style>
        .event-name{
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }
        #dates-calendar .loading{

        }
        .color-legend{
            display:inline-block;
            height: 10px;
            width: 10px;
            border-radius: 50%;
            box-shadow: 2px 2px 3px rgba(0,0,0,.1);
        }
    </style>
@endsection
@section('content')

    <div class="row align-items-center">
        <div class="col-md-3 col-sm-12">
            <h2 class="title-bar no-border-bottom">
                {{__("Dashboard")}}
            </h2>
        </div>
        <div class="col-md-9 col-sm-12">
            <div class="row d-flex" style="justify-content: space-between; align-items: center;">
                @if(!empty($cards_report))
                    @foreach($cards_report as $item)
                        <div class="col-md-3 col-sm-6 my-1 my-md-0">
                            <div style="background-color: {{ $item['background'] }}; color: {{ $item['text'] }}; padding: 8px; border-radius: 8px; text-align: center;box-shadow: 3px 3px 12px rgba(0,0,0,.1)">
                                <h5 class="m-0">{{ $item['amount'] }}</h5>
                                <div class="">
                                    <small>{{$item['title']}}</small>
                                </div>

                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    @include('admin.message')
{{--    <div class="bravo-user-dashboard">--}}
{{--        <div class="row dashboard-price-info row-eq-height">--}}
{{--            @if(!empty($cards_report))--}}
{{--                @foreach($cards_report as $item)--}}
{{--                    <div class="col-lg-3 col-md-3">--}}
{{--                        <div class="dashboard-item">--}}
{{--                            <div class="wrap-box">--}}
{{--                                <div class="title">--}}
{{--                                    {{$item['title']}}--}}
{{--                                </div>--}}
{{--                                <div class="details">--}}
{{--                                    <div class="number">--}}
{{--                                        {{ $item['amount'] }}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="desc"> {{ $item['desc'] }}</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

    @if($guesthouse)
        @if(count($rows))
            <div class="user-panel">
                <div class="panel-title">
                    <strong>{{__('Availability')}}</strong>
                    <div class="d-inline-block ml-3">
                        <span>
                            <span class="color-legend ml-2" style="background-color: #cd0a0a"></span> {{ __('All Booked') }}
                        </span>
                        <span>
                            <span class="color-legend ml-2" style="background-color: #28df99"></span> {{ __('Available') }}
                        </span>
                        <span>
                            <span class="color-legend ml-2" style="background-color: #686d76"></span> {{ __('No Status') }}
                        </span>
                        <span>
                            <span class="color-legend ml-2" style="background-color: #1b262c"></span> {{ __('Blocked') }}
                        </span>
                    </div>
                </div>
                <div class="panel-body no-padding" style="background: #f4f6f8;padding: 0px 15px;">
                    <div class="row">
                        <div class="col-md-3" style="border-right: 1px solid #dee2e6;">
                            <ul class="nav nav-tabs  flex-column vertical-nav" id="items_tab"  role="tablist">
                                @foreach($rows as $k=>$item)
                                    <li class="nav-item event-name ">
                                        <a class="nav-link" data-id="{{$item->id}}" data-toggle="tab" href="#calendar-{{$item->id}}" title="{{$item->title}}" >#{{$item->id}} - {{$item->title}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-9" style="background: white;padding: 15px;">
                            <div id="dates-calendar" class="dates-calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning">{{__("No rooms found")}}</div>
        @endif
    @endif

    <div id="bravo_modal_calendar" class="modal fade">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Date Information')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="row form_modal_calendar form-horizontal" novalidate onsubmit="return false">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >{{__('Date Ranges')}}</label>
                                <input readonly type="text" class="form-control has-daterangepicker">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >{{__('Status')}}</label>
                                <br>
                                <label ><input true-value=1 false-value=0 type="checkbox" v-model="form.active"> {{__('Available for booking?')}}</label>
                            </div>
                        </div>
                        <div class="col-md-6" v-show="form.active">
                            <div class="form-group">
                                <label >{{__('Price')}}</label>
                                <input type="number"  v-model="form.price" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6" v-show="form.active">
                            <div class="form-group">
                                <label >{{__('Number of room')}}</label>
                                <input type="number"  v-model="form.number" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 d-none" v-show="form.active">
                            <div class="form-group">
                                <label >{{__('Instant Booking?')}}</label>
                                <br>
                                <label><input true-value=1 false-value=0  type="checkbox"  v-model="form.is_instant" > {{__("Enable instant booking")}}</label>
                            </div>
                        </div>
                    </form>
                    <div v-if="lastResponse.message">
                        <br>
                        <div  class="alert" :class="!lastResponse.status ? 'alert-danger':'alert-success'">@{{ lastResponse.message }}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                    <button type="button" class="btn btn-primary" @click="saveForm">{{__('Save changes')}}</button>
                </div>
            </div>
        </div>
    </div>

{{--    <div class="bravo-user-chart">--}}
{{--        <div class="chart-title">--}}
{{--            {{__("Earning statistics")}}--}}
{{--            <div class="action-control">--}}
{{--                <div id="reportrange">--}}
{{--                    <i class="fa fa-calendar"></i>&nbsp;--}}
{{--                    <span></span> <i class="fa fa-caret-down"></i>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <canvas class="bravo-user-render-chart"></canvas>--}}
{{--        <script>--}}
{{--            var earning_chart_data = {!! json_encode($earning_chart_data) !!};--}}
{{--        </script>--}}
{{--    </div>--}}
@endsection
@section('footer')
    @if($guesthouse)
    <script src="{{asset('libs/daterange/moment.min.js')}}"></script>
    <script src="{{asset('libs/daterange/daterangepicker.min.js?_ver='.config('app.version'))}}"></script>
    <script src="{{asset('libs/fullcalendar-4.2.0/core/main.js')}}"></script>
    <script src="{{asset('libs/fullcalendar-4.2.0/interaction/main.js')}}"></script>
    <script src="{{asset('libs/fullcalendar-4.2.0/daygrid/main.js')}}"></script>

    <script>
        var calendarEl,calendar,lastId,formModal;
        $('#items_tab').on('show.bs.tab',function (e) {
            calendarEl = document.getElementById('dates-calendar');
            lastId = $(e.target).data('id');
            if(calendar){
                calendar.destroy();
            }
            calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [ 'dayGrid' ,'interaction'],
                header: {},
                selectable: true,
                selectMirror: false,
                allDay:false,
                editable: false,
                eventLimit: true,
                defaultView: 'dayGridMonth',
                firstDay: daterangepickerLocale.first_day_of_week,
                events:{
                    url:"{{route('guesthouse.vendor.room.availability.loadDates',['guesthouse_id'=> $guesthouse->id])}}",
                    extraParams:{
                        id:lastId,
                    }
                },
                loading:function (isLoading) {
                    if(!isLoading){
                        $(calendarEl).removeClass('loading');
                    }else{
                        $(calendarEl).addClass('loading');
                    }
                },
                select: function(arg) {
                    formModal.show({
                        start_date:moment(arg.start).format('YYYY-MM-DD'),
                        end_date:moment(arg.end).format('YYYY-MM-DD'),
                    });
                },
                eventClick:function (info) {
                    var form = Object.assign({},info.event.extendedProps);
                    form.start_date = moment(info.event.start).format('YYYY-MM-DD');
                    form.end_date = moment(info.event.start).format('YYYY-MM-DD');
                    console.log(form);
                    formModal.show(form);
                },
                eventRender: function (info) {
                    $(info.el).find('.fc-title').html(info.event.title);
                }
            });
            calendar.render();
        });

        $('.event-name:first-child a').trigger('click');

        formModal = new Vue({
            el:'#bravo_modal_calendar',
            data:{
                lastResponse:{
                    status:null,
                    message:''
                },
                form:{
                    id:'',
                    price:'',
                    start_date:'',
                    end_date:'',
                    is_instant:'',
                    enable_person:0,
                    min_guests:0,
                    max_guests:0,
                    active:0,
                    number:1
                },
                formDefault:{
                    id:'',
                    price:'',
                    start_date:'',
                    end_date:'',
                    is_instant:'',
                    enable_person:0,
                    min_guests:0,
                    max_guests:0,
                    active:0,
                    number:1
                },
                person_types:[

                ],
                person_type_item:{
                    name:'',
                    desc:'',
                    min:'',
                    max:'',
                    price:'',
                },
                onSubmit:false
            },
            methods:{
                show:function (form) {
                    $(this.$el).modal('show');
                    this.lastResponse.message = '';
                    this.onSubmit = false;

                    if(typeof form !='undefined'){
                        this.form = Object.assign({},form);
                        if(typeof this.form.person_types == 'object'){
                            this.person_types = Object.assign({},this.form.person_types);
                        }

                        if(form.start_date){
                            var drp = $('.has-daterangepicker').data('daterangepicker');
                            drp.setStartDate(moment(form.start_date).format(bookingCore.date_format));
                            drp.setEndDate(moment(form.end_date).format(bookingCore.date_format));

                        }
                    }
                },
                hide:function () {
                    $(this.$el).modal('hide');
                    this.form = Object.assign({},this.formDefault);
                    this.person_types = [];
                },
                saveForm:function () {
                    this.form.target_id = lastId;
                    var me = this;
                    me.lastResponse.message = '';
                    if(this.onSubmit) return;

                    if(!this.validateForm()) return;

                    this.onSubmit = true;
                    this.form.person_types = Object.assign({},this.person_types);
                    $.ajax({
                        url:'{{route('guesthouse.vendor.room.availability.store',['guesthouse_id'=>$guesthouse->id])}}',
                        data:this.form,
                        dataType:'json',
                        method:'post',
                        success:function (json) {
                            if(json.status){
                                if(calendar)
                                    calendar.refetchEvents();
                                me.hide();
                            }
                            me.lastResponse = json;
                            me.onSubmit = false;
                        },
                        error:function (e) {
                            me.onSubmit = false;
                        }
                    });
                },
                validateForm:function(){
                    if(!this.form.start_date) return false;
                    if(!this.form.end_date) return false;

                    return true;
                },
                addItem:function () {
                    console.log(this.person_types);
                    this.person_types.push(Object.assign({},this.person_type_item));
                },
                deleteItem:function (index) {
                    this.person_types.splice(index,1);
                }
            },
            created:function () {
                var me = this;
                this.$nextTick(function () {
                    $('.has-daterangepicker').daterangepicker({ "locale": {"format": bookingCore.date_format}})
                        .on('apply.daterangepicker',function (e,picker) {
                            console.log(picker);
                            me.form.start_date = picker.startDate.format('YYYY-MM-DD');
                            me.form.end_date = picker.endDate.format('YYYY-MM-DD');
                        });

                    $(me.$el).on('hide.bs.modal',function () {

                        this.form = Object.assign({},this.formDefault);
                        this.person_types = [];

                    });

                })
            },
            mounted:function () {
                // $(this.$el).modal();
            }
        });

    </script>
    @endif
@endsection
