<!-- PAGE HEADER -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h3>Name: <span class="text-primary">{{$people['name'].' '.$people['lastName']}}</span></h3>
            <a id="btn-back" href="#"><i class="uil uil-arrow-left"></i> back</a>
        </div>
    </div>
</div>
<!-- PAGE CONTENT -->
<div class="row">
    <div class="col-12 col-md-4 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="avatar-xl mx-auto mb-4">
                    <img src="assets/images/users/avatar.png" alt="" class="rounded-circle img-thumbnail">
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex align-items-center mt-3">
                            <div class="font-size-20 text-primary flex-shrink-0 me-3">
                                <i class="uil uil-envelope-alt"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1 font-size-13">E-mail</p>
                                <h5 class="mb-0 font-size-14">{{$people['email']}}</h5>
                            </div>
                        </div>
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

                        @if (!empty($people['address']['line1']))

                        <div class="d-flex align-items-center mt-3">
                            <div class="font-size-20 text-primary flex-shrink-0 me-3">
                                <i class="uil uil-map-marker"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1 font-size-13">Address</p>
                                <h5 class="mb-0 font-size-14">
                                    @if (!empty($people['address']['line1']))
                                        {{ $people['address']['line1'] }}
                                    @endif
                                    @if(!empty($people['address']['line2']))
                                        <br>
                                        {{ $people['address']['line2'] }}
                                    @endif
                                    <br>
                                    @if (!empty($people['address']['city']))
                                        {{ $people['address']['city'] }},
                                    @endif
                                    @if (!empty($people['address']['state']))
                                        {{$people['address']['state']}},
                                    @endif
                                    @if ($people['address']['zip'])
                                        {{ $people['address']['zip'] }},
                                    @endif
                                    @if ($people['address']['country'])
                                        {{ $people['address']['country'] }}
                                    @endif
                                </h5>
                            </div>
                        </div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/customFunction/mask.js"></script>
<script>
    $(document).ready(function () {

        $('#btn-back').on('click', function (event) { // BACK BTN
            event.preventDefault();
            $('#link-contacts').trigger('click');
        });
    });
</script>
