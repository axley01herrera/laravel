<!-- PAGE HEADER -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h3>Contract #: <span class="text-primary">{{ $contract['id'] }}</span></h3>
            <div class="page-title-right">
                <a id="btn-back" href="#"><i class="uil uil-arrow-left"></i> back</a>
            </div>
        </div>
    </div>
</div>
<!-- PAGE CONTENT -->
<div class="row">
    <div class="col-12 col-md-4 col-lg-4">
        <!-- CARD CONTRACT INFO -->
        <div class="card">
            <div class="card-body">
                <h5>Contract Detail</h5>
                <div class="row">
                    <div class="col-12">
                        <!-- DATE START -->
                        <div class="d-flex align-items-center mt-3">
                            <div class="font-size-20 text-primary flex-shrink-0 me-3">
                                <i class="uil uil-calendar-alt"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1 font-size-13">Start Date</p>
                                <h5 class="mb-0 font-size-14">{{ $contract['dateStart'] }}</h5>
                            </div>
                        </div>
                        <!-- DATE EXPIRE -->
                        <div class="d-flex align-items-center mt-3">
                            <div class="font-size-20 text-primary flex-shrink-0 me-3">
                                <i class="uil uil-calendar-alt"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1 font-size-13">End Date</p>
                                <h5 class="mb-0 font-size-14">{{ $contract['dateExpire'] }}</h5>
                            </div>
                        </div>
                        <!-- RENEWAL WINDOW -->
                        <div class="d-flex align-items-center mt-3">
                            <div class="font-size-20 text-primary flex-shrink-0 me-3">
                                <i class="uil uil-calendar-alt"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1 font-size-13">Renewal Window</p>
                                <h5 class="mb-0 font-size-14">{{ $contract['dateStartRenewal'] }} to {{ $contract['dateExpire'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-8 col-lg-8">
        <!-- CARD EXHIBIT B - FEE SCHEDULE -->
        <div class="card">
            <div class="card-body">
                <div>
                    <h5>Exhibit B - Fee Schedule</h5>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mt-3" style="width: 100%;">
                            <!-- DATA TABLE -->
                            <table id="dataTable-Products" class="table" style="width: 100%;">
                                <thead >
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                </tr>
                                </thead>
                                <tbody id="tbody-contract-Products">
                                    @for ($i = 0; $i < $countProducts; $i++)
                                        <tr style="height: 60px">
                                            <td class="p-2"><p class="mb-0">{{ $products[$i]['productName'] }}</p><p class="mb-0"><small>{{ $products[$i]['description'] }}</small></p></td>
                                            <td class="p-2">{{ $products[$i]['price'] }}</td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        $('#btn-back').on('click', function (event) { // BACK BTN
            event.preventDefault()
            $('#link-contracts').trigger('click');
        });

        let productDT = $('#dataTable-Products').DataTable({

            "searching": false,
            "ordering": false,
        });

    });
</script>
