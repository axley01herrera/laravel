
<style>
    @media print {
    .noprint {
        visibility: hidden;
        }
    }
</style>
<!-- PAGE HEADER -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h3>Invoice #: <span class="text-primary">{{ $invoice['number'] }}</span></h3>
            <div class="page-title-right">
                <a id="btn-backToInvoiceList" href="#"><i class="uil uil-arrow-left"></i> back</a>
            </div>
        </div>
    </div>
</div>
<!-- PAGE CONTENT -->
<div class="row" id="printPage">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-4">
                        <div>
                            <img src="assets/images/logo/logoInvoice.png" alt="logo" width="100px" />
                            <p style="color: #1863b2; margin-left: 4px;font-size: 25px;">INVOICE</p>
                        </div>
                        <div class="mt-3">
                            <h5 class="font-size-16 mb-3">Billed To:</h5>
                            <p class="mb-1"><span class="font-size-20">{{$invoice['BilledTo']['companyName']}}</p>
                        </div>
                        <div class="text-muted">
                            <p class="mb-1">
                                {{$invoice['BilledTo']['address']['line1']}}
                                @if (!empty($invoice['BilledTo']['address']['line2'])) <br> {{$invoice['BilledTo']['address']['line2']}}@endif
                                <br>
                                {{$invoice['BilledTo']['address']['city']}}, {{$invoice['BilledTo']['address']['state']}}, {{$invoice['BilledTo']['address']['zip']}}, {{$invoice['BilledTo']['address']['country']}}
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 text-center mt-5">
                        <div style="border: solid; border-radius: 0.25rem;" class="text-center noprint">
                            <h1 class="display-5">{{ $invoice['labelStatus'] }}</h1>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 text-end">
                        <p class="mb-1"><span class="font-size-20">Isak Computing, LLC</span> <br> 11880 28th Street North, Suite 125 <br> Saint Petersburg, Florida 33716</p>
                        <div class="text-muted">
                            <p class="mb-1"><i class="uil uil-envelope-alt me-1"></i> sales@isakcomputing.com</p>
                        </div>
                        <div class="row text-muted mt-5">
                            <div class="col-12">
                                <h5 class="font-size-15 mb-1">INVOICE # {{$invoice['number']}}</h5>
                            </div>
                            <div class="col-12">
                                <h5 class="font-size-15 mb-1">DATE {{$invoice['invoiceDate']}}</h5>
                                <p></p>
                            </div>
                            <div class="col-12">
                                <h5 class="font-size-15 mb-1">TERMS {{$invoice['terms']}}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="py-2">
                    <h5 class="font-size-15">Invoice Lines</h5>

                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-centered mb-0">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>ProductCode</th>
                                    <th>Description</th>
                                    <th style="width: 120px;" class="text-end">Quantity</th>
                                    <th style="width: 120px;" class="text-end">Price</th>
                                    <th style="width: 120px;" class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < $countInvoiceLines; $i++)
                                <tr>
                                    <td>{{$invoiceLines[$i]['productName']}}</td>
                                    <td>{{$invoiceLines[$i]['productCode']}}</td>
                                    <td>{{$invoiceLines[$i]['description']}}</td>
                                    <td class="text-end">{{$invoiceLines[$i]['qty']}}</td>
                                    <td class="text-end">$ {{$invoiceLines[$i]['price']}}</td>
                                    <td class="text-end">$ {{$invoiceLines[$i]['amount']}}</td>
                                </tr>
                                @endfor
                                <tr>
                                    <th scope="row" colspan="5" class="text-end border-0"><h4 class="m-0 fw-semibold">Sub Total</h4></th>
                                    <td class="border-0 text-end"><h4 class="m-0 fw-semibold">$ {{ $invoice['subTotalAmount'] }}</h4></td>
                                </tr>

                                <tr>
                                    <th scope="row" colspan="5" class="border-0 text-end"><h4 class="m-0 fw-semibold">Discount</h4></th>
                                    <td class="border-0 text-end"><h4 class="m-0 fw-semibold">$ {{ $invoice['discountAmount'] }}</h4></td>
                                </tr>
                                <tr>
                                    <th scope="row" colspan="5" class="border-0 text-end"><h4 class="m-0 fw-semibold">Total</h4></th>
                                    <td class="border-0 text-end"><h4 class="m-0 fw-semibold">$ {{ $invoice['totalAmount'] }}</h4></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    @if ($countInvoicePayments > 0)

                    <h5 class="font-size-15">Invoice Payments</h5>

                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-centered mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>DateExpected</th>
                                    <th class="text-center">Status</th>
                                    <th style="width: 120px;" class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < $countInvoicePayments; $i++)
                                <tr>
                                    <td>{{$invoicePayments[$i]['date']}}</td>
                                    <td>{{$invoicePayments[$i]['dateExpected']}}</td>
                                    <td class="text-center"><?php echo $invoicePayments[$i]['statusLabel'];?></td>
                                    <td class="text-end">$ {{$invoicePayments[$i]['amount']}}</td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>

                    @endif

                    @if (!empty($invoice['file']))

                    <div class="d-print-none mt-4">
                        <div class="float-end" id="printInvoice" style="cursor: pointer">
                            <a class="btn btn-success me-1"><i class="fa fa-file-pdf"></i></a>
                            <!--a href="javascript:window.print()" class="btn btn-success me-1"><i class="fa fa-file-pdf"></i></a-->
                            <!-- <a href="#" class="btn btn-primary w-md">Send</a> -->
                        </div>
                    </div>

                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/customFunction/mask.js"></script>
<script>
    $(document).ready(function () {

        $('#btn-backToInvoiceList').on('click', function (event) { // BACK BTN

            event.preventDefault()
            $('#link-invoices').trigger('click');
        });

        $('#printInvoice').on('click', function () {

            var w = window.open("<?php echo $invoice['file']?>", "_blank");
            w.onload = (event) => {
                setTimeout(function () {
                    w.print();
                }, 5000);
            };

        });

    });
</script>
