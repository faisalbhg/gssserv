@push('custom_css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
    .select2-container--default .select2-selection--single{
        border: 1px solid #d2d6da !important;
        border-radius: 0.5rem !important;
    }
    .select2-container .select2-selection--single
    {
        height: 40px;
    }
</style>
@endpush

<main class="main-content position-relative  border-radius-lg">
    <div class="container-fluid py-2">
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

        @if($searchby)
        <div class="d-flex mt-0 mb-3 mx-0">
            <div class=" d-flex">
                <h5 class="mb-1 text-gradient text-dark">
                    <a href="javascript:;">Search By: </a>
                </h5>
                <div class="px-2 position-relative ">
                    <button wire:click="clickSearchBy('1')" class="btn @if($searchByMobileNumber) bg-gradient-primary @else bg-gradient-default @endif  mb-0" data-toggle="modal" data-target="#new-board-modal">
                        Mobile Number
                    </button>
                    <hr class="vertical dark mt-2">
                </div>
                <div class="px-2 position-relative ">
                    <button wire:click="clickSearchBy('2')" class="btn @if($searchByPlateNumber) bg-gradient-primary @else bg-gradient-default @endif mb-0" data-toggle="modal" data-target="#new-board-modal">
                        Plate Number
                    </button>
                    <hr class="vertical dark mt-2">
                </div>
                <div class="px-2">
                    <button wire:click="clickSearchBy('3')" class="btn @if($searchByChaisis) bg-gradient-primary @else bg-gradient-default @endif mb-0" data-toggle="modal" data-target="#new-board-modal">
                        Chaisis Number
                    </button>
                </div>
            </div>
        </div>
        @endif
        @if($selectedCustomerVehicle)
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-4">
                        <div class="card card-profile card-plain">
                            <div class="position-relative">
                                <div class="blur-shadow-image">
                                    <img class="w-100 rounded-3 shadow-lg" src="{{url("public/storage/".$selectedVehicleInfo["vehicle_image"])}}">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="card card-profile card-plain">
                            <div class="card-body text-left p-0">
                                <div class="p-md-0 pt-3">
                                    
                                    <h5 class="font-weight-bolder mb-0">{{$selectedVehicleInfo['plate_number_final']}}</h5>
                                    <p class="text-uppercase text-sm font-weight-bold mb-2">{{$selectedVehicleInfo['make']}}, {{$selectedVehicleInfo['model']}}</p>
                                </div>
                                @if($selectedVehicleInfo['customerInfoMaster']['TenantName'])
                                    @if($selectedVehicleInfo['customerInfoMaster']['TenantName'])
                                    <p class="mb-0">{{$selectedVehicleInfo['customerInfoMaster']['TenantName']}}</p>
                                    @endif
                                    @if($selectedVehicleInfo['customerInfoMaster']['Mobile'])
                                    <p class="mb-0">{{$selectedVehicleInfo['customerInfoMaster']['Mobile']}}</p>
                                    @endif
                                    @if($selectedVehicleInfo['customerInfoMaster']['Email'])
                                    <p class="mb-1">{{$selectedVehicleInfo['customerInfoMaster']['Email']}}</p>
                                    @endif
                                @else
                                <p class="mb-0">Customer Guest</p>
                                @endif
                                @if($selectedVehicleInfo['chassis_number'])
                                <p class="mb-1"><b>Chaisis:</b> {{$selectedVehicleInfo['chassis_number']}}</p>
                                @endif
                                @if($selectedVehicleInfo['vehicle_km'])
                                <b>KM Reading:</b> {{$selectedVehicleInfo['vehicle_km']}}</p>
                                @endif
                                
                                <button type="button" class="btn bg-gradient-primary btn-tooltip btn-sm" title="Edit Customer/Discount/Vehicle" wire:click="editCustomer()">Edit</button>
                                <button type="button" class="btn bg-gradient-primary btn-tooltip btn-sm" title="Add Customer/Discount/Vehicle">New</button>
                                <button type="button" class="btn bg-gradient-info btn-tooltip btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Apply Discount Group" data-container="body" data-animation="true" wire:click="clickDiscountGroup()">Discount Group</button>
                                <button class="btn bg-gradient-info btn-sm" wire:click.prevent="openServiceGroup">Services</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            
            <!-- Modal -->
            <style type="text/css">
                .modal-body{
                    max-height: calc(100vh - 300px);
                    overflow-y: auto;
                }
            </style>
            <div class="modal fade" id="discountGroupModal" tabindex="-1" role="dialog" aria-labelledby="discountGroupModalLabel" aria-hidden="true" wire:ignore.self style="z-index:99999;" >
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="discountGroupModalLabel">Discount Groups</h5>
                            
                            <button type="button" class="btn-close text-dark " data-bs-dismiss="modal" aria-label="Close" style="font-size: 2.125rem !important;" >
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body py-0">
                            <div class="row mt-2">
                                <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            @foreach($laborCustomerGroupLists as $listCustDiscGrp)
                                            <div class="col-lg-2 col-sm-4 my-2">
                                                @if($customerDiscontGroupId == $listCustDiscGrp->id)
                                                <div wire:click="selectAvailableCustDiscountGroup({{$listCustDiscGrp->id}})" class="card bg-primary h-100">
                                                    <div class="card-body">
                                                        <p class="mt-4 mb-0 font-weight-bold text-white">{{str_replace("_"," ",$listCustDiscGrp->discount_title)}}</p>
                                                        <p class="mt-4 mb-0 text-white">{{$listCustDiscGrp->discount_card_number}}</p>
                                                        <span class="text-xs text-white">Expired in: <?php $end = \Carbon\Carbon::parse($listCustDiscGrp->discount_card_validity);?>
                                                        {{ \Carbon\Carbon::now()->diffInDays($end) }} Days</span>
                                                    </div>
                                                </div>
                                                @else
                                                <div wire:click="selectAvailableCustDiscountGroup({{$listCustDiscGrp->id}})" class="card  h-100">
                                                    <div class="card-body">
                                                        <h4 class="mt-4 mb-0 font-weight-bold">{{str_replace("_"," ",$listCustDiscGrp->discount_title)}}</h4>
                                                        <p class="mt-4 mb-0 font-weight-bold">{{$listCustDiscGrp->discount_card_number}}</p>
                                                        <span class="text-xs">Expired in: <?php $end = \Carbon\Carbon::parse($listCustDiscGrp->discount_card_validity);?>
                                                        {{ \Carbon\Carbon::now()->diffInDays($end) }} Days</span>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            @endforeach
                                            
                                            
                                            
                                            
                                        </div>
                                        <hr class="horizontal dark my-2">
                                        <div class="row">
                                            <div class="d-flex align-items-center">
                                                <h6 class="mb-0">
                                                    <label class="badge @if($this->sisterCompanies) bg-gradient-secondary @else bg-gradient-dark @endif cursor-pointer" wire:click="discountGroupFilter('all')"> All Discount Group</label>
                                                    <!-- <label class="badge @if($this->sisterCompanies) bg-gradient-dark @else bg-gradient-secondary @endif cursor-pointer" wire:click="discountGroupFilter('sister')"> Sister Companies</label> -->
                                                </h6>
                                            </div>
                                            <div class="col-6">
                                                @error('$selectedDiscountId') <span class="text-danger">{{ $message }}</span> @enderror
                                                <div class="table-responsive" style="height:200px; overflow-y: scroll ;">
                                                    <table class="table align-items-center mb-0">
                                                        <tbody>
                                                            @foreach($laborCustomerGroupLists as $laborCustomerGroupList)
                                                            <tr  wire:click="selectDiscountGroup({{$laborCustomerGroupList}})">
                                                                <td>
                                                                    <div class="d-flex px-2 py-0">
                                                                        @if($selectedDiscountId == $laborCustomerGroupList->Id)
                                                                        <span class="badge bg-gradient-success me-3"> </span>
                                                                        @else
                                                                        <span class="badge bg-gradient-secondary me-3"> </span>
                                                                        @endif
                                                                        <div class="d-flex flex-column justify-content-center">
                                                                            <h6 class="mb-0 text-sm">{{str_replace("_"," ",$laborCustomerGroupList->Title)}}</h6>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <!-- <td class="align-middle text-center text-sm">
                                                                    <span class="text-xs font-weight-bold"> 15% </span>
                                                                </td> -->
                                                            </tr>
                                                            @endforeach
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-6 text-center">
                                                <div class="row">
                                                    
                                                    @if($selectedDiscountTitle)
                                                    <label class="badge bg-gradient-success text-light text-bold text-lg mb-0" style="white-space: normal; text-transform: capitalize;">{{str_replace("_"," ",strtolower($selectedDiscountTitle))}}</label>
                                                    @endif

                                                    @if($searchStaffId)
                                                        <p class="badge bg-gradient-danger text-light text-bold text-lg mb-0">{{$staffavailable}}</p>
                                                        <div class="row mb-0">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="employeeId">Employee Id</label>
                                                                    <input type="text" class="form-control" wire:model="employeeId" id="employeeId" placeholder="Staff/Employee Id">
                                                                    @error('employeeId') <span class="text-danger">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <button type="button" class="btn bg-gradient-primary" wire:click="checkStaffDiscountGroup()">Check Employee</button>
                                                            </div>
                                                        </div>
                                                        
                                                    @else
                                                        <div class="row mb-0">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="discountCardImgae">Discount Card Imgae</label>
                                                                    <input type="file" class="form-control" wire:model.defer="discount_card_imgae">
                                                                    @error('discount_card_imgae') <span class="text-danger">{{ $message }}</span> @enderror
                                                                    @if ($discount_card_imgae)
                                                                    <img class="img-fluid border-radius-lg w-30" src="{{ $discount_card_imgae->temporaryUrl() }}">
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="discountCardNumber">Discount Card Number</label>
                                                                    <input type="text" class="form-control" wire:model="discount_card_number" placeholder="Discount Card Number">
                                                                    @error('discount_card_number') <span class="text-danger">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="discountCardValidity">Discount Card Validity</label>
                                                                    <input type="date" class="form-control" id="discountCardValidity" wire:model="discount_card_validity" name="discountCardValidity" placeholder="Discount Card Validity">
                                                                    @error('discount_card_validity') <span class="text-danger">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="button" class="btn bg-gradient-primary" wire:click="saveSelectedDiscountGroup()">Save changes</button>
                                                    @endif
                                                    
                                                </div>

                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="numberPlateModal" tabindex="-1" role="dialog" aria-labelledby="numberPlateModalLabel" aria-hidden="true" wire:ignore.self style="z-index:99999;" >
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:90%;">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="numberPlateModalLabel">Plate Number</h5>
                            <button type="button" class="btn-close text-dark " data-bs-dismiss="modal" aria-label="Close" style="font-size: 2.125rem !important;" >
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body py-0">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12 mt-4 mt-lg-0 ">
                                    <div class="card my-2" ">
                                        <div class="card-body p-3 cursor-pointer ">
                                            <img src="{{url('storage/'.$selectedVehicleInfo['plate_number_image'])}}" class="w-100" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 my-2">
                @if(count($cartItems)>0)
                    <div class="card card-profile card-plain">
                        <h6 class="text-uppercase text-body text-lg font-weight-bolder mt-2">Pricing Summary <span class="float-end text-sm text-danger text-capitalize">{{ count($cartItems) }} Services selected</span></h6>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card h-100">
                                    
                                    <div class="card-body p-3 pb-0">
                                        <ul class="list-group">
                                            <?php $total=0; $totalDiscount=0; ?>
                                            @foreach ($cartItems as $item)
                                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                    
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-1 text-dark font-weight-bold text-sm">
                                                            {{ $item->item_name }}
                                                        </h6>
                                                        <span class="text-xs">#{{ $item->item_code }}</span>
                                                        @if($item->extra_note)
                                                            <span class="text-xs text-dark">Note: {{ $item->extra_note }}</span>
                                                        @endif
                                                        @if($item->customer_group_code)
                                                        <p class="mb-0"><span class="text-sm text-dark">Discount Group: {{ $item->customer_group_code }} <label class="badge bg-gradient-info">{{ $item->discount_perc }}% Off</label></span></p>
                                                        @endif
                                                        <a href="#" class="p-0 text-danger bg-red-600" wire:click.prevent="removeCart('{{$item->id}}')"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                    <div class="d-flex align-items-center text-sm">
                                                        {{$item->quantity}} x
                                                        <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4" @if($item->customer_group_code) style="text-decoration: line-through;" @endif >{{config('global.CURRENCY')}} {{round($item->unit_price,2)}}</button>

                                                        @if($item->customer_group_code)
                                                        <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4">{{config('global.CURRENCY')}} {{ round($item->unit_price-(($item->discount_perc/100)*($item->unit_price)),2) }}</button>
                                                        @endif

                                                    </div>

                                                </li>
                                                <hr class="horizontal dark mt-0 mb-2">
                                                <?php
                                                $total = $total+$item->unit_price*$item->quantity;
                                                $totalDiscount = $totalDiscount+round((($item->discount_perc/100)*($item->unit_price*$item->quantity)),2)
                                                ?>
                                            @endforeach
                                            <?php
                                            $tax = $total * (config('global.TAX_PERCENT') / 100);
                                            $grand_total = $total+$tax-$totalDiscount;
                                            ?>
                                        </ul>
                                        
                                        <button class="btn bg-gradient-danger btn-sm float-end" wire:click.prevent="clearAllCart">Remove All Cart</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12 ms-auto">
                                <h6 class="mb-3">Order Summary</h6>
                                <div class="d-flex justify-content-between">
                                    <span class="mb-2 text-sm">
                                    Product Price:
                                    </span>
                                    <span class="text-dark font-weight-bold ms-2">{{config('global.CURRENCY')}} {{round($total,2)}}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="mb-2 text-sm">
                                    Discount:
                                    </span>
                                    <span class="text-dark ms-2 font-weight-bold">{{config('global.CURRENCY')}} {{round($totalDiscount,2)}}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-sm">
                                    Taxes:
                                    </span>
                                    <span class="text-dark ms-2 font-weight-bold">{{config('global.CURRENCY')}} {{round($tax,2)}}</span>
                                </div>
                                <hr class="horizontal dark my-2">
                                <div class="d-flex justify-content-between mt-2">
                                    <span class="mb-2 text-lg text-dark text-bold">
                                    Total:
                                    </span>
                                    <span class="text-dark text-lg ms-2 font-weight-bold">{{config('global.CURRENCY')}} {{round($grand_total,2)}}</span>
                                </div>
                                <button type="button" class="btn bg-gradient-success btn-sm float-end" wire:click="submitService()">Confirm & Continue</button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @endif
        @if($editCustomerVehicle)
            <div class="row">
                <div class="col-md-12">
                    <div class="card px-3 my-2" >
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="editMobilenumberInput">Mobile Number </label>
                                        <div class="input-group mb-0">
                                            <span class="input-group-text px-0">+971</span>
                                            <input class="form-control" placeholder="Mobile Number" type="number" wire:model.defer="edit_mobile" name="edit_mobile" id="editMobilenumberInput">
                                        </div>
                                        @error('edit_mobile') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group openDiv">
                                        <label for="editNameInput">Name</label>
                                        <input type="text" class="form-control" wire:model.defer="edit_name" name="edit_name" placeholder="Name" id="editNameInput">
                                        @error('edit_name') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group openName">
                                        <label for="editEmailInput">Email</label>
                                        <input type="email" wire:model.defer="edit_email" name="edit_email" class="form-control" id="editEmailInput" placeholder="Email">
                                        @error('edit_email') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card px-3 my-2" >
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row mb-0">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="plateImage">Plate Imgae</label>
                                                <input type="file" class="form-control" wire:model="edit_plate_number_image" id="plateImage">
                                                @if ($plate_number_image)
                                                <img class="img-fluid border-radius-lg w-30" src="{{url('storage/'.$plate_number_image)}}">
                                                @endif
                                                @if ($edit_plate_number_image)
                                                    <button type="button" class="btn bg-gradient-secondary btn-sm" wire:click="getPlateNumber('{{$edit_plate_number_image->temporaryUrl()}}')">Get Plate Number</button>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <label for="editPlateCountry">Country</label>
                                                <select class="form-control  " wire:model="edit_plate_country"  id="editPlateCountry" name="PlateCountry" aria-invalid="false"><option value="">Select</option>
                                                    @foreach($countryLists as $country)
                                                    <option value="{{$country->CountryCode}}">{{$country->CountryName}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <label for="editplateEmirates">Plate Emirates</label>
                                                <select class="form-control  " wire:model="edit_plate_state" name="edit_plate_state" id="editplateEmirates" style="padding:0.5rem 0.3rem !important;" >
                                                    <option value="">-Emirates-</option>
                                                    @foreach($stateList as $state)
                                                    <option value="{{$state->StateName}}">{{$state->StateName}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <label for="editplateCode">Plate Code</label>
                                                <select class="form-control  " wire:model="edit_plate_code" name="editplateCode" id="editplateCode" style="padding:0.5rem 0.3rem !important;" >
                                                    <option value="">-Code-</option>
                                                    @foreach($editplateEmiratesCodes as $editplateCode)
                                                    <option value="{{$editplateCode->plateColorTitle}}">{{$editplateCode->plateColorTitle}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="editPlateNumber">Plate Number</label>
                                                <input style="padding:0.5rem 0.3rem !important;" type="number" id="editPlateNumber" class="form-control @error('edit_plate_number') btn-outline-danger @enderror" wire:model="edit_plate_number" name="edit_plate_number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="1" maxlength="6" placeholder="Number">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="editVehicleImage">Vehicle Picture</label>
                                        <input type="file" class="form-control" wire:model="edit_vehicle_image" name="edit_vehicle_image" id="editVehicleImage">
                                        @error('edit_vehicle_image') <span class="text-danger">{{ $message }}</span> @enderror
                                        @if ($vehicle_image)
                                            <img class="img-fluid border-radius-lg w-30" src="{{url('public/storage/'.$vehicle_image)}}">
                                        @endif
                                        @if ($edit_vehicle_image)
                                        <img class="img-fluid border-radius-lg w-30" src="{{ $edit_vehicle_image->temporaryUrl() }}">
                                        @endif
                                    </div>
                                    
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="editVehicleTypeInput">Vehicle Type</label>
                                        <select class="form-control selectSearch" id="editVehicleTypeInput" wire:model="edit_vehicle_type" name="edit_vehicle_type">
                                            <option value="">-Select-</option>
                                            @foreach($vehicleTypesList as $vehicleType)
                                            <option value="{{$vehicleType->id}}">{{$vehicleType->type_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('edit_vehicle_type') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="editVehicleMakeInput">Vehicle Make</label>
                                        <select class="form-control selectSearch" id="editVehicleMakeInput" wire:model="edit_make" name="edit_make" >
                                            <option value="">-Select-</option>
                                            @foreach($listVehiclesMake as $vehicleName)
                                            <option value="{{$vehicleName['name']}}">{{$vehicleName['name']}}</option>
                                            @endforeach
                                        </select>
                                        @error('edit_make') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="editVehicleModelInput">Vehicle Model</label>

                                        <select class="form-control" id="editVehicleModelInput" wire:model="edit_model" name="edit_model">
                                            <option value="">-Select-</option>
                                            @foreach($vehiclesModel as $model)
                                            <option value="{{$model['Model_Name']}}">{{$model['Model_Name']}}</option>
                                            @endforeach
                                        </select>
                                         @error('edit_model') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="editChaisisImage">Chaisis Imgae</label>
                                        <input type="file" class="form-control" wire:model="edit_chaisis_image" id="editChaisisImage">
                                        @if ($edit_chaisis_image)
                                            <button type="button" class="btn bg-gradient-secondary btn-sm" wire:click="getChaisisNumber('{{$chaisis_image->temporaryUrl()}}')">Get Chaisis Number</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="editChaisisNumberInput">Chaisis Number</label>
                                        <input type="text" class="form-control" id="editChaisisNumberInput" wire:model.defer="edit_chassis_number" name="edit_chassis_number" placeholder="Chassis Number">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="editVehicleKmInput">K.M Reading</label>
                                        <input type="number" class="form-control" id="editVehicleKmInput" wire:model.defer="edit_vehicle_km" name="edit_vehicle_km" placeholder="Chaisis Number">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" wire:click="updateVehicleCustomer()" class="btn btn-primary btn-sm">Update Vehicle</button>
                                    <button type="button" wire:click="closeUpdateVehicleCustomer()" class="btn btn-default btn-sm">cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if($addNewCustomerVehicle)
            <div class="row">
                <div class="col-md-12">
                    <div class="card px-3 my-2" >
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row mb-0">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="addPlateImage">Plate Imgae</label>
                                                <input type="file" class="form-control" wire:model="add_plate_number_image" name="add_plate_number_image" id="addPlateImage">
                                                
                                                @if ($add_plate_number_image)
                                                    <button type="button" class="btn bg-gradient-secondary btn-sm" wire:click="getPlateNumber('{{$add_plate_number_image->temporaryUrl()}}')">Get Plate Number</button>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="addPlateEmirates">Plate Emirates</label>
                                                <select class="form-control  " wire:model="add_plate_state" name="add_plate_state" id="addPlateEmirates" style="padding:0.5rem 0.3rem !important;" >
                                                    <option value="">-Emirates-</option>
                                                    @foreach($stateList as $state)
                                                    <option value="{{$state->state_name}}">{{$state->state_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="addPlateCode">Plate Code</label>
                                                <input style="padding:0.5rem 0.3rem !important;" type="text" id="addPlateCode" class="form-control @error('add_plate_code') btn-outline-danger @enderror" wire:model="add_plate_code" name="add_plate_code" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="1" maxlength="2" placeholder="Code">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="addPlateNumber">Plate Number</label>
                                                <input style="padding:0.5rem 0.3rem !important;" type="number" id="addPlateNumber" class="form-control @error('add_plate_number') btn-outline-danger @enderror" wire:model="add_plate_number" name="add_plate_number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="1" maxlength="6" placeholder="Number">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="addVehicleImage">Vehicle Picture</label>
                                        <input type="file" class="form-control" wire:model="add_vehicle_image" name="add_vehicle_image" id="addVehicleImage">
                                        @error('add_vehicle_image') <span class="text-danger">{{ $message }}</span> @enderror
                                        @if ($vehicle_image)
                                            <img class="img-fluid border-radius-lg w-30" src="{{url('storage/'.$vehicle_image)}}">
                                        @endif
                                        @if ($add_vehicle_image)
                                        <img class="img-fluid border-radius-lg w-30" src="{{ $add_vehicle_image->temporaryUrl() }}">
                                        @endif
                                    </div>
                                    
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="addVehicleTypeInput">Vehicle Type</label>
                                        <select class="form-control selectSearch" id="addVehicleTypeInput" wire:model="add_vehicle_type" name="add_vehicle_type">
                                            <option value="">-Select-</option>
                                            @foreach($vehicleTypesList as $vehicleType)
                                            <option value="{{$vehicleType->id}}">{{$vehicleType->type_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('add_vehicle_type') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="addVehicleMakeInput">Vehicle Make</label>
                                        <select class="form-control selectSearch" id="addVehicleMakeInput" wire:model="add_make" name="add_make" >
                                            <option value="">-Select-</option>
                                            @foreach($listVehiclesMake as $vehicleName)
                                            <option value="{{$vehicleName->vehicle_make}}">{{$vehicleName->vehicle_make}}</option>
                                            @endforeach
                                        </select>
                                        @error('add_make') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="addVehicleModelInput">Vehicle Model</label>

                                        <select class="form-control" id="addVehicleModelInput" wire:model="add_model" name="add_model">
                                            <option value="">-Select-</option>
                                            @foreach($vehiclesModel as $model)
                                            <option value="{{$model->model}}">{{$model->model}}</option>
                                            @endforeach
                                        </select>
                                         @error('add_model') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="addChaisisImage">Chaisis Imgae</label>
                                        <input type="file" class="form-control" wire:model="add_chaisis_image" id="addChaisisImage">
                                        @if ($edit_chaisis_image)
                                            <button type="button" class="btn bg-gradient-secondary btn-sm" wire:click="getChaisisNumber('{{$chaisis_image->temporaryUrl()}}')">Get Chaisis Number</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="addChaisisNumberInput">Chaisis Number</label>
                                        <input type="text" class="form-control" id="addChaisisNumberInput" wire:model.defer="add_chassis_number" name="add_chassis_number" placeholder="Chassis Number">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="addVehicleKmInput">K.M Reading</label>
                                        <input type="number" class="form-control" id="addVehicleKmInput" wire:model.defer="add_vehicle_km" name="add_vehicle_km" placeholder="Chaisis Number">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" wire:click="saveAddNewVehicleCustomer()" class="btn btn-primary btn-sm">Save Vehicle</button>
                                    <button type="button" wire:click="closeAddNewVehicleCustomer()" class="btn btn-default btn-sm">cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @include('components.newcustomeoperation')
        @include('components.modals.customerSignatureModel')
    </div>
</main>

@push('custom_script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    window.addEventListener('scrolltop',event=>{
        $(document).ready(function(){
            $('html, body').animate({
                scrollTop: $("#servceGroup").offset().top - 100
            }, 100);
        });
    });

    window.addEventListener('openServicesListModal',event=>{
        $('#servicePriceModal').modal('show');
    });
    window.addEventListener('closeServicesListModal',event=>{
        $('#servicePriceModal').modal('hide');
    });

    window.addEventListener('opennumberPlateModal',event=>{
        $('#numberPlateModal').modal('show');
    });
    window.addEventListener('closenumberPlateModal',event=>{
        $('#numberPlateModal').modal('hide');
    });

    window.addEventListener('openDiscountGroupModal',event=>{
        $('#discountGroupModal').modal('show');
    });
    window.addEventListener('closeDiscountGroupModal',event=>{
        $('#discountGroupModal').modal('hide');
    });

    window.addEventListener('openPckageAddOnsModal',event=>{
        $('#pckageAddOnsModal').modal('show');
    });
    window.addEventListener('closePckageAddOnsModal',event=>{
        $('#pckageAddOnsModal').modal('hide');
    });

    window.addEventListener('selectSearchEvent',event=>{
        $(document).ready(function () {
            $('#newVehicleKMClick').click(function(){
                //alert('5');
                $('.signaturePadDiv').hide();
            });
            $('#customerTypeSelect').select2();
            $('#plateState').select2();
            $('#vehicleTypeInput').select2();
            $('#vehicleMakeInput').select2();
            $('#vehicleModelInput').select2();
            $('#seachByCategory').select2();
            $('#seachBySubCategory').select2();
            $('#seachByBrand').select2();

            $('#customerTypeSelect').on('change', function (e) {
                var customerTypeVal = $('#customerTypeSelect').select2("val");
                @this.set('customer_type', customerTypeVal);
            });
            $('#plateState').on('change', function (e) {
                var plateStateVal = $('#plateState').select2("val");
                @this.set('plate_state', plateStateVal);
            });
            $('#vehicleTypeInput').on('change', function (e) {
                var vehicleTypeVal = $('#vehicleTypeInput').select2("val");
                @this.set('vehicle_type', vehicleTypeVal);
            });
            $('#vehicleMakeInput').on('change', function (e) {
                var makeVal = $('#vehicleMakeInput').select2("val");
                @this.set('make', makeVal);
            });
            $('#vehicleModelInput').on('change', function (e) {
                var modelVal = $('#vehicleModelInput').select2("val");
                @this.set('model', modelVal);
            });
            $('#seachByCategory').on('change', function (e) {
                var catVal = $('#seachByCategory').select2("val");
                @this.set('ql_search_category', catVal);
            });
            $('#seachBySubCategory').on('change', function (e) {
                var subCatVal = $('#seachBySubCategory').select2("val");
                @this.set('ql_search_subcategory', subCatVal);
            });
            $('#seachByBrand').on('change', function (e) {
                var BrandVal = $('#seachByBrand').select2("val");
                @this.set('ql_search_brand', BrandVal);
            });
        });
    });

    

</script>

<!-- Signature Script -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/signature_pad@3.0.0-beta.3/dist/signature_pad.umd.min.js"></script>

<script type="text/javascript">
window.addEventListener('showSignature',event=>{
    $('#customerSignatureModal').modal('show');
    var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
        backgroundColor: 'rgba(255, 255, 255, 0)',
        penColor: 'rgb(0, 0, 0)'
    });
    var saveButton = document.getElementById('saveSignature');
    var cancelButton = document.getElementById('clearSignature');
    saveButton.addEventListener('click', function (event) {
        var data = signaturePad.toDataURL('image/png');
        console.log(data);
        @this.set('customerSignature', data);
        $('#customerSignatureModal').modal('hide');
        // Send data to server instead...
        //window.open(data);
    });
    cancelButton.addEventListener('click', function (event) {
        signaturePad.clear();
    });

    

});

window.addEventListener('imageUpload',event=>{
    $(document).ready(function(e) {
        $(".showonhover").click(function(){
            $("#selectfile").trigger('click');
        });
    });


    var input = document.querySelector('input[type=file]'); // see Example 4

    input.onchange = function () {
        var file = input.files[0];

        drawOnCanvas(file);   // see Example 6
        displayAsImage(file); // see Example 7
    };

    function drawOnCanvas(file) {
        var reader = new FileReader();

        reader.onload = function (e) {
        var dataURL = e.target.result,
        c = document.querySelector('canvas'), // see Example 4
        ctx = c.getContext('2d'),
        img = new Image();

        img.onload = function() {
        c.width = img.width;
        c.height = img.height;
        ctx.drawImage(img, 0, 0);
        };

        img.src = dataURL;
        };

        reader.readAsDataURL(file);
    }

    function displayAsImage(file) {
        var imgURL = URL.createObjectURL(file),
        img = document.createElement('img');

        img.onload = function() {
        URL.revokeObjectURL(imgURL);
        };

        img.src = imgURL;
        
        //document.body.appendChild(img);
    }

    $("#upfile1").click(function () {
        $("#file1").trigger('click');
    });
    $("#upfile2").click(function () {
        $("#file2").trigger('click');
    });
    $("#upfile3").click(function () {
        $("#file3").trigger('click');
    });
    $("#upfile4").click(function () {
        $("#file4").trigger('click');
    });
    $("#upfile5").click(function () {
        $("#file5").trigger('click');
    });
    $("#upfile6").click(function () {
        $("#file6").trigger('click');
    });

});
</script>
@endpush