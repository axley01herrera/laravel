<div class="card">
    <div class="card-body">
        <h5>Shipping Address</h5>
        <div class="row">
            <div class="col-12">
                @if (!empty($company['shipping']['address']['line1']))
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-map-marker"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Address</p>
                        <h5 class="mb-0 font-size-14">
                            {{ $company['shipping']['address']['line1'] }}
                            @if(!empty($company['shipping']['address']['line2']))
                                <br>
                                {{$company['shipping']['address']['line2']}}
                            @endif
                            <br>
                            @if (!empty($company['shipping']['address']['city']))
                                {{ $company['shipping']['address']['city'] }}
                            @endif
                            @if (!empty($company['shipping']['address']['state']))
                                , {{ $company['shipping']['address']['state'] }}
                            @endif
                            @if (!empty($company['shipping']['address']['zip']))
                                , {{ $company['shipping']['address']['zip'] }}
                            @endif
                            @if (!empty($company['shipping']['address']['country']))
                                , {{ $company['shipping']['address']['country'] }}
                            @endif
                        </h5>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-12 text-end mt-3">
                <button id="btn-setShippingAddress" type="button" class="btn btn-outline-primary">
                    <span id="spinner-btn-setShippingAddress" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                    <i class="bx bx-copy-alt clipboard"></i> Same as billing
                </button>
                <button id="btn-editCompanyShippingAddress" type="button" class="btn btn-outline-primary">
                    <span id="spinner-btn-editCompanyShippingAddress" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                    <i class="uil uil-pen"></i> Edit
                </button>
            </div>
        </div>
    </div>
</div>
