
<!-- Modal -->
<div wire:ignore.self class="modal fade" id="paymentUpdateModal" tabindex="-1" role="dialog" aria-labelledby="paymentUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
        
            <div class="modal-header">
                <h5 class="modal-title" id="paymentUpdateModalLabel">#{{$job_number}} Update</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mt-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-profile card-plain py-2">
                                    <div class="row">
                                        <div class="col-xxs-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                            <a href="javascript:;">
                                                <div class="position-relative">
                                                <div class="blur-shadow-image">
                                                    <img class="w-100 rounded-3 shadow-lg" src="{{url('storage/'.$vehicle_image)}}">
                                                </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-xxs-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                            <div class="card-body text-left">
                                                <div class="p-md-0 pt-3">
                                                    <h5 class="font-weight-bolder mb-0">{{$make}}</h5>
                                                    <p class="text-uppercase text-sm font-weight-bold mb-2">{{$model}} ({{$plate_number}})</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-0">
                        <div class="card h-100 mb-4">
                            <div class="card-header pb-0 px-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-0 text-lg">#{{$job_number}}</h6>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end align-items-center">
                                        <i class="far fa-calendar-alt me-2" aria-hidden="true"></i>
                                        <small>{{ \Carbon\Carbon::parse($job_date_time)->format('d M Y H:i A') }}</small>
                                    </div>
                                </div>
                                <hr class="m-0">
                            </div>
                            <div class="card-body py-4">
                                <h6 class="text-uppercase text-body text-lg font-weight-bolder">Customer Details</h6>
                                <ul class="list-group pb-2">
                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-0 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Name: </h6>
                                                <span class="text-xs"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">
                                            {{$name}}
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-0 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Mobile: </h6>
                                                <span class="text-xs"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">
                                            {{$mobile}}
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-0 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-md">Email: </h6>
                                                <span class="text-xs"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center text-dark text-gradient text-md font-weight-bold">
                                            {{$email}}
                                        </div>
                                    </li>
                                </ul>

                                <h6 class="text-uppercase text-body text-lg font-weight-bolder">Vehicle Details</h6>
                                <ul class="list-group pb-2">
                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-0 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Vehicle Name: </h6>
                                                <span class="text-xs"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">
                                            {{$make}}
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-0 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Model: </h6>
                                                <span class="text-xs"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">
                                           {{$model}}
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-0 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Plate Number: </h6>
                                                <span class="text-xs"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">
                                            {{$plate_number}}
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-0 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-md">Chassis Number: </h6>
                                                <span class="text-xs"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center text-dark text-gradient text-md font-weight-bold">
                                            {{$chassis_number}}
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-0 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-md">K.M Reading: </h6>
                                                <span class="text-xs"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center text-dark text-gradient text-md font-weight-bold">
                                            {{$vehicle_km}}
                                        </div>
                                    </li>
                                </ul>
                                <h6 class="text-uppercase text-body text-lg font-weight-bolder mt-2">Pricing Summary</h6>
                                <ul class="list-group">
                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-0 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Total: </h6>
                                                <span class="text-xs"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">
                                            {{config('global.CURRENCY')}} {{custom_round($total_price)}}
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-0 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Vat: </h6>
                                                <span class="text-xs"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">
                                            {{config('global.CURRENCY')}} {{custom_round($vat)}}
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-0 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-md">Grand Total: </h6>
                                                <span class="text-xs"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center text-dark text-gradient text-md font-weight-bold">
                                            {{config('global.CURRENCY')}} {{custom_round(($total_price+$vat))}}
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-icon-only btn-rounded {{config('global.payment.status_icon_class')[$payment_status]}} mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="{{config('global.payment.status_icon')[$payment_status]}}" aria-hidden="true"></i></button>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Payment Status: </h6>
                                                <span class="text-sm {{config('global.payment.text_class')[$payment_type]}} pb-2">{{config('global.payment.type')[$payment_type]}}</span>
                                                
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center {{config('global.payment.status_class')[$payment_status]}} text-gradient text-sm font-weight-bold">
                                            {{config('global.payment.status')[$payment_status]}}
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-lg">
                                        @if($payment_status==0 && $payment_type!=1)
                                        <div class=" float-end">
                                            @foreach(config('global.payment.status') as $pskey => $paymentStatus)
                                            <button wire:click="updatePayment('{{$job_number}}','{{$pskey}}')" class="btn {{config('global.payment.status_class')[$pskey]}} btn-sm">{{config('global.payment.status')[$pskey]}}</button>
                                            @endforeach
                                        </div>
                                        @else
                                        <div class=" float-end">
                                            @if($payment_type==1 && $payment_status==0)
                                            <button type="button" wire:click="resendPaymentLink('{{$job_number}}')" class="mt-2 btn btn-sm bg-gradient-success">Re send Payment link</button>
                                            <button type="button" wire:click="checkPaymentStatus('{{$job_number}}','1')" class="mt-2 btn btn-sm bg-gradient-info">Check Payment Status</button>
                                            @endif
                                            @if ($message = Session::get('paymentLinkStatusSuccess'))
                                                <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
                                                    <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                                    <span class="alert-text"><strong>Success!</strong> {{ $message }}</span>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @endif
                                            @if ($message = Session::get('paymentLinkStatusError'))
                                                <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                                                    <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                                    <span class="alert-text"><strong>Success!</strong> {{ $message }}</span>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                        @endif
                                    </li>
                                </ul>
                                <h6 class="text-uppercase text-body text-lg font-weight-bolder mt-3">Job Status</h6>
                                <ul class="list-group">
                                    @if($job_status!='')
                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-0 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Job Status: </h6>
                                                <span class="text-xs"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center {{config('global.jobs.status_text_class')[$job_status]}} text-gradient text-sm font-weight-bold">
                                            
                                            {{config('global.jobs.status')[$job_status]}}
                                        </div>
                                    </li>
                                    @endif

                                    <!-- @if($job_departent!='')
                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-0 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Department/Section: </h6>
                                                <span class="text-xs"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center {{config('global.job_department_text_class')[$job_departent]}} text-gradient text-sm font-weight-bold">
                                           {{config('global.job_department')[$job_departent]}}
                                        </div>
                                    </li>
                                    @endif -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <!-- <button type="submit" class="btn bg-gradient-primary">Submit</button> -->
            </div>
       </div>
    </div>
</div>
