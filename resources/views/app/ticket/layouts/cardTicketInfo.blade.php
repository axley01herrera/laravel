<div class="card">
    <div class="card-body">
        <h5>{{ $ticketDetail['title'] }}</h5>
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-user"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Name</p>
                        <h5 class="mb-0 font-size-14">{{$ticketDetail['peopleNameFullTitle']}}</h5>
                    </div>
                </div>
                @if (!empty($ticketDetail['peoplePhone']))
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-phone-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Phone</p>
                        <h5 class="mb-0 font-size-14 phone">{{$ticketDetail['peoplePhone']}}</h5>
                    </div>
                </div>
                @endif
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-envelope-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">E-mail</p>
                        <h5 class="mb-0 font-size-14">{{$ticketDetail['peopleEmail']}}</h5>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-calendar-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Creation Date</p>
                        <h5 class="mb-0 font-size-14">{{ $ticketDetail['creationDate'] }} </h5>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-clock"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Creation Date</p>
                        <h5 class="mb-0 font-size-14">{{ $ticketDetail['creationTime'] }}</h5>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-comment-alt-notes"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Severity</p>
                        <h5 class="mb-0 font-size-14">{{$ticketDetail['ticketSeverityName']}}</h5>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-comment-alt-notes"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Priority</p>
                        <h5 class="mb-0 font-size-14">{{$ticketDetail['ticketPriorityName']}}</h5>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-comment-alt-notes"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Type</p>
                        <h5 class="mb-0 font-size-14">{{$ticketDetail['ticketTypeName']}}</h5>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-3">
                    <div class="font-size-20 text-primary flex-shrink-0 me-3">
                        <i class="uil uil-comment-info-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1 font-size-13">Status</p>
                        <h5 class="mb-0 font-size-14">
                            @if ($ticketDetail['ticketStatusN'] == 1)
                            <span class="badge badge-soft-success">{{$ticketDetail['ticketStatusName']}}</span>
                            @endif
                            @if ($ticketDetail['ticketStatusN'] == 2)
                                <span class="badge badge-soft-primary">{{$ticketDetail['ticketStatusName']}}</span>
                            @endif
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
