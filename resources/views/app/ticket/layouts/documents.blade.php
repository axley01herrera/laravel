<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h5>Screenshot</h5>
            <div class="row">
                <div class="col-12">
                    <div class="row gallery-wrapper">
                        @for ($i = 0; $i < $totalDocuments; $i++)
                        <div class="element-item col-xl-4 col-sm-6 project designing development"  data-category="designing development">
                            <div class="gallery-box card">
                                <div class="gallery-container">
                                    <a class="image-popup" href="{{$ticketDocuments[$i]['document']}}">
                                        <img class="gallery-img img-fluid mx-auto" src="{{$ticketDocuments[$i]['document']}}" alt="Screenshot" />
                                        <div class="gallery-overlay"></div>
                                    </a>
                                </div>
                                <div class="box-content p-3">
                                    <h5 class="title">Screenshot {{$i}}</h5>
                                    <p class="post">by <a href="" class="text-body">{{$ticketDetail['peopleNameFullTitle']}}</a></p>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
