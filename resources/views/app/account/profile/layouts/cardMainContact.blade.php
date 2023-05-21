<div class="card">
    <div class="card-body">
        <h5>Main Contact</h5>
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-chat-bubble-user"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Name</p>
                        <h5 class="mb-0 font-size-14">{{$company['contact']['person']['name']}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-envelope-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Email</p>
                        <h5 class="mb-0 font-size-14">{{$company['contact']['person']['email']}}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-phone-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Mobile</p>
                        <h5 class="mb-0 font-size-14 phone">{{$company['contact']['person']['phoneC']}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-phone-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Work</p>
                        <h5 class="mb-0 font-size-14 phone">{{$company['contact']['person']['phoneW']}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-phone-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Ext</p>
                        <h5 class="mb-0 font-size-14">{{$company['contact']['person']['phoneExt']}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-12 text-end mt-3">
                <button id="btn-editCompanyContactPerson" type="button" class="btn btn-outline-primary">
                    <span id="spinner-btn-editCompanyContactPerson" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                    <i class="uil uil-pen"></i> Edit
                </button>
            </div>
        </div>
    </div>
</div>