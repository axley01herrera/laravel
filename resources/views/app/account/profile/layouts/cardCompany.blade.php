<div class="card">
    <div class="card-body">
        <h5>Company</h5>
        <div class="row">
            <div class="col-12">
                <!-- NAME -->
                @if (!empty($company['name']))
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-building"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Name</p>
                        <h5 class="mb-0 font-size-14">{{ $company['name'] }}</h5>
                    </div>
                </div>
                @endif
                <!-- EMAIL -->
                @if (!empty($company['email']))
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-envelope-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Email</p>
                        <h5 class="mb-0 font-size-14">{{ $company['email'] }}</h5>
                    </div>
                </div>
                @endif
                <!-- PHONE -->
                @if (!empty($company['phone']))
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-phone-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">{{ $company['phoneType'] }}</p>
                        <h5 class="mb-0 font-size-14 "><span class="phone">{{ $company['phone'] }}</span></h5>
                    </div>
                </div>
                @endif
                <!-- ADDRESS -->
                @if(!empty($company['address']['line1']))
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-map-marker"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Address</p>
                        <h5 class="mb-0 font-size-14">
                            {{ $company['address']['line1'] }}
                            @if(!empty($company['address']['line2']))
                                <br>
                                {{$company['address']['line2']}}
                            @endif
                            <br>
                            @if (!empty($company['address']['city']))
                                {{ $company['address']['city'] }}
                            @endif
                            @if (!empty($company['address']['state']))
                                , {{ $company['address']['state'] }}
                            @endif
                            @if (!empty($company['address']['zip']))
                                , {{$company['address']['zip']}}
                            @endif
                            @if (!empty($company['address']['country']))
                                , {{$company['address']['country']}}
                            @endif
                        </h5>
                    </div>
                </div>
                @endif
                @if (!empty($company['url']))
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-globe"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Web Site</p>
                        <h5 class="mb-0 font-size-14">{{ $company['url'] }}</h5>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-12 text-end mt-3">
                <button id="btn-editCompanyInfo" type="button" class="btn btn-outline-primary">
                    <span id="spinner-btn-editCompanyInfo" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                    <i class="uil uil-pen"></i> Edit
                </button>
            </div>
        </div>
    </div>
</div>
