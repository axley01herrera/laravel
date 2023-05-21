@if (session('accessAPI') <> 1)

    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-sm-7">
                    <p class="font-size-18">Upgrade your account, request your  <span class="fw-semibold">API</span> access</p>
                    <div class="mt-4">
                        <!-- BTN REQUEST API ACCESS -->
                        <button type="button" id="btn-requestApiAccess" class="btn btn-primary">
                            <span id="spinner-btn-requestApiAccess" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                            Request
                        </button>
                    </div>
                </div>
                <div class="col-sm-5">
                    <img src="assets/images/illustrator/2.png" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>

@else

    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-sm-7">
                    <p class="font-size-18">The <span class="fw-semibold">API</span> access is already enabled</p>

                </div>
                <div class="col-sm-5">
                    <img src="assets/images/illustrator/2.png" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>

@endif
