<!-- PAGE HEADER -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h3>Dashboard</h3>
        </div>
    </div>
</div>
<!-- PAGE CONTENT -->
<div class="row">
    <div class="col-12 col-lg-3">

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="font-size-xs text-uppercase">Default Payment Method</h6>
                    </div>
                </div>
                <div id="main-paymentMethod" class="mt-3" ></div>
            </div>
        </div>

        <!-- CARD REQUEST API -->
        @include('app.dashboard.layouts.cardRequestApi')

        <!-- CHART ORDERS-->
        @include('app.dashboard.layouts.chartOrders')

    </div>

    <div class="col-12 col-lg-9">

        <!-- TABLE UNPAID INVOICES -->
        @include('app.dashboard.layouts.tableUnpaidInvoices')

        <!-- TABLE OPEN TICKETS -->
        @include('app.dashboard.layouts.tableTickets')

    </div>
</div>

<script>
    $(document).ready(function () {

        getDefaultPaymentMethod();
        getUnpaidInvoices();
        getNewTicket();

        let accessAPI = '<?php echo session('accessAPI')?>';
        let optionsOrder = {

            series: [{
                name: 'Calls',
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            }],
            chart: {
                type:"bar",
                height:50,
                sparkline:{
                    enabled:!0
                }
            },
            plotOptions: {
                bar: {
                    columnWidth:"50%"
                }
            },
            tooltip: {
                fixed: {
                    enabled:!1
                },
                y: {
                    title: {
                        formatter:function(value) {
                            return value
                        }
                    }
                }
            },
            colors:["#038edc"],
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                position: 'top',
            }
        };

        if (accessAPI === '1')
        {

            globalThis.chartOrder = new ApexCharts(document.querySelector("#chart-order"), optionsOrder);
            globalThis.chartOrder.render();

            getOrderChartData();

        }



        /*var optionsBills = {
            series: [{
            name: 'Calls',
            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            }],
            chart:{
            type:"bar",
            height:50,
            sparkline:{
                enabled:!0
            }
            },
            plotOptions:{
                bar:{
                    columnWidth:"50%"
                }
            },
            tooltip:{
            fixed:{
                enabled:!1
            },
            y:{
                title:{
                    formatter:function(e){
                        return""}
                    }
                }
            },
            colors:["#038edc"]
        };*/

        /*let chartBills = new ApexCharts(document.querySelector("#chart-bills"), optionsBills);
        chartBills.render();*/

        $('#btn-requestApiAccess').on('click', function () { // REQUEST ACCESS API

            $('#btn-requestApiAccess').attr('disabled', true);
            $('#spinner-btn-requestApiAccess').removeAttr('hidden');

            $.ajax({

                type: "post",
                url: "{{ route('requestApiAccess') }}",
                dataType: "json",

            }).done(function(jsonResponse) {

                switch(jsonResponse.error) {

                    case 0:
                        Swal.fire({
                            title: jsonResponse.userMsg,
                            showClass: {popup: 'animate__animated animate__fadeInDown'},
                            hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                            position: 'top-end',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    break

                    case 1:
                        Swal.fire({
                            title: jsonResponse.userMsg,
                            showClass: {popup: 'animate__animated animate__fadeInDown'},
                            hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                            position: 'top-end',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        if(jsonResponse.userMsg == 'Session Expired')
                            window.location.reload();
                    break
                }

                $('#btn-requestApiAccess').removeAttr('disabled');
                $('#spinner-btn-requestApiAccess').attr('hidden', true);

            }).fail(function(error) {

                Swal.fire({
                    title: 'Session Expired',
                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                    position: 'top-end',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                });

                $('#btn-requestApiAccess').removeAttr('disabled');
                $('#spinner-btn-requestApiAccess').attr('hidden', true);

                window.location.reload();

            });
        });

        //getChartBillData();

        /*function getChartBillData() { // GET ORDER CHART DATA

            $.ajax({

                type: "post",
                url: "{{ route('getChartBillData')}}",
                dataType: "json",

            }).done(function(jsonResponse) {

                switch(jsonResponse.error) {

                    case 0:
                        $('#lbl-totalBills').html(jsonResponse.totalAmount);

                        optionsBills.series[0].data[11] = jsonResponse['dec'];
                        optionsBills.series[0].data[10] = jsonResponse['nov'];
                        optionsBills.series[0].data[9] = jsonResponse['oct'];
                        optionsBills.series[0].data[8] = jsonResponse['sep'];
                        optionsBills.series[0].data[7] = jsonResponse['aug'];
                        optionsBills.series[0].data[6] = jsonResponse['jul'];
                        optionsBills.series[0].data[5] = jsonResponse['jun'];
                        optionsBills.series[0].data[4] = jsonResponse['may'];
                        optionsBills.series[0].data[3] = jsonResponse['apr'];
                        optionsBills.series[0].data[2] = jsonResponse['mar'];
                        optionsBills.series[0].data[1] = jsonResponse['feb'];
                        optionsBills.series[0].data[0] = jsonResponse['jan'];

                        chartBills.destroy();

                        chartBills = new ApexCharts(document.querySelector("#chart-bills"), optionsBills);
                        chartBills.render();
                    break

                    case 1:
                        Swal.fire({
                            title: jsonResponse.userMsg,
                            showClass: {popup: 'animate__animated animate__fadeInDown'},
                            hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                            position: 'top-end',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    break
                }

            }).fail(function(error) {

                Swal.fire({
					title: 'Session Expired',
					showClass: {popup: 'animate__animated animate__fadeInDown'},
					hideClass: {popup: 'animate__animated animate__fadeOutUp'},
					position: 'top-end',
					icon: 'error',
					showConfirmButton: false,
					timer: 1500
				});

            })
        }*/

        function getOrderChartData() { // GET ORDER CHART DATA

            $.ajax({

                type: "post",
                url: "{{ route('getOrderChartData')}}",
                dataType: "json",

            }).done(function(jsonResponse) {

                switch(jsonResponse.error) {

                    case 0:
                        $('#lbl-totalOrders').html(jsonResponse.totalOrders);

                        optionsOrder.series[0].data[11] = jsonResponse['dec'];
                        optionsOrder.series[0].data[10] = jsonResponse['nov'];
                        optionsOrder.series[0].data[9] = jsonResponse['oct'];
                        optionsOrder.series[0].data[8] = jsonResponse['sep'];
                        optionsOrder.series[0].data[7] = jsonResponse['aug'];
                        optionsOrder.series[0].data[6] = jsonResponse['jul'];
                        optionsOrder.series[0].data[5] = jsonResponse['jun'];
                        optionsOrder.series[0].data[4] = jsonResponse['may'];
                        optionsOrder.series[0].data[3] = jsonResponse['apr'];
                        optionsOrder.series[0].data[2] = jsonResponse['mar'];
                        optionsOrder.series[0].data[1] = jsonResponse['feb'];
                        optionsOrder.series[0].data[0] = jsonResponse['jan'];

                        globalThis.chartOrder.destroy();

                        globalThis.chartOrder = new ApexCharts(document.querySelector("#chart-order"), optionsOrder);
                        globalThis.chartOrder.render();
                        break

                    case 1:
                        Swal.fire({
                            title: jsonResponse.userMsg,
                            showClass: {popup: 'animate__animated animate__fadeInDown'},
                            hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                            position: 'top-end',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        break
                }

            }).fail(function(error) {

                Swal.fire({
                    title: 'Session Expired',
                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                    position: 'top-end',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                });

            })
        }

        function getDefaultPaymentMethod() { // GET DEFAULT PAYMENT
            $.ajax({
                type: "post",
                url: "{{ route('defaultPaymentMethod') }}",
                dataType: "html",
            }).done(function(htmlResponse) {
                $('#main-paymentMethod').html(htmlResponse);
            }).fail(function(error) {
                Swal.fire({
					title: 'An error has ocurred',
					showClass: {popup: 'animate__animated animate__fadeInDown'},
					hideClass: {popup: 'animate__animated animate__fadeOutUp'},
					position: 'top-end',
					icon: 'error',
					showConfirmButton: false,
					timer: 1500
				});
            });
        }

        function getUnpaidInvoices() { // GET UNPAID INVICES
            $.ajax({
                type: "post",
                url: "{{ route('getUnpaidInvoices') }}",
                dataType: "html",
            }).done(function(htmlResponse) {
                $('#tbody-dashboard-invoices').html(htmlResponse);
            }).fail(function(error) {
                Swal.fire({
					title: 'An error has ocurred',
					showClass: {popup: 'animate__animated animate__fadeInDown'},
					hideClass: {popup: 'animate__animated animate__fadeOutUp'},
					position: 'top-end',
					icon: 'error',
					showConfirmButton: false,
					timer: 1500
				});
            });
        }

        function getNewTicket() { // GET NEW TICKETS
            $.ajax({
                type: "post",
                url: "{{ route('getNewTicket') }}",
                dataType: "html",
            }).done(function(htmlResponse) {
                $('#tbody-dashboard-newTicket').html(htmlResponse);
            }).fail(function(error) {
                Swal.fire({
					title: 'An error has ocurred',
					showClass: {popup: 'animate__animated animate__fadeInDown'},
					hideClass: {popup: 'animate__animated animate__fadeOutUp'},
					position: 'top-end',
					icon: 'error',
					showConfirmButton: false,
					timer: 1500
				});
            });
        }

    });
</script>




