<div class="card">
    <div class="card-body">
        <h5>Billing Address</h5>
        <div class="row">
            <div class="col-12">
                @if (!empty($company['billing']['address']['line1']))
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-map-marker"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Address</p>
                        <h5 class="mb-0 font-size-14">
                            {{ $company['billing']['address']['line1'] }}
                            @if(!empty($company['billing']['address']['line2']))
                               <br> {{ $company['billing']['address']['line2'] }}
                            @endif
                            <br>
                            @if (!empty($company['billing']['address']['city']))
                                {{ $company['billing']['address']['city'] }}
                            @endif
                            @if (!empty($company['billing']['address']['state']))
                                , {{ $company['billing']['address']['state'] }}
                            @endif
                            @if (!empty($company['billing']['address']['zip']))
                                , {{$company['billing']['address']['zip']}}
                            @endif
                            @if (!empty($company['billing']['address']['country']))
                                , {{$company['billing']['address']['country']}}
                            @endif
                        </h5>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-12 text-end mt-3">
                <button id="btn-setBillingAddress" type="button" class="btn btn-outline-primary">
                    <span id="spinner-btn-setBillingAddress" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                    <i class="bx bx-copy-alt clipboard"></i> Same as Company Address
                </button>
                <button id="btn-editCompanyBillingAddress" type="button" class="btn btn-outline-primary">
                    <span id="spinner-btn-editCompanyBillingAddress" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                    <i class="uil uil-pen"></i> Edit
                </button>
            </div>
        </div>
    </div>
</div>
