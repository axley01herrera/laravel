<!-- PAGE HEADER -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h3>Log ID: <span class="text-primary">{{$logDetail['id']}}</span></h3>
            <div class="page-title-right">
                <a id="btn-backToLogList" href="#"><i class="uil uil-arrow-left"></i> back</a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <!-- PAGE CONTENT -->
        <div class="row row-cols-auto justify-content-md-center">
            <!-- LEFT -->
            <div class="col">
                <div class="card">
                    <div class="card-body overflow-auto">
                        <h5>Detail</h5>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                                        <i class="uil-chat-bubble-user"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-1 font-size-13">Created By</p>
                                        <h5 class="mb-0 font-size-14">{{$logDetail['createdBy']}}</h5>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mt-3">
                                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                                        <i class="uil-calendar-alt"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-1 font-size-13">Date</p>
                                        <h5 class="mb-0 font-size-14">{{$logDetail['createdDate']}}</h5>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mt-3">
                                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                                        <i class="uil uil-edit-alt"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-1 font-size-13">Modified RecordID</p>
                                        <h5 class="mb-0 font-size-14">{{$logDetail['modifiedRecordID']}}</h5>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mt-3">
                                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                                        <i class="uil-database"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-1 font-size-13">Table</p>
                                        <h5 class="mb-0 font-size-14">{{$logDetail['table']}}</h5>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mt-3">
                                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                                        <i class="uil-cloud-database-tree "></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-1 font-size-13">SQL Command</p>
                                        <h5 class="mb-0 font-size-14"><span class="badge @if ($logDetail['sqlCommand'] == 'insert'){{'badge-soft-success'}}@endif @if ($logDetail['sqlCommand'] == 'update'){{'badge-soft-warning'}}@endif">{{$logDetail['sqlCommand']}}</span></h5>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mt-3">
                                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                                        <i class="uil-cloud-database-tree "></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-1 font-size-13">SQL PK</p>
                                        <h5 class="mb-0 font-size-14">{{$logDetail['sqlPK']}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- CARD DESCRIPTION -->
                @if (!empty($logDetail['description']))
                    <div class="card">
                        <div class="card-body overflow-auto">
                            <h5>Description</h5>
                            <div class="row">
                                <div class="col-12">
                                    <pre>{{$logDetail['description']}}</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            <!-- CARD COMPARISON -->
                @if (!empty($logDetail['flagComparison']))
                    <div class="card">
                        <div class="card-body overflow-auto">
                            <h5>Differences</h5>
                            <div class="row">
                                <div class="col-12">
                                    @if ($logDetail['flagComparison'] == 1)
                                        <pre>{{$logDetail['logComparison']}}</pre>
                                    @endif
                                    @if ($logDetail['flagComparison'] == 2)
                                        <pre>This update has no difference<br>with the previous data</pre>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <!-- RIGHT -->
            <div class="col">
                <div class="card">
                    <div class="card-body overflow-auto">
                        <h5>Request</h5>
                        <div class="row">
                            <div class="col-12 ">
                                <div class="drop_container_scroll">
                                    <pre>{{$logDetail['request']}}</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (!empty($logDetail['flagResponse']))
                    <div class="card">
                        <div class="card-body overflow-auto">
                            <h5>Response</h5>
                            <div class="row">
                                <div class="col-12 ">
                                    <div class="drop_container_scroll">
                                        <pre>{{$logDetail['response']}}</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (!empty($logDetail['flagOldData']))
                    <div class="card">
                        <div class="card-body overflow-auto">
                            <h5>Old data</h5>
                            <div class="row">
                                <div class="col-12">
                                    <div class="drop_container_scroll">
                                        <pre>{{$logDetail['oldData']}}</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            @endif
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        $('#btn-backToLogList').on('click', function (event) { // BACK BTN

            event.preventDefault();
            $('#link-logs').trigger('click');
        });

    });
</script>
