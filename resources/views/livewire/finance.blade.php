<main class="main-content">
  <div class="container-fluid py-4">
    
    <div class="row">
        <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2 paymentStatusCount psall">
            <div class="card">
                <div class="card-body p-3 cursor-pointer" wire:click="filterPaymentList('all')">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Jobs</p>
                                <h5 class="font-weight-bolder mb-0">{{$getCountPaymentStatus->total}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                <i class="ni ni-archive-2 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2 paymentStatusCount pspaid opacity-5">
            <div class="card">
                <div class="card-body p-3 cursor-pointer" wire:click="filterPaymentList('paid')">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Paid</p>
                                <h5 class="font-weight-bolder mb-0">{{$getCountPaymentStatus->paid}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                <!-- <i class="ni ni-settings text-lg opacity-10" aria-hidden="true"></i> -->
                                <i class="fa-solid fa-sack-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2 paymentStatusCount pspending opacity-5">
            <div class="card">
                <div class="card-body p-3 cursor-pointer" wire:click="filterPaymentList('pending')">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Pending</p>
                                <h5 class="font-weight-bolder mb-0">{{$getCountPaymentStatus->pending}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                <i class="fa-solid fa-hand-holding-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2 paymentStatusCount psfailed opacity-5">
            <div class="card">
                <div class="card-body p-3 cursor-pointer" wire:click="filterPaymentList('failed')">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Faile/Cancelled</p>
                                <h5 class="font-weight-bolder mb-0">{{$getCountPaymentStatus->failed+$getCountPaymentStatus->cancelled}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                                <i class="fa-solid fa-hand-holding-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <div class="row mt-2">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>Jobs Reports
              <input type="text"  class="form-control float-end" style="width:20%;" placeholder="Search Job Number" wire:model="searchjobnumber" />
            </h6>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center justify-content-center mb-0">
                <thead>
                  <tr>
                    <th></th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Job Number</th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Date Time</th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Pricec</th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Vat</th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Total</th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Payment Status</th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Payment Type</th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Name</th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Email</th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Mobile</th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Vehicle</th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2 align-middle text-center">Status</th>
                    
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse( $customerjobs as $jobs)
                  <tr wire:click="jobPaymentUpdate('{{$jobs->job_number}}')">
                    <td><span wire:click="viewInvoice('{{$jobs->job_number}}')" class="cursor-pointer badge badge-sm bg-gradient-info">View Invoice</span></td>
                    <td>
                      <p class="text-sm font-weight-bold mb-0">{{$jobs->job_number}}</p>
                    </td>
                    <td>
                      <p class="text-sm font-weight-bold mb-0">{{ \Carbon\Carbon::parse($jobs->job_date_time)->format('dS M Y H:i A') }}</p>
                    </td>
                    <td>
                      <p class="text-sm font-weight-bold mb-0">AED {{round($jobs->total_price,2)}}</p>
                    </td>
                    <td>
                      <p class="text-sm font-weight-bold mb-0">AED {{round($jobs->vat,2)}}</p>
                    </td>
                    <td>
                      <p class="text-sm font-weight-bold mb-0">AED {{round($jobs->grand_total,2)}}</p>
                    </td>
                    <td>
                      <span class="badge badge-sm {{config('global.payment.status_class')[$jobs->payment_status]}}">{{config('global.payment.status')[$jobs->payment_status]}}</span>
                    </td>
                    <td>
                      <p class="text-sm text-gradient {{config('global.payment.text_class')[$jobs->payment_type]}}  font-weight-bold mb-0">{{config('global.payment.type')[$jobs->payment_type]}}</p>
                    </td>
                    <td>
                      <p class="text-sm font-weight-bold mb-0">{{$jobs->name}}({{$jobs->customerType}})</p>
                    </td>
                    <td>
                      <p class="text-sm font-weight-bold mb-0">{{$jobs->email}}</p>
                    </td>
                    <td>
                      <p class="text-sm font-weight-bold mb-0">{{$jobs->mobile}}</p>
                    </td>
                    <td>
                      <p class="text-sm font-weight-bold mb-0">{{$jobs->vehicle_name}} - <small>{{$jobs->make_model}} ({{$jobs->plate_number}})</small></p>
                    </td>
                    <td>
                      <span class="badge badge-sm {{config('global.jobs.status_btn_class')[$jobs->job_status]}}">{{config('global.jobs.status')[$jobs->job_status]}}</span>
                    </td>
                    
                    
                    <td class="align-middle">

                      <button type="button" wire:click="customerJobUpdate('{{$jobs}}')" class="btn btn-link text-secondary mb-0">
                        <i class="fa fa-edit fa-xl text-md"></i>
                      </button>
                      <!-- data-bs-toggle="modal" data-bs-target="#serviceUpdateModal" -->
                    </td>
                  </tr>
                  @empty
                    <tr>
                      <td colspan="12">No Record Found</td>
                    </tr>
                  @endforelse
                
              </tbody>
            </table>
            <div class="float-end">{{$customerjobs->links()}}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
    @if($showInvoiceModel)
    @include('components.modals.viewInvoiceModal')
    @endif
    </div>
</main>

@push('custom_script')

<script type="text/javascript">
    $(document).ready(function(){
      @if($showUpdateModel==true)
        $('#paymentUpdateModal').modal('show');
      @endif
      $('.jobscount').addClass('opacity-5');
      $('.{{$paymentFilterTab}}').removeClass('opacity-5');
    });
  </script>
  
  
  <script type="text/javascript">
    window.addEventListener('paymentFilterTab',event=>{
        $('.paymentStatusCount').removeClass('opacity-5');
        $('.paymentStatusCount').addClass('opacity-5');
        $('.ps'+event.detail.tabName).removeClass('opacity-5');
    });
  </script>
  <script type="text/javascript">
    //Service Section 
    window.addEventListener('showServiceUpdate',event=>{
      $('#paymentUpdateModal').modal('show');
    });

    window.addEventListener('showInvoiceView',event=>{
      $('#viewInvoiceModal').modal('show');
    });
</script>
@endpush