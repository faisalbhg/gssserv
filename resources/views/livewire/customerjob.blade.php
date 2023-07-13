<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>Service Jobs
              <input type="text"  class="form-control float-end" style="width:20%;" placeholder="Search Job Number" wire:model="search" />
            </h6>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center justify-content-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Customer</th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Job Number</th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Time</th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Pricec</th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Payment</th>
                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2 align-middle text-center">Status</th>
                    <!-- <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Department</th> -->
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse( $customerjobs as $jobs)
                  <tr wire:click="customerJobUpdate('{{$jobs}}')">
                    <td>
                      <div class="d-flex px-2">
                        <div>
                          <img src="{{url('storage/'.$jobs->vehicle_image)}}" class="avatar avatar-md me-2">
                        </div>
                        <div class="my-auto">
                          <h6 class="mb-0 text-sm">{{$jobs->vehicle_name}} - <small>{{$jobs->make_model}} ({{$jobs->plate_number}})</small></h6>
                          <hr class="m-0">
                          <p class="text-sm text-dark mb-0">{{$jobs->name}}({{$jobs->customerType}})<br>{{$jobs->email}}<br>{{$jobs->mobile}}</p>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-sm font-weight-bold mb-0">{{$jobs->job_number}}</p>
                    </td>
                    <td>
                      <p class="text-sm font-weight-bold mb-0">{{ \Carbon\Carbon::parse($jobs->job_date_time)->format('dS M Y H:i A') }}</p>
                    </td>
                    
                    <td>
                      <p class="text-sm font-weight-bold mb-0">AED {{round($jobs->grand_total,2)}}</p>
                    </td>
                    <td>
                      <p class="text-sm text-gradient {{config('global.payment_type_text_class')[$jobs->payment_type]}}  font-weight-bold mb-0">{{config('global.payment_type')[$jobs->payment_type]}}</p>
                      <p class="text-sm text-gradient {{config('global.payment_status_class')[$jobs->payment_status]}}  font-weight-bold mb-0">{{config('global.payment_status')[$jobs->payment_status]}}</p>
                    </td>
                    <td class="align-middle text-center">

                      <span class="badge badge-sm {{config('global.job_status_text_class')[$jobs->job_status]}}">{{config('global.job_status')[$jobs->job_status]}}</span>

                      <div class="d-flex align-items-center justify-content-center">
                        <span class="me-2 text-xs font-weight-bold">{{config('global.status_perc')[$jobs->job_status]}}</span>
                        <div>
                          <div class="progress">
                            <div class="progress-bar {{config('global.status_perc_class')[$jobs->job_status]}}" role="progressbar" aria-valuenow="{{config('global.status_perc')[$jobs->job_status]}}" aria-valuemin="0" aria-valuemax="100" style="width: {{config('global.status_perc')[$jobs->job_status]}};"></div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <!-- <td>

                      <span class="text-xs {{config('global.job_department_text_class')[$jobs->job_status]}} font-weight-bold">{{config('global.job_department')[$jobs->job_departent]}}</span>
                    </td> -->
                    <td class="align-middle">

                      <button type="button" wire:click="customerJobUpdate('{{$jobs}}')" class="btn btn-link text-secondary mb-0">
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
            <div class="float-end">{{$customerjobs->links()}}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('components.modals.updateservice')
    </div>