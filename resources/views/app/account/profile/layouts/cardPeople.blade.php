<div class="card">
    <div class="card-body">
        <!-- NAME -->
        <h5>{{ $people['name'].' '.$people['lastName'] }}</h5>
        <div class="row">
            <div class="col-12">
                <!-- EMAIL -->
                @if (!empty($people['email']))
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-envelope-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">E-mail</p>
                        <h5 class="mb-0 font-size-14">{{ $people['email'] }}</h5>
                    </div>
                </div>
                @endif
                <!-- PHONE M -->
                @if (!empty($people['phoneM']))
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-phone-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Mobile</p>
                        <h5 class="mb-0 font-size-14 phone">{{ $people['phoneM'] }}</h5>
                    </div>
                </div>
                @endif
                <!-- PHONE W -->
                @if (!empty($people['phoneW']))
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-phone-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Work</p>
                        <h5 class="mb-0 font-size-14 phone">{{ $people['phoneW'] }}</h5>
                    </div>
                </div>
                @endif
                <!-- ADDRESS -->
                @if (!empty($people['address']['line1']))
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-map-marker"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Address</p>
                        <h5 class="mb-0 font-size-14">
                            {{ $people['address']['line1'] }}
                            @if(!empty($people['address']['line2']))
                                <br>
                                {{ $people['address']['line2'] }}
                            @endif
                            <br>
                            @if (!empty($people['address']['city']))
                                {{ $people['address']['city'] }}
                            @endif
                            @if (!empty($people['address']['state']))
                                , {{$people['address']['state']}}
                            @endif
                            @if ($people['address']['zip'])
                                , {{ $people['address']['zip'] }}
                            @endif
                            @if ($people['address']['country'])
                                , {{ $people['address']['country'] }}
                            @endif
                        </h5>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-12 text-end mt-3">
                <button id="btn-editPersonalInfo" type="button" class="btn btn-outline-primary">
                    <span id="spinner-btn-editPersonalInfo" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                    <i class="uil uil-pen"></i> Edit
                </button>
            </div>
        </div>
    </div>
</div>
