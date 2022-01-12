<div class="modal fade" id="modalPayment" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        @foreach($payments as $i => $p)
                        <button class="nav-link active" id="nav-{{$p->id}}-tab" data-bs-toggle="tab" data-bs-target="#nav{{$p->id}}" type="button" role="tab">{{ $p->name }}</button>
                        @endforeach
                    </div>
                </nav>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="tab-content" id="nav-tabContent">
                        @foreach($payments as $i => $p)
                        <div class="tab-pane fade show active" id="nav-{{$p->id}}" role="tabpanel">
                            <img src="/assets/img/payment_method/{{ $p->logo }}" class="img-fluid" alt=""><hr>
                            {!! $p->description !!}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>