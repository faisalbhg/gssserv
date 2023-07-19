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
                    <div class="col-lg-8 mx-auto">
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
                                    <div class="col-8">
                                        <div class="d-flex">
                                            <div>
                                                <h6 class="text-lg mb-0 mt-2">{{$customerJobServices->service_type_name}}</h6>
                                                <p class="text-sm mb-3">{{$customerJobServices->service_group_name}}</p>
                                                <span class="badge badge-sm {{config('global.jobs.status_btn_class')[$customerJobServices->job_status]}}">{{config('global.jobs.status')[$customerJobServices->job_status]}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 my-auto text-end">
                                        <p class="mb-0"><strong>AED {{round($customerJobServices->total_price,2)}}</strong></p>
                                        <p class="text-xxs mt-0 mb-0">Qty: <a href="javascript:;">{{$customerJobServices->quantity}}</a></p>
                                        <p class="text-xs mt-0 mb-0">Vat: <a href="javascript:;">{{round($customerJobServices->vat,2)}}</a></p>
                                    </div>
                                    @endforeach
                                </div>
                                <hr class="horizontal dark mt-4 mb-4">
                                <div class="row">
                                    
                                    <div class="col-5">
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
                                    <div class="col-3 ms-auto">
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
                                            <span class="text-dark text-lg ms-2 font-weight-bold">AED {{round($jobInvoiceDetails->total_price,2)}}</span>
                                        </div>

                                        <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                                            <i class="{{config('global.payment.icons')[$jobInvoiceDetails->payment_type]}}"></i>
                                            <h6 class="mb-0">{{config('global.payment.type')[$jobInvoiceDetails->payment_type]}}</h6>
                                        </div>
                                        @if($jobInvoiceDetails->payment_status==1)
                                        <img src="{{ asset('img/paid-invoice-sticker.png')}}">
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
