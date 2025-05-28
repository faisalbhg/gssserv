<main class="main-content">
  <div class="container-fluid py-4">

    <div class="row">
      <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2">
        <label>Package Number</label>
        <div class="form-group">
          <input style="padding:0.5rem 0.3rem !important;"  type="text"  class="form-control" placeholder="Search Package Number" wire:model="search_package_number" />
        </div>
      </div>
      <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2">
        <label>Package Date</label>
        <div class="form-group">
          <input type="date"  class="form-control" placeholder="Search Package Date" wire:model="search_package_date" />
        </div>
      </div>
      <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2">
        <label>Plate Search</label>
        <div class="form-group">
          <input style="padding:0.5rem 0.3rem !important;" type="text" id="plateNumber" class="form-control @error('plate_number') btn-outline-danger @enderror" wire:model="search_plate_number" name="plate_number" placeholder="Number Plate">
        </div>
      </div>
      @if(auth()->user('user')->user_type==1)
      <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2">
        <label>Station</label>
        <div class="form-group">
          <select class="form-control" id="stationSelect" wire:model="search_station">
            <option value="">-Select-</option>
            @foreach($stationsList as $station)
            <option value="{{$station->LandlordCode}}">{{$station->CorporateName}}</option>
            @endforeach
          </select>
          <div wire:loading wire:target="search_station">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2">
        <label for="selectPaymentType">Payment</label>
        <div class="form-group">
          <select class="form-control" id="selectPaymentType" wire:model="search_payment">
            <option value="">-Select-</option>
            @foreach(config('global.payment.type') as $ptKey => $paymentType)
            <option value="{{$ptKey}}">{{$paymentType}}</option>
            @endforeach
          </select>
          <div wire:loading wire:target="search_payment">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2">
        <label for="selectPaymentStatus">Payment Status</label>
        <div class="form-group">
          <select class="form-control" id="selectPaymentStatus" wire:model="search_paymentStatus">
            <option value="">-Select-</option>
            @foreach(config('global.payment.status') as $pSKey => $paymentStatus)
            <option value="{{$pSKey}}">{{$paymentStatus}}</option>
            @endforeach
          </select>
          <div wire:loading wire:target="search_jobType">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        </div>
      </div>
      @endif
    </div>
  

    <div class="row">
      <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2 jobscount total">
        <div class="card bg-gradient-primary shadow text-white">
            <div class="card-body p-3 cursor-pointer" >
                <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Packages</p>
                    <hr class="m-0">
                    <h5 class="font-weight-bolder mb-0  text-white">{{$getCountSalesPackages->total}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                </div>
            </div>
        </div>
      </div>
      <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2 jobscount work_finished">
          <div class="card bg-gradient-danger shadow text-white">
              <div class="card-body p-3 cursor-pointer" >
                  <div class="row">
                      <div class="col-12">
                          <div class="numbers">
                              <p class="text-sm mb-0 text-capitalize font-weight-bold">Not Active</p>
                              <hr class="m-0">
                              <h5 class="font-weight-bolder mb-0 text-white">{{$getCountSalesPackages->pending}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      
      <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2 jobscount delivered">
          <div class="card bg-gradient-success shadow text-white">
              <div class="card-body p-3 cursor-pointer" >
                  <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Active</p>
                      <hr class="m-0">
                      <h5 class="font-weight-bolder mb-0 text-white">{{$getCountSalesPackages->paid}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                  </div>
              </div>
          </div>
      </div>
    </div>
    
    <div class="row mt-2">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center justify-content-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Customer</th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Package</th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Pricec</th>
                    <th></th>
                  </tr>
                </thead>

                <tbody>
                  @forelse( $customerPackages as $package)
                  <tr class="cursor-pointer" wire:click="customerPackageDetails('{{$package->package_number}}')">
                    <td>
                      <div class="d-flex px-3 py-1">
                        <div>
                          <img src="{{url('public/storage/'.$package->vehicle_image)}}" class="avatar me-3" alt="avatar image">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">{{$package->makeInfo['vehicle_name']}} - <small>{{$package->modelInfo['vehicle_model_name']}} </small></h6>
                          <p class="text-sm font-weight-bold text-secondary mb-0"><span class="text-success">{{$package->plate_number}}</span></p>
                          <hr class="m-0">
                          <p class="text-sm text-dark mb-0">{{$package->customer_name}}
                            @if($package->customer_email!='')
                            <br>{{$package->customer_email}}
                            @endif
                            @if(isset($package->customer_mobile))
                            <br>{{$package->customer_mobile}}
                            @endif
                          </p>
                        </div>
                      </div>
                      <div class="">
                        
                            <span class="w-100 badge badge-sm {!!config('global.package.status_btn_class')[$package->payment_status]!!}">{{config('global.package.status')[$package->payment_status]}}</span>
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="me-2 text-xs font-weight-bold">{{config('global.package.status_perc')[$package->payment_status]}}</span>
                                <div>
                                    <div class="progress">
                                        <div class="progress-bar {{config('global.package.status_perc_class')[$package->payment_status]}}" role="progressbar" aria-valuenow="{{config('global.package.status_perc')[$package->payment_status]}}" aria-valuemin="0" aria-valuemax="100" style="width: {{config('global.status_perc')[$package->payment_status]}};"></div>
                                    </div>
                                </div>
                            </div>
                      </div>
                    </td>
                    <td>
                        <div class="d-flex px-3 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">{{$package->package_number}}</h6>
                                <p class="text-sm font-weight-bold mb-0">{{ \Carbon\Carbon::parse($package->package_date_time)->format('dS M Y h:i A') }}</p>
                                @if(auth()->user('user')->user_type==1)
                                    <small>Created By: {{$package->createdInfo['name']}}</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    
                    <td>
                        <div class="d-flex px-3 py-1">
                        <div class="d-flex flex-column justify-content-center">
                          <p class="text-sm font-weight-bold text-secondary mb-0"><span class="text-success">AED {{round($package->grand_total,2)}}</span></p>
                          <hr class="my-1">
                          <span class="badge badge-sm {{config('global.payment.status_class')[$package->payment_status]}}">{{config('global.payment.status')[$package->payment_status]}}</span>
                          @if($package->payment_type!=null)
                          <p class="text-sm text-gradient {{config('global.payment.text_class')[$package->payment_type]}}  font-weight-bold mb-0">{{config('global.payment.type')[$package->payment_type]}}</p>
                          @else
                          <p class="text-sm text-gradient text-dark font-weight-bold mb-0">Pay Later </p>
                          @endif

                        </div>
                      </div>
                      <p class="text-sm font-weight-bold mb-0"></p>
                    </td>
                    
                    
                    
                    <td class="align-middle">

                      <button type="button" wire:click="customerPackageDetails('{{$package}}')" class="btn btn-link text-secondary mb-0">
                        <i class="fa fa-edit fa-xl text-md"></i>
                      </button>
                      <!-- data-bs-toggle="modal" data-bs-target="#serviceUpdateModal" -->
                    </td>
                  </tr>
                  @empty
                    <tr>
                      <td colspan="8">No Record Found</td>
                    </tr>
                  @endforelse
                
              </tbody>
            </table>
            <div class="float-end">{{$customerPackages->onEachSide(0)->links()}}</div>
          </div>
        </div>
      </div>
    </div>
    <div wire:loading wire:target="customerJobUpdate">
      <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
          <div class="la-ball-beat">
              <div></div>
              <div></div>
              <div></div>
          </div>
      </div>
  </div>
  </div>
  
    </div>
</main>
@push('custom_script')
  
@endpush

