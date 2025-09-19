<style>
    .modal-dialog {
        max-width: 90%;
    }
    .modal{
        z-index: 99999;
    }
</style>

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="packageDetailsModal" tabindex="-1" role="dialog" aria-labelledby="packageDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header" style="display:inline !important;">
                <div class="d-sm-flex justify-content-between">
                    <div>
                      <h6 class="mb-0">{{$selectedPackage['package_name']}}</h6>
                      <i class="far fa-calendar-alt me-2" aria-hidden="true"></i>
                      <small>Duration: {{$selectedPackage['package_duration']}} Months<br>{{$selectedPackage['package_km']}} K.M</small>
                    </div>
                    <div class="d-flex">
                    	<a  class="cursor-pointer" data-bs-dismiss="modal"><i class="text-danger fa-solid fa-circle-xmark fa-xxl" style="font-size:2rem;"></i></a>
                    </div>
                </div>
                
            </div>
            
            <div class="modal-body">
                <div class="row">
                	<div class="col-md-8">
	                	<?php $totalPrice=0;?>
	                    <?php $unitPrice=0;?>
	                    <?php $discountedPrice=0;?>
	                	@foreach($selectedPackage['customer_package_services'] as $packageDetails)
		                	<div class="row">
			                    <div class="col-md-12">
			                        <div class="card h-100">
			                            <div class="card-body p-3">
			                                <ul class="list-group">
			                                	<?php $totalPrice = $totalPrice+$packageDetails['total_price']; ?>
			                                    <?php $unitPrice = $unitPrice+($packageDetails['unit_price']*$packageDetails['quantity']); ?>
			                                    <?php $discountedPrice = $discountedPrice+(($packageDetails['unit_price']-$packageDetails['discounted_price'])*$packageDetails['quantity']); ?>
			                                    <li class="list-group-item border-0 justify-content-between ps-0 pb-0 border-radius-lg">
			                                        <div class="d-flex">
			                                            <div class="d-flex align-items-center">
			                                                <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center">
			                                                    <i class="fa-solid fa-check" aria-hidden="true"></i>
			                                                </button>
			                                                <div class="d-flex flex-column">
			                                                    @if($packageDetails['item_type']=='S')
			                                                    <h6 class="mb-1 text-dark text-sm">{{$packageDetails['labour_item_details']['ItemName']}} - ({{$packageDetails['item_code']}})</h6>
			                                                    
			                                                    @else
			                                                    <h6 class="mb-1 text-dark text-sm">{{$packageDetails['inventory_item_details']['ItemName']}}</h6>
			                                                    @endif
			                                                    <span class="text-xs">Qty: {{$packageDetails['quantity']}}</span>
			                                                    <span class="text-xs">Used: {{$packageDetails['package_service_use_count']}}</span>
			                                                </div>
			                                            </div>
			                                            <div class="d-flex px-3 py-1">
															@if($packageDetails['quantity'] > $packageDetails['package_service_use_count'])
																<?php $packageBookedDateTime = new Carbon\Carbon($selectedPackage['package_date_time']); ?>
																<?php $endPackageDateTime = $packageBookedDateTime->addMonth($selectedPackage['package_duration']); ?>
																@if(\Carbon\Carbon::now()->diffInDays($endPackageDateTime, false)>=0)
																	<span class="badge bg-gradient-success">Active</span>
																@else
																	<span class="badge bg-gradient-danger">Expired</span>
																@endif
															@else
																<span class="badge bg-gradient-danger">Package Used</span>
															@endif
														</div>
			                                            <div class="d-flex align-items-center text-dark text-sm font-weight-bold ms-auto">
			                                            	<del class="text-secondary me-2">AED {{custom_round($packageDetails['quantity']*$packageDetails['unit_price'])}}</del>  AED {{custom_round($packageDetails['quantity']*$packageDetails['discounted_price'])}}
			                                            </div>
			                                        </div>
			                                        <hr class="horizontal dark mt-3 mb-2">
			                                    </li>
			                                </ul>
			                            </div>
			                        </div>
			                    </div>
			                </div>
	                	@endforeach
	                </div>
	            	<div class="col-md-4">
	            		<div class="row">
                            <div class="col-md-12">
                                <div class="card card-profile card-plain">
                                     <div class="card-body p-0 text-left">
                                        <ul class="list-group">
                                            <li class="list-group-item border-0  p-2 mb-2 border-radius-lg">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card h-100 mb-4">
                                                            <div class="card-body pt-4 p-2">
                                                                <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-0">Payment Summary</h6>
                                                                <ul class="list-group">
                                                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                                        <div class="d-flex align-items-center">
                                                                            <button class="btn btn-icon-only btn-rounded mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-right" aria-hidden="true"></i></button>
                                                                            <div class="d-flex flex-column">
                                                                                <h6 class="mb-1 text-dark text-sm">Total Price</h6>
                                                                                <span class="text-xs">total price description</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                                                        {{config('global.CURRENCY')}} {{custom_round($selectedPackage['total_price'])}}
                                                                        </div>
                                                                    </li>
                                                                    @if($discountedPrice>0)
                                                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                                        <div class="d-flex align-items-center">
                                                                            <button class="btn btn-icon-only btn-rounded mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-right" aria-hidden="true"></i></button>
                                                                            <div class="d-flex flex-column">
                                                                                <h6 class="mb-1 text-dark text-sm">Discount</h6>
                                                                                <span class="text-xs">discount description</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                                                        {{config('global.CURRENCY')}} {{custom_round($discountedPrice)}}
                                                                        </div>
                                                                    </li>
                                                                    @endif
                                                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                                        <div class="d-flex align-items-center">
                                                                            <button class="btn btn-icon-only btn-rounded mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-right" aria-hidden="true"></i></button>
                                                                            <div class="d-flex flex-column">
                                                                                <h6 class="mb-1 text-dark text-sm">Vat</h6>
                                                                                <span class="text-xs">Vat 5%</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                                                        {{config('global.CURRENCY')}} {{custom_round($selectedPackage['vat'])}}
                                                                        </div>
                                                                    </li>
                                                                    <hr class="horizontal dark mt-3">

                                                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                                        <div class="d-flex align-items-center">
                                                                            <button class="btn btn-icon-only btn-rounded mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-right" aria-hidden="true"></i></button>
                                                                            <div class="d-flex flex-column">
                                                                                <h6 class="mb-1 text-dark text-md">Grand Total</h6>
                                                                                <span class="text-xs"></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex align-items-center text-success text-gradient text-md font-weight-bold">
                                                                        {{config('global.CURRENCY')}} {{custom_round(($selectedPackage['grand_total']))}}
                                                                        </div>
                                                                    </li>
                                                                    
                                                                    
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
	            	</div>
            	</div>
            	<div class="row">
            		<div class="card">
						<div class="card-header">
							<h4>Package History</h4>
						</div>
						<div class="card-body">
							<table class="table align-items-center justify-content-center mb-0">
								<thead>
									<tr>
										<th>Job Details</th>
										<th>Vehicle</th>
									</tr>
								</thead>
								<tbody>
									@forelse($selectedPackage['package_history'] as $packageHistory)
										<tr class="cursor-pointer" >
											<td>
												<div class="d-flex px-3 py-1">
													<div class="d-flex flex-column justify-content-center">
														<h6 class="mb-0 text-sm">{{$packageHistory['job_info']['job_number']}}</h6>
														<p class="text-sm font-weight-bold mb-0">{{ \Carbon\Carbon::parse($packageHistory['job_info']['job_date_time'])->format('dS M Y h:i A') }}</p>
													</div>
												</div>
											</td>
											<td>
												<div class="d-flex px-3 py-1">
													<div>
														<img src="{{url('public/storage/'.$packageHistory['job_info']['vehicle_image'])}}" class="avatar me-3" alt="avatar image">
													</div>
													<div class="d-flex flex-column justify-content-center">
														<h6 class="mb-0 text-sm">{{$packageHistory['job_info']['make_info']['vehicle_name']}} - <small>{{$packageHistory['job_info']['model_info']['vehicle_model_name']}} </small></h6>
														<p class="text-sm font-weight-bold text-secondary mb-0"><span class="text-success">{{$packageHistory['job_info']['plate_number']}}</span></p>
														<hr class="m-0">
														<p class="text-sm text-dark mb-0">{{$packageHistory['job_info']['customer_name']}}
														@if($packageHistory['job_info']['customer_email']!='')
														<br>{{$packageHistory['job_info']['customer_email']}}
														@endif
														@if(isset($packageHistory['job_info']['customer_mobile']))
														<br>{{$packageHistory['job_info']['customer_mobile']}}
														@endif
														</p>
													</div>
												</div>
											</td>
										</tr>
									@empty
										<tr>
											<td colspan="8">No Record Found</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
					</div>
            	</div>
            </div>
       </div>
    </div>
</div>
