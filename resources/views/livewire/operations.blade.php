<main class="main-content">
  <div class="container-fluid py-4">

    <div class="row">
      <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2">
        <label>Job Number</label>
        <div class="form-group">
          <input style="padding:0.5rem 0.3rem !important;"  type="text"  class="form-control" placeholder="Search Job Number" wire:model="search_job_number" />
        </div>
      </div>
      <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2">
        <label>Job Date from</label>
        <div class="form-group">
          <input type="date"  class="form-control" placeholder="Search Job Date" wire:model="search_job_date_from" />
        </div>
      </div>
      <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2">
        <label>Job Date To</label>
        <div class="form-group">
          <input type="date"  class="form-control" placeholder="Search Job Date" wire:model="search_job_date_to" />
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
          <select class="form-control" id="selectPaymentType" wire:model="search_payment_type" wire:change="changePaymentType">
            <option value="">-Select-</option>
            @foreach(config('global.payment.type') as $ptKey => $paymentType)
            <option value="{{$ptKey}}">{{$paymentType}}</option>
            @endforeach
          </select>
          <div wire:loading wire:target="search_payment_type">
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
          <select class="form-control" id="selectPaymentStatus" wire:model="search_paymentStatus" wire:change="changePaymentstatus">
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
      <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2">
        <label for="selectPaymentStatus">Job Status</label>
        <div class="form-group">
          <select class="form-control" id="selectPaymentStatus" wire:model="search_jobStatus">
            <option value="">-Select-</option>
            @foreach(config('global.jobs.status') as $jSKey => $jobStatus)
            <option value="{{$jSKey}}">{{$jobStatus}}</option>
            @endforeach
          </select>
          <div wire:loading wire:target="search_jobStatus">
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
        <label for="selectJobType">Job Type</label>
        <div class="form-group">
          <select class="form-control" id="selectJobType" wire:model="search_jobType">
            <option value="">-Select-</option>
            <option >Quick Wash</option>
            <option >General Service</option>
            <option >Quick Lube</option>
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
    
    @if(auth()->user('user')->user_type==1)
    <div class="row">
      <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2 ">
        <div class="card bg-gradient-dark shadow text-white">
            <div class="card-body p-3 cursor-pointer">
                <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Pay Later</p>
                    <hr class="m-0">
                    <h5 class="font-weight-bolder mb-0  text-white">{{$getSumSalesJob->pay_later}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                </div>
            </div>
        </div>
      </div>
      <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2">
          <div class="card bg-gradient-danger shadow text-white">
              <div class="card-body p-3 cursor-pointer" >
                  <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Payment Link</p>
                      <hr class="m-0">
                      <h5 class="font-weight-bolder mb-0 text-white">{{number_format($getSumSalesJob->payment_link,2)}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2">
          <div class="card bg-gradient-danger shadow text-white">
              <div class="card-body p-3 cursor-pointer">
                  <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Pay By Card</p>
                      <hr class="m-0">
                      <h5 class="font-weight-bolder mb-0 text-white">{{number_format($getSumSalesJob->pay_by_card,2)}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2">
          <div class="card bg-gradient-warning shadow text-white">
              <div class="card-body p-3 cursor-pointer">
                  <div class="row">
                      <div class="col-12">
                          <div class="numbers">
                              <p class="text-sm mb-0 text-capitalize font-weight-bold">Cash Payment</p>
                              <hr class="m-0">
                              <h5 class="font-weight-bolder mb-0 text-white">{{number_format($getSumSalesJob->cash_payment,2)}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2">
        <div class="card bg-gradient-dark shadow text-white">
            <div class="card-body p-3 cursor-pointer" >
                <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Pay By Credit</p>
                    <hr class="m-0">
                    <h5 class="font-weight-bolder mb-0  text-white">{{number_format($getSumSalesJob->pay_by_credit,2)}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                </div>
            </div>
        </div>
      </div>
      <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2">
          <div class="card bg-gradient-danger shadow text-white">
              <div class="card-body p-3 cursor-pointer" >
                  <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Cash in Advance</p>
                      <hr class="m-0">
                      <h5 class="font-weight-bolder mb-0 text-white">{{number_format($getCountSalesJob->cash_in_advance,2)}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                  </div>
              </div>
          </div>
      </div>
    </div>
    @endif



    <div class="row">
      <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2 jobscount total">
        <div class="card bg-gradient-default shadow text-dark">
            <div class="card-body p-3 cursor-pointer" wire:click="filterJobListPage('total')">
                <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total jobs</p>
                    <hr class="m-0">
                    <h5 class="font-weight-bolder mb-0  text-dark">{{$getCountSalesJob->total}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                </div>
            </div>
        </div>
      </div>
      <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2 jobscount inspection">
          <div class="card bg-gradient-dark shadow text-white">
              <div class="card-body p-3 cursor-pointer" wire:click="filterJobListPage('inspection')">
                  <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Inspection</p>
                      <hr class="m-0">
                      <h5 class="font-weight-bolder mb-0 text-white">{{$getCountSalesJob->inspection}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2 jobscount customer_aprpoved">
          <div class="card bg-gradient-dark shadow text-white">
              <div class="card-body p-3 cursor-pointer" wire:click="filterJobListPage('customer_aprpoved')">
                  <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Customer Approved</p>
                      <hr class="m-0">
                      <h5 class="font-weight-bolder mb-0 text-white">{{$getCountSalesJob->customer_aproved}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2 jobscount item_issued">
          <div class="card bg-gradient-dark shadow text-white">
              <div class="card-body p-3 cursor-pointer" wire:click="filterJobListPage('item_issued')">
                  <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Item Issued</p>
                      <hr class="m-0">
                      <h5 class="font-weight-bolder mb-0 text-white">{{$getCountSalesJob->item_issued}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2 jobscount working_progress">
          <div class="card bg-gradient-danger shadow text-white">
              <div class="card-body p-3 cursor-pointer" wire:click="filterJobListPage('working_progress')">
                  <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Working</p>
                      <hr class="m-0">
                      <h5 class="font-weight-bolder mb-0 text-white">{{$getCountSalesJob->working_progress}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2 jobscount cancelled">
          <div class="card bg-gradient-danger shadow text-white">
              <div class="card-body p-3 cursor-pointer" wire:click="filterJobListPage('cancelled')">
                  <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Cancelled</p>
                      <hr class="m-0">
                      <h5 class="font-weight-bolder mb-0 text-white">{{$getCountSalesJob->cancelled}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2 jobscount work_finished">
          <div class="card bg-gradient-warning shadow text-white">
              <div class="card-body p-3 cursor-pointer" wire:click="filterJobListPage('work_finished')">
                  <div class="row">
                      <div class="col-12">
                          <div class="numbers">
                              <p class="text-sm mb-0 text-capitalize font-weight-bold">Completed</p>
                              <hr class="m-0">
                              <h5 class="font-weight-bolder mb-0 text-white">{{$getCountSalesJob->work_finished+$getCountSalesJob->ready_to_deliver}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      
      <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2 jobscount delivered">
          <div class="card bg-gradient-success shadow text-white">
              <div class="card-body p-3 cursor-pointer" wire:click="filterJobListPage('delivered')">
                  <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">Delivered</p>
                      <hr class="m-0">
                      <h5 class="font-weight-bolder mb-0 text-white">{{$getCountSalesJob->delivered}}<span class="text-success text-sm font-weight-bolder"></span></h5>
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
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Job</th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Pricec</th>
                    <!-- <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Department</th> -->
                    <th></th>
                  </tr>
                </thead>

                <tbody>
                  @forelse( $customerjobs as $jobs)
                  <tr class="cursor-pointer" wire:click="customerJobDetails('{{$jobs->job_number}}')">
                    <td>
                      <div class="d-flex px-3 py-1">
                        <div>
                          <img src="{{url('public/storage/'.$jobs->vehicle_image)}}" class="avatar me-3" alt="avatar image">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">{{$jobs->makeInfo['vehicle_name']}} - <small>{{$jobs->modelInfo['vehicle_model_name']}} </small></h6>
                          <p class="text-sm font-weight-bold text-secondary mb-0"><span class="text-success">{{$jobs->plate_number}}</span></p>
                          <hr class="m-0">
                          <p class="text-sm text-dark mb-0">{{$jobs->customer_name}}
                            @if($jobs->customer_email!='')
                            <br>{{$jobs->customer_email}}
                            @endif
                            @if(isset($jobs->customer_mobile))
                            <br>{{$jobs->customer_mobile}}
                            @endif
                          </p>
                        </div>
                      </div>
                      <div class="">
                        <span class="w-100 badge badge-sm {!!config('global.jobs.status_btn_class')[$jobs->job_status]!!}">{{config('global.jobs.status')[$jobs->job_status]}}</span>
                        <div class="d-flex align-items-center justify-content-center">
                          <span class="me-2 text-xs font-weight-bold">{{config('global.jobs.status_perc')[$jobs->job_status]}}</span>
                          <div>
                            <div class="progress">
                              <div class="progress-bar {{config('global.jobs.status_perc_class')[$jobs->job_status]}}" role="progressbar" aria-valuenow="{{config('global.jobs.status_perc')[$jobs->job_status]}}" aria-valuemin="0" aria-valuemax="100" style="width: {{config('global.jobs.status_perc')[$jobs->job_status]}};"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="d-flex px-3 py-1">
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">{{$jobs->job_number}}</h6>
                          <p class="text-sm font-weight-bold mb-0">{{ \Carbon\Carbon::parse($jobs->job_date_time)->format('dS M Y h:i A') }}</p>
                          @if(auth()->user('user')->user_type==1)
                          <small>Created By: {{$jobs->createdInfo['name']}}</small>
                          @endif
                        </div>
                      </div>
                    </td>
                    
                    <td>
                      <div class="d-flex px-3 py-1">
                        <div class="d-flex flex-column justify-content-center">
                          <p class="text-sm font-weight-bold text-secondary mb-0"><span class="text-success">AED {{round($jobs->grand_total,2)}}</span></p>
                          <hr class="my-1">
                          <span class="badge badge-sm {{config('global.payment.status_class')[$jobs->payment_status]}}">{{config('global.payment.status')[$jobs->payment_status]}}</span>
                          @if($jobs->payment_type!=null)
                          <p class="text-sm text-gradient {{config('global.payment.text_class')[$jobs->payment_type]}}  font-weight-bold mb-0">{{config('global.payment.type')[$jobs->payment_type]}}</p>
                          @else
                          <p class="text-sm text-gradient text-dark font-weight-bold mb-0">Pay Later </p>
                          @endif

                        </div>
                      </div>
                      <p class="text-sm font-weight-bold mb-0"></p>
                    </td>
                    
                    
                    
                    <td class="align-middle">

                      <button type="button" wire:click="customerJobDetails('{{$jobs->job_number}}')" class="btn btn-link text-secondary mb-0">
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
            <div class="float-end">{{$customerjobs->onEachSide(0)->links()}}</div>
          </div>
        </div>
      </div>
    </div>
    <div wire:loading wire:target="filterJobListPage">
      <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
          <div class="la-ball-beat">
              <div></div>
              <div></div>
              <div></div>
          </div>
      </div>
    </div>
    <div wire:loading wire:target="customerJobDetails">
      <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
          <div class="la-ball-beat">
              <div></div>
              <div></div>
              <div></div>
          </div>
      </div>
    </div>
  </div>
  @if($updateService)
  @include('components.modals.updateservice')
  @endif
  @if($showaddServiceItems)
  @include('components.modals.addServiceItems')
  @endif
  @include('components.modals.showQwChecklistModel')
    </div>
</main>
@push('custom_script')
  <script type="text/javascript">
    $(document).ready(function(){
      @if($showUpdateModel==true)
        $('#serviceUpdateModal').modal('show');
      @endif
      $('.jobscount').addClass('opacity-5');
      $('.{{$filterTab}}').removeClass('opacity-5');
    });
  </script>

  <script type="text/javascript">
    //Service Section 
    window.addEventListener('showServiceUpdate',event=>{
      $('#serviceUpdateModal').modal('show');
    });
    window.addEventListener('hideServiceUpdate',event=>{
      $('#serviceUpdateModal').modal('hide');
    });

    window.addEventListener('showAddServiceItems',event=>{
      $('#addServiceItemsModal').modal('show');
    });
    window.addEventListener('hideAddServiceItems',event=>{
      $('#addServiceItemsModal').modal('hide');
    });
    
    window.addEventListener('showQwChecklistModel',event=>{
      $('#showQwChecklistModel').modal('show');
    });
    window.addEventListener('showQwChecklistModel',event=>{
      $('#showQwChecklistModel').modal('hide');
    });

    window.addEventListener('filterTab',event=>{
        $('.jobscount').removeClass('opacity-5');
        $('.jobscount').addClass('opacity-5');
        $('.'+event.detail.tabName).removeClass('opacity-5');
    });

    window.addEventListener('openServicesListModal',event=>{
        $('#servicePriceModal').modal('show');
    });
    window.addEventListener('closeServicesListModal',event=>{
        $('#servicePriceModal').modal('hide');
    });
    

  </script>
@endpush

