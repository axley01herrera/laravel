<!-- PAGE HEADER -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h3>Ticket #: <span class="text-primary">{{ $ticketDetail['ticketID'] }}</span></h3>
            <div class="page-title-right">
                <a id="btn-backToTicketList" href="#"><i class="uil uil-arrow-left"></i> back</a>
            </div>
        </div>
    </div>
</div>
<!-- PAGE CONTENT -->
<div class="row">
    <div class="col-12 col-md-4 col-lg-4">
        @include('app.ticket.layouts.cardTicketInfo')
    </div>
    <div class="col-12 col-md-8 col-lg-8" >
        @include('app.ticket.layouts.cardIssue')
        @if (!empty($ticketDetail['descriptionResolutionFinal']))
            @include('app.ticket.layouts.cardResolution')
        @endif
    </div>
    <!-- PORTAL TIME LOGS -->
    @if ($countTimeLogs > 0)
        @include('app.ticket.layouts.portalTimeLogs')
    @endif
    <!-- DOCUMENTS -->
    @if (!empty($ticketDocuments))
        @include('app.ticket.layouts.documents')
    @endif
</div>
<div class="row">
    <div class="col-12 text-end">
        <!-- BTN ADD NOTE -->
        <button type="button" id="btn-resolved" class="btn btn-primary">
            <span id="spinner-btn-resolved" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
            Mark as Resolved
        </button>
    </div>
</div>
<script src="assets/customFunction/mask.js"></script>
<script>
    $(document).ready(function () {

        $('#btn-resolved').on('click', function () {

            $('#btn-resolved').attr('disabled', true);
            $('#spinner-btn-resolved').removeAttr('hidden');

            let post = {
                ticketRecordID: "{{ $ticketDetail['recordID'] }}"
            }

            alert("Esta accion esta en proceso");

        });

        $('#btn-backToTicketList').on('click', function (event) { // BACK BTN

            event.preventDefault()
            $('#link-ticket').trigger('click');
        });
    });
</script>
