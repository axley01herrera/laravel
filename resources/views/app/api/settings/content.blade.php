<!-- PAGE CONTENT -->
<div class="row">
    <div class="col-12">
        <!-- SECTION KEYS -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <h5>Generate Keys</h5>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 text-end">
                        <!-- BTN GENERATE KEYS -->
                        <button id="btn-generateKeysAPI" type="button" class="btn btn-primary">
                            <span id="spinner-btn-generateKeysAPI" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                            Generate
                        </button>
                    </div>
                </div>
                <div class="row">
                    <!-- CLIENT ID -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="col-6">
                                <label for="txt-apiClientID" class="text-primary "><i class="mdi mdi-key"></i> Client ID</label>
                            </div>
                            <div class="col-6 text-end">
                                <label><i style="cursor: pointer;" class="text-primary bx bx-copy-alt clipboard" title="copy" data-clipboard-target="#txt-apiClientID"></i></label>
                            </div>
                            <div class="col-12">
                                <input type="password" id="txt-apiClientID"  class="form-control hide-password password" data-show="0" value="{{$contact['orgClientID']}}" readonly />
                            </div>
                        </div>
                    </div>
                    <!-- CLIENT SECRET -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="col-6">
                                <label for="txt-apiClientSecret" class="text-primary "><i class="mdi mdi-key"></i> Client Secret</label>
                            </div>
                            <div class="col-6 text-end">
                                <label><i style="cursor: pointer;" class="text-primary bx bx-copy-alt clipboard" title="copy" data-clipboard-target="#txt-apiClientSecret"></i></label>
                            </div>
                            <div class="col-12">
                                <input type="password" id="txt-apiClientSecret"  class="form-control hide-password password" data-show="0" value="{{$contact['orgClientSecret']}}" readonly />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- SECTION HOST CONFIGURATION
        <div class="card">
            <div class="card-body">
                <h5>Credentials</h5>
                <div class="row">

                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="txt-apiHost"><strong>Host</strong></label>
                        <input type="text" id="txt-apiHost"  class="form-control required" value="{{$contact['orgICHostname']}}" />
                    </div>

                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="txt-apiFile"><strong>File</strong></label>
                        <input type="text" id="txt-apiFile" class="form-control required" value="{{$contact['orgICFileName']}}" />
                    </div>

                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="txt-apiUser"><strong>User</strong></label>
                        <input type="text" id="txt-apiUser"  class="form-control required" value="{{$contact['orgICUsername']}}" />
                    </div>

                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="txt-apiPassword"><strong>Password</strong></label>
                        <input type="password" id="txt-apiPassword"  class="form-control required hide-password password" value="{{$contact['orgICPassword']}}" />
                    </div>

                    <div class="col-12 text-end mt-2">
                        <button type="button" id="btn-apiSaveHost" class="btn btn-primary">
                            <span id="spinner-btn-apiSaveHost" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
        -->
        <!-- SECTION HOST CONFIGURATION -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <h5>Tokens</h5>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 text-end">
                        <!-- BTN GET TOKEN -->
                        <button type="button" id="btn-apiGetToken" class="btn btn-primary">
                            <span id="spinner-btn-apiGetToken" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                            Get Token
                        </button>
                    </div>
                </div>
                <div class="row">
                    <!-- TOKEN
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="col-6">
                                <label for="txt-apiToken" class="text-primary "><i class="mdi mdi-key"></i> Token</label>
                            </div>
                            <div class="col-6 text-end">
                                <label><i style="cursor: pointer;" class="text-primary bx bx-copy-alt clipboard" title="copy" data-clipboard-target="#txt-apiToken"></i></label>
                            </div>
                            <div class="col-12">
                                <input type="text" id="txt-apiToken" class="form-control" value="{{$contact['orgICAPIToken']}}" readonly />
                            </div>
                        </div>
                    </div>-->
                    <div class="col-12">
                        <!-- DATA TABLE -->
                        <div class="table-responsive mt-3" style="width: 100%;">
                            <table id="dataTable-tokens" class="table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-start">Token</th>
                                        <th class="text-start">Expiration Date</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
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

        loadTokensDT();

        let clipboard = new ClipboardJS('.clipboard');

        $('.password').on('click', function () { // SHOW HIDE PASSWORD

            let show = $(this).attr('data-show');

            if(show == 0) {
                $(this).removeClass('hide-password');
                $(this).addClass('show-password');
                $(this).attr('data-show', '1');
                $(this).attr('type', 'text');

            } else {
                $(this).removeClass('show-password');
                $(this).addClass('hide-password');
                $(this).attr('data-show', '0');
                $(this).attr('type', 'password');
            }

        });

        $('.clipboard').on('click', function () { // CLIP BOARD ID

            let input = $(this).attr('data-clipboard-target');
            let show = $(input).attr('data-show'); console.log(show);

            if(show == 0) {
                $(input).removeClass('hide-password');
                $(input).addClass('show-password');
                $(input).attr('data-show', '1');
                $(input).attr('type', 'text');
            }

            $(this).removeClass('bx bx-copy-alt');
            $(this).removeClass('text-primary');

            $(this).addClass('bx bx-check-double');
            $(this).addClass('text-success');

            setTimeout(() => {

                $(this).removeClass('bx bx-check-double');
                $(this).removeClass('text-success');

                $(this).addClass('bx bx-copy-alt');
                $(this).addClass('text-primary');

                if(show == 0) {
                    $(input).removeClass('show-password');
                    $(input).addClass('hide-password');
                    $(input).attr('data-show', '0');
                    $(input).attr('type', 'password');
                }

            }, "1000");

            clipboard.on('success', function(e) {

                console.info('Action:', e.action);
                console.info('Text:', e.text);

                e.clearSelection();
            });

            clipboard.on('error', function(e) {
                console.error('Action:', e.action);
                console.error('Trigger:', e.trigger);
            });
        });

        $('#btn-generateKeysAPI').on('click', function () { // GENERATE KEYS

            Swal.fire({ // ALERT WARNING
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6e7881',
                confirmButtonText: 'Yes, generate new keys!',
                customClass: {confirmButton: 'generateKeys'}
            });

            $('.generateKeys').on('click', function () { // ACTION GENERATE KEYS

                $('#btn-generateKeysAPI').attr('disabled', true);
                $('#spinner-btn-generateKeysAPI').removeAttr('hidden');

                let post = {
                    clientID: $('#txt-apiClientID').val(),
                    clientSecret: $('#txt-apiClientSecret').val(),
                }

                $.ajax({

                    type: "post",
                    url: "{{ route('generateOrganizationsKeys') }}",
                    data: {post},
                    dataType: "json"

                }).done(function(jsonResponse) {

                    switch(jsonResponse.error) {

                        case 0:
                            $('#txt-apiClientID').val(jsonResponse.clientID);
                            $('#txt-apiClientSecret').val(jsonResponse.clientSecret);
                        break

                        case 0:
                            Swal.fire({
                                title: jsonResponse.userMsg,
                                showClass: {popup: 'animate__animated animate__fadeInDown'},
                                hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                                position: 'top-end',
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            if(jsonResponse.userMsg == "Session Expired")
                                windows.location.reload();
                        break
                    }

                    $('#btn-generateKeysAPI').removeAttr('disabled');
                    $('#spinner-btn-generateKeysAPI').attr('hidden', true);

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

                    windows.location.reload();

                });
            });
        });

        $('#btn-apiSaveHost').on('click', function () { // UPDATE CREDENTIALS

            let formRequiredValues = requiredValues();

            if(formRequiredValues === 0) { // NOT REQUIRED VALUES

                Swal.fire({ // ALERT WARNING
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#6e7881',
                    confirmButtonText: 'Yes, update credentials!',
                    customClass: {confirmButton: 'updateCredentials'}
                });

                $('.updateCredentials').on('click', function () { // ACTION UPDATE CREDENTIALS

                    $('#btn-apiSaveHost').attr('disabled', true);
                    $('#spinner-btn-apiSaveHost').removeAttr('hidden');

                    let post = {
                        currentHost: "{{$contact['orgICHostname']}}",
                        currentFile: "{{$contact['orgICFileName']}}",
                        currentUser: "{{$contact['orgICUsername']}}",
                        currentPassword: "{{$contact['orgICPassword']}}",
                        host: $('#txt-apiHost').val(),
                        file: $('#txt-apiFile').val(),
                        user: $('#txt-apiUser').val(),
                        password: $('#txt-apiPassword').val(),
                    }

                    $.ajax({

                        type: "post",
                        url: "{{ route('updateCredentials') }}",
                        data: {post},
                        dataType: "json"

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

                            case 0:
                                Swal.fire({
                                    title: jsonResponse.userMsg,
                                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                                    position: 'top-end',
                                    icon: 'error',
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                if(jsonResponse.userMsg == "Session Expired")
                                    windows.location.reload();
                            break
                        }

                        $('#btn-apiSaveHost').removeAttr('disabled');
                        $('#spinner-btn-apiSaveHost').attr('hidden', true);

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

                        windows.location.reload();

                    });
                });
            } else { // ERROR REQUIRED FIELDS

                Swal.fire({
                    title: 'Error required fields',
                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                    icon: 'error',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500
                });

            }
        });

        $('#btn-apiGetToken').on('click', function () { // GET TOKEN

            $('#btn-apiGetToken').attr('disabled', true);
            $('#spinner-btn-apiGetToken').removeAttr('hidden');

            let post = {
                clientID: $('#txt-apiClientID').val(),
                clientSecret: $('#txt-apiClientSecret').val(),
            }

            $.ajax({

                type: "post",
                url: "{{ route('getToken') }}",
                data: {post},
                dataType: "json"

            }).done(function(jsonResponse) { console.log(jsonResponse);

                switch(jsonResponse.error) {

                    case 0:
                        loadTokensDT();
                    break

                    case 0:
                        Swal.fire({
                            title: jsonResponse.userMsg,
                            showClass: {popup: 'animate__animated animate__fadeInDown'},
                            hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                            position: 'top-end',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        if(jsonResponse.userMsg == "Session Expired")
                            windows.location.reload();
                    break
                }

                $('#btn-apiGetToken').removeAttr('disabled');
                $('#spinner-btn-apiGetToken').attr('hidden', true);

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

                windows.location.reload();

            })

        });

        function loadTokensDT() { // DT TOKENS

            let tokensDT = $('#dataTable-tokens').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                responsive: true,
                bAutoWidth: true,
                pageLength: 5,
                lengthMenu: [[5, 10, 20, 25, 50, 100], [5, 10, 20, 25, 50, 100]],

                ajax : {
                    url: "{{ route('tokensDataTable') }}",
                    type: "POST"
                },

                "order": [
                    [1, 'desc']
                ],

                columns: [
                    {
                        data: 'token',
                    },
                    {
                        data: 'ExpirationDate',
                    },
                    {
                        data: 'status',
                        class: 'text-center',
                        orderable: false
                    },
                    {
                        data: 'btnRevoke',
                        class: 'text-center',
                        orderable: false
                    }
                ],
            });

            tokensDT.on('error', function () {

                Swal.fire({
                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                    position: 'top-end',
                    icon: 'error',
                    title: 'Session Expired',
                    showConfirmButton: false,
                    timer: 1500
                });

                setTimeout(() => {
                    window.location.href="{{ route('login') }}";
                }, "2000");

            });

            tokensDT.on('click', '.revoke', function() {

                let tokenRecordID = $(this).attr('data-recordid');
                let tokenDate = $(this).attr('data-expiration');

                Swal.fire({ // ALERT WARNING
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#6e7881',
                    confirmButtonText: 'Yes, revoke it!',
                    customClass: {confirmButton: 'revokeToken'}
                });

                $('.revokeToken').on('click', function () { // REVOKE TOKEN

                    var target = document.getElementById('spinner');
                    var spinner = new Spinner(opts).spin(target);

                    let post = {
                        tokenRecordID: tokenRecordID,
                        tokenDate: tokenDate
                    }

                    $.ajax({

                        type: "post",
                        url: "{{route('revokeToken')}}",
                        data: {post},
                        dataType: "json",

                    }).done(function(jsonResponse) { console.log(jsonResponse)

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

                                loadTokensDT();
                            break

                            case 1:
                                Swal.fire({
                                    title: jsonResponse.userMsg,
                                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                                    position: 'top-end',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                if(jsonResponse.userMsg == 'Session Expired')
                                    window.location.reload();
                            break

                            spinner.stop();
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

                        window.location.reload();

                    });

                    spinner.stop();
                });
            });

            let clipboardtable = new ClipboardJS('.clipboardtable');
        }
    });
</script>
