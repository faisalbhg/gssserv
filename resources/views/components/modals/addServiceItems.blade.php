<style>
    .modal-dialog {
        max-width: 90% !important;
    }
    .modal{
        z-index: 99999;
    }
</style>

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="addServiceItemsModal" tabindex="-1" role="dialog" aria-labelledby="addServiceItemsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="addServiceItemsModalLabel">#{{$job_number}} Update</h5>
                <div class="float-end">
                    <b>Job Status: <span class="text-sm {{config('global.jobs.status_text_class')[$job_status]}} pb-2">{{config('global.jobs.status')[$job_status]}}</span> </b>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mt-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-profile card-plain py-2">
                                    <div class="row">
                                        <div class="col-xxs-8 col-xs-8 col-sm-9 col-md-9 col-lg-9 col-xl-9 col-xxl-9">
                                            <a href="javascript:;">
                                                <div class="position-relative">
                                                <div class="blur-shadow-image">
                                                    <img class="w-70 rounded-3 shadow-lg" src="{{url('public/storage/'.$vehicle_image)}}">
                                                </div>
                                                </div>
                                            </a>
                                            <div class="card-body text-left">
                                                <div class="p-md-0 pt-3">
                                                    <h5 class="font-weight-bolder mb-0">{{$make}}</h5>
                                                    <p class="text-uppercase text-sm font-weight-bold mb-2">{{$model}} ({{$plate_number}})</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="list-group pb-4">
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            
                        </div>
                    </div>
                    <div class="col-md-6 mt-0">
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
                                

                                <ul class="list-group pb-4">
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

                                <ul class="list-group pb-4">
                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-0 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Total: </h6>
                                                <span class="text-xs"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">
                                            {{config('global.CURRENCY')}} {{round($total_price,2)}}
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
                                            {{config('global.CURRENCY')}} {{round($vat,2)}}
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
                                            {{config('global.CURRENCY')}} {{round(($total_price+$vat),2)}}
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
                                        <div class=" float-end d-none">
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
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card ">
                            <div class="card-body pt-4 p-3">
                                @if($cardShow)
                                    <div class="row mt-3">
                                        @if($cartItems)
                                        <div class="col-md-12 mb-4" id="cartDetails">
                                            <div class="card p-2 mb-4">
                                                <div class="card-header px-2 py-0">
                                                    
                                                    <h3 class="px-2 text-lg text-bold">{{ Cart::getTotalQuantity()}} Services selected </h3>
                                                </div>
                                                <div class="card-body p-2 mb-4">
                                                    <div class="table-responsive">
                                                        <table class="table align-items-center mb-0">
                                                          <thead>
                                                            <tr>
                                                                <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7">Service</th>
                                                                <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7 ps-2 ">
                                                                    <span class="">Quantity</span>
                                                                </th>
                                                                <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7 ps-2">price</th>
                                                                <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7 ps-2">Remove</th>
                                                                <th></th>
                                                            </tr>
                                                          </thead>
                                                          <tbody>
                                                            @foreach ($cartItems as $item)
                                                                <tr>
                                                                    <td>
                                                                        <h6 class="mb-0 text-xs">{{ $item['name'] }}</h6>
                                                                    </td>
                                                                    <td class="justify-center mt-6 md:justify-end md:flex">
                                                                        <div class="h-10 w-28">
                                                                            <div class="relative flex flex-row w-full h-8">
                                                                                <div>
                                                                                    {{ $item['quantity']}}
                                                                                    <!-- <input wire:model="quantity"
                                                                                   type="number" min="1" max="5"
                                                                                   wire:change="updateCart" class="text-center bg-gray-100" value="{{ $item['quantity']}}"> -->
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="hidden text-right md:table-cell">
                                                                        <p class="text-xs font-weight-bold mb-0">AED {{ $item['price'] }}</p>
                                                                    </td>
                                                                    <td class="hidden text-right md:table-cell">
                                                                        <a href="#" class="px-4 py-2 text-danger bg-red-600" wire:click.prevent="removeCart('{{$item['id']}}')"><i class="fa fa-trash"></i></a>    
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                          </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="card-footer p-2 mb-4">
                                                    <div class="row d-flex flex-row justify-content-between">
                                                        <div class="col-md-12">
                                                            <p class="text-end  text-bold text-md mb-0">Total: AED {{ \Cart::getTotal() }}</p>
                                                            <p class="text-end  text-bold text-md">Tax: AED {{ $tax }}</p>
                                                            <p class="text-end  text-bold text-lg">Grand total: AED {{ $grand_total }}</p>
                                                        </div>
                                                        <hr>
                                                        <div class="col-md-6">
                                                            <button class="btn bg-gradient-danger btn-sm" wire:click.prevent="clearAllCart">Remove All Cart</button>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button type="button" class="btn bg-gradient-success btn-sm float-end" wire:click="submitService()">Confirm & Continue</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-md-12 mb-4" id="paymentDetails" style="display:none;">
                                            <div class="card p-2 mb-4">
                                                <div class="card-header text-center pt-4 pb-3">
                                                    
                                                    <h1 class="font-weight-bold mt-2">
                                                        Payment #{{$job_number}}
                                                    </h1>
                                                    <span class="badge rounded-pill bg-light text-dark text-lg"><small>AED</small> {{ $grand_total }}</span>
                                                </div>
                                                <div class="card-body text-lg-left text-center pt-0">

                                                    <div class="d-flex justify-content-center p-2">
                                                        <div class="form-check">
                                                            <a wire:click="completePaymnet('link','{{$job_number}}')" class="btn btn-icon bg-gradient-info d-lg-block mt-3 mb-0">Pay By Link<i class="fa-solid fa-comments-dollar ms-1" ></i></a>
                                                        </div>
                                                    
                                                        <div class="form-check">
                                                            <a wire:click="completePaymnet('card','{{$job_number}}')" class="btn btn-icon bg-gradient-warning d-lg-block mt-3 mb-0">Pay By Card<i class="fa-solid fa-credit-card ms-1" ></i></a>
                                                        </div>
                                                    
                                                        <div class="form-check">
                                                            <a wire:click="completePaymnet('cash','{{$job_number}}')" class="btn btn-icon bg-gradient-danger d-lg-block mt-3 mb-0">Cash Payment<i class="fa-solid fa-money-bill-1-wave ms-1" ></i></a>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-4" id="paymentRespnse" style="display:none;">
                                            <div class="card p-2 mb-4 bg-cover text-center" style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')">
                                                <div class="card-body z-index-2 py-9">
                                                    <h2 class="text-white">Successful..!</h2>
                                                    <p class="text-white">The service in under processing</p>
                                                    <button type="button" class=" text-white btn bg-gradient-default selectVehicle py-2 " >Job Number: {{$job_number}}</button>
                                                </div>
                                                <div class="mask bg-gradient-primary border-radius-lg"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($showServiceGroup)
                                    <div class="row mt-2 mb-2">
                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <p class="h5 text-left">Services Details</p><hr class="m-0" >
                                        </div>
                                        @foreach($servicesGroups as $servicesGroup)
                                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="card h-100 p-3">
                                                    <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/".$servicesGroup->service_group_code.".jpg")}}');">
                                                        @if($service_group_id == $servicesGroup->id)
                                                        <span class="mask bg-gradient-dark opacity-4"></span>
                                                        @else
                                                        <span class="mask bg-gradient-dark opacity-8"></span>
                                                        @endif
                                                        <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                                                            <!--  -->
                                                            <h5 class="text-white font-weight-bolder mb-4 pt-2">{{$servicesGroup->service_group_name}}</h5>
                                                            <!-- <p class="text-white">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p> -->
                                                            <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                                                                @if($service_group_id == $servicesGroup->id)
                                                                <button wire:click="serviceGroupForm('{{$servicesGroup}}')" class="btn bg-gradient-primary" type="button" >
                                                                    Select
                                                                </button>
                                                                @else
                                                                <button type="button" wire:click="serviceGroupForm('{{$servicesGroup}}')" class="btn btn-outline-light">Select</button>
                                                                @endif
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($showServicesitems || $showServiceType)
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                <h5>
                                                    <a wire:click="showServices();" href="javascript:;" class="services btn btn-sm bg-gradient-dark border-radius-md mt-0 mb-2">
                                                        <i class="fa-solid fa-car"></i> Services
                                                    </a>
                                                    <a href="javascript:;" class="serviceitems btn btn-sm bg-gradient-primary border-radius-md mt-0 mb-2" wire:click="showServiceItem();">
                                                    <i class="fa-solid fa-shopping-cart"></i>
                                                     Service items</a>
                                                    <input type="text"  class="form-control float-end" style="width:20%;" placeholder="Search Services" wire:model="service_search" />
                                                </h5>
                                                <hr>
                                            </div>
                                            
                                            
                                            @if($showServiceType)
                                                @foreach($servicesTypesList as $servicesType)
                                                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">
                                                        <div class="card shadow-none border h-100">
                                                          <div class="card-header text-sm-left text-center pt-4 pb-3 px-4">
                                                            <!-- <h5 class="mb-1">Pro</h5> -->
                                                            <p class="mb-3 text-sm">{{$servicesType->service_type_name}}</p>
                                                            <h3 class="font-weight-bolder mt-3">
                                                              AED {{round($servicesType->unit_price,2)}} 
                                                            </h3>
                                                            <a href="javascript:;" wire:click="addtoCart('{{$servicesType}}')" class="btn btn-sm bg-gradient-dark w-100 border-radius-md mt-4 mb-2">Buy now</a>
                                                          </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif

                                            @if($showServicesitems)
                                                @forelse($serviceItemsList as $items)
                                                <?php
                                                $servicesItem = $items->serviceItems;
                                                ?>
                                                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">
                                                        <div class="card">
                                                          <div class="card-header text-center pt-4 pb-3">
                                                            <span class="text-dark">{{$servicesItem['item_name']}}</span>
                                                            <h3 class="font-weight-bold mt-2">
                                                              <small>AED</small>{{round($items->sale_price,2)}}
                                                            </h3>
                                                          </div>
                                                          <div class="card-body text-lg-left text-center pt-0">
                                                            

                                                            <a href="javascript:;" class="btn btn-icon bg-gradient-primary d-lg-block mt-3 mb-0" wire:click="addtoCartItem('{{$items}}')">
                                                              Buy Now
                                                              <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                                            </a>
                                                          </div>
                                                        </div>
                                                      </div>
                                                @empty
                                                    
                                                @endforelse
                                            @endif
                                        </div>
                                    @endif
                                @endif
                                
                                
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
