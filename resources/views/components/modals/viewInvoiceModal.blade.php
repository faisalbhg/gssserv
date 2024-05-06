<style>
    .modal-dialog {
        max-width: 98%;
    }
    .modal{
        z-index: 99999;
    }
</style>
<!-- Modal -->
<div wire:ignore.self class="modal fade" id="viewInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="viewInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
        
            <div class="modal-header">
                <h5 class="modal-title" id="viewInvoiceModalLabel">#{{$job_number}} Update</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
                            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                            <span class="alert-text"><strong>Success!</strong> {{ $message }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        @endif
                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                            <span class="alert-text"><strong>Error!</strong> {{ $message }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        @endif
                        <div class="card mb-4">
                            <div class="card-header p-3 pb-0">
                                <div class="d-flex justify-content-between">
                                    

                                    <div>
                                        <h6>Order Details</h6>
                                        <p class="text-sm mb-0">Job no. <b>{{$job_number}}</b></p>
                                        <b><small>{{ \Carbon\Carbon::parse($jobInvoiceDetails->job_date_time)->format('dS M Y H:i A') }}</small></p>
                                    </div>
                                    <a target="_blank" href="{{url('invoice/'.$job_number)}}" class="btn btn-sm bg-gradient-secondary ms-auto">Print</a>
                                    <a href="{{ url('download-invoice/'.$job_number) }}" target="_blank" class="btn btn-sm bg-gradient-danger ms-auto">Download</a>
                                </div>
                            </div>
                            <div class="card-body p-3 pt-0">
                                <hr class="horizontal dark mt-0 mb-4">
                                <div class="row">
                                    @foreach($jobInvoiceDetails->customerJobServices as $customerJobServices)
                                    @if($customerJobServices->service_item)
                                    <div class="col-8">
                                        <div class="d-flex">
                                            <div>
                                                <h6 class="text-lg mb-0 mt-2">{{$customerJobServices->item_name}}</h6>
                                                <p class="text-sm mb-3">{{$customerJobServices->category_name}}</p>
                                                <span class="badge badge-sm {{config('global.jobs.status_btn_class')[$customerJobServices->job_status]}}">{{config('global.jobs.status')[$customerJobServices->job_status]}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-8">
                                        <div class="d-flex">
                                            <div>
                                                <h6 class="text-lg mb-0 mt-2">{{$customerJobServices->service_type_name}}</h6>
                                                <p class="text-sm mb-3">{{$customerJobServices->service_group_name}}</p>
                                                <span class="badge badge-sm {{config('global.jobs.status_btn_class')[$customerJobServices->job_status]}}">{{config('global.jobs.status')[$customerJobServices->job_status]}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-4 my-auto text-end">
                                        <p class="mb-0"><strong>AED {{round($customerJobServices->total_price,2)}}</strong></p>
                                        <p class="text-xxs mt-0 mb-0">Qty: <a href="javascript:;">{{$customerJobServices->quantity}}</a></p>
                                        <p class="text-xs mt-0 mb-0">Vat: <a href="javascript:;">{{round($customerJobServices->vat,2)}}</a></p>
                                    </div>
                                    <hr class="mt-1">
                                    @endforeach
                                </div>
                                <hr class="horizontal dark mt-4 mb-4">
                                <div class="row">
                                    
                                    <div class="col-6">
                                        <h6 class="mb-3">Customer details</h6>
                                        <ul class="list-group">
                                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-1 text-sm">{{$jobInvoiceDetails->customerInfo['name']}}</h6>
                                                    <span class="mb-2 text-xs"><span class="text-dark font-weight-bold ms-2">{{$jobInvoiceDetails->customerInfo['email']}}</span></span>
                                                    <span class="mb-2 text-xs"><span class="text-dark ms-2 font-weight-bold">{{$jobInvoiceDetails->customerInfo['mobile']}}</span></span>
                                                    <span class="text-xs">Customer Type: <span class="text-dark ms-2 font-weight-bold">{{$jobInvoiceDetails->customerInfo['customertype']->description}}</span></span>
                                                </div>
                                            </li>
                                        </ul>
                                        <h6 class="mb-3 mt-4">Vehicle Information</h6>
                                        <ul class="list-group">
                                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-3 text-sm">{{$jobInvoiceDetails->customerVehicle['make'].'/'.$jobInvoiceDetails->customerVehicle['model']}}</h6>
                                                    <span class="mb-2 text-xs text-dark font-weight-bold ms-2">{{$jobInvoiceDetails->customerVehicle['plate_state'].'/'.$jobInvoiceDetails->customerVehicle['plate_code'].'/'.$jobInvoiceDetails->customerVehicle['plate_number']}}</span>
                                                    <span class="mb-2 text-xs">Chaisis Number: <span class="text-dark ms-2 font-weight-bold">{{$jobInvoiceDetails->customerVehicle['chassis_number']}}</span></span>
                                                    <span class="mb-2 text-xs">Vehicle KM: <span class="text-dark ms-2 font-weight-bold">{{$jobInvoiceDetails->customerVehicle['vehicle_km']}}</span></span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-6 ms-auto">
                                        <h6 class="mb-3">Order Summary</h6>
                                        <div class="d-flex justify-content-between">
                                            <span class="mb-2 text-sm">Product Price:</span>
                                            <span class="text-dark font-weight-bold ms-2">{{round($jobInvoiceDetails->total_price,2)}}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="mb-2 text-sm">Discount:</span>
                                            <span class="text-dark ms-2 font-weight-bold">0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-sm">Vat:</span>
                                            <span class="text-dark ms-2 font-weight-bold">AED {{round($jobInvoiceDetails->vat,2)}}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mt-4">
                                            <span class="mb-2 text-lg">Total:</span>
                                            <span class="text-dark text-lg ms-2 font-weight-bold">AED {{round($jobInvoiceDetails->total_price+$jobInvoiceDetails->vat,2)}}</span>
                                        </div>

                                        <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                            <i class="{{config('global.payment.icons')[$jobInvoiceDetails->payment_type]}}"></i>
                                            <h6 class="mb-0">{{config('global.payment.type')[$jobInvoiceDetails->payment_type]}}</h6>
                                        </div>
                                        @if($jobInvoiceDetails->payment_status==1)
                                        <img class="float-end" src="{{ asset('img/paid-invoice-sticker.png')}}">
                                        @else
                                        <div class=" justify-content-between mt-4">
                                            <ul class="list-group">
                                                <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-lg">
                                                    <div class="d-flex align-items-center">
                                                        
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-1 text-dark text-sm">Payment Mode Change: </h6>
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                </li>
                                                <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-lg">
                                                    <div class=" float-end">
                                                        @foreach(config('global.payment.type') as $pTypekey => $paymentTypeUp)
                                                        @if($pTypekey!=0)
                                                        <button wire:click="updatePaymentMethode('{{$job_number}}','{{$pTypekey}}')" class="btn {{config('global.payment.type_class')[$pTypekey]}} btn-sm">{{$paymentTypeUp}}</button>
                                                        @endif
                                                        @endforeach
                                                    </div>
                                                    <div wire:loading wire:target="updatePaymentMethode">
                                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                            <div class="la-ball-beat">
                                                                <div></div>
                                                                <div></div>
                                                                <div></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class=" justify-content-between mt-4">
                                            <ul class="list-group">
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

                                                        <div wire:loading wire:target="updatePayment">
                                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                                <div class="la-ball-beat">
                                                                    <div></div>
                                                                    <div></div>
                                                                    <div></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class=" float-end">
                                                        @if($payment_type==1 && $payment_status==0)
                                                        <button type="button" wire:click="resendPaymentLink('{{$job_number}}')" class="mt-2 btn btn-sm bg-gradient-success">Re send Payment link</button>
                                                        <div wire:loading wire:target="resendPaymentLink">
                                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                                <div class="la-ball-beat">
                                                                    <div></div>
                                                                    <div></div>
                                                                    <div></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" wire:click="checkPaymentStatus('{{$job_number}}','1')" class="mt-2 btn btn-sm bg-gradient-info">Check Payment Status</button>
                                                        <div wire:loading wire:target="checkPaymentStatus">
                                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                                <div class="la-ball-beat">
                                                                    <div></div>
                                                                    <div></div>
                                                                    <div></div>
                                                                </div>
                                                            </div>
                                                        </div>
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
                                        </div>
                                        @endif
                                    </div>
                                </div>
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
