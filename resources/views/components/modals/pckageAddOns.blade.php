<style>
    .modal-dialog {
        max-width: 90%;
    }
    .modal{
        z-index: 99999;
    }
</style>

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="pckageAddOnsModal" tabindex="-1" role="dialog" aria-labelledby="pckageAddOnsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header" style="display:inline !important;">
                <div class="d-sm-flex justify-content-between">
                    <div>
                      <h5 class=" modal-title" id="pckageAddOnsModalLabel">Package Addons</h5>
                    </div>
                    <div class="d-flex">
                      <button wire:click="addNewItemsToPackage()" type="button" class="btn bg-gradient-primary btn-sm mb-0 float-end">Add New Package Items</button>
                      <a  class="cursor-pointer" data-bs-dismiss="modal"><i class="text-danger fa-solid fa-circle-xmark fa-xxl" style="font-size:2rem;"></i></a>
                    </div>
                </div>
                
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card h-100">
                            <div class="card-header pb-0 p-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-0">{{$selectedPackage['PackageName']}}</h6>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end align-items-center">
                                        <i class="far fa-calendar-alt me-2" aria-hidden="true"></i>
                                        <small>Duration: {{$selectedPackage['Duration']}} Months<br>{{$selectedPackage['PackageKM']}} K.M</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <?php $totalPrice=0;?>
                                <?php $unitPrice=0;?>
                                <?php $discountedPrice=0;?>
                                <ul class="list-group">
                                    @foreach($selectedPackageItems as $packageDetails)
                                    <?php $totalPrice = $totalPrice+$packageDetails['TotalPrice']; ?>
                                    <?php $unitPrice = $unitPrice+$packageDetails['UnitPrice']; ?>
                                    <?php $discountedPrice = $discountedPrice+$packageDetails['DiscountedPrice']; ?>
                                    <li class="list-group-item border-0 justify-content-between ps-0 pb-0 border-radius-lg">
                                        <div class="d-flex">
                                            <div class="d-flex align-items-center">
                                                @if($packageDetails['isDefault']==1)
                                                <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center">
                                                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                                                </button>
                                                @else
                                                <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-arrow-down" aria-hidden="true"></i>
                                                </button>
                                                @endif
                                                <div class="d-flex flex-column">
                                                    @if($packageDetails['ItemType']=='S')
                                                    <h6 class="mb-1 text-dark text-sm">{{$packageDetails['labour_item_details']['ItemName']}}</h6>
                                                    <span class="text-xs">{{$packageDetails['ItemCode']}}</span>
                                                    @else
                                                    <h6 class="mb-1 text-dark text-sm">{{$packageDetails['inventory_item_details']['ItemName']}}</h6>
                                                    <span class="text-xs">{{$packageDetails['ItemCode']}}</span>
                                                    @endif
                                                </div>
                                                
                                                
                                                
                                                
                                            </div>
                                            <div class="d-flex align-items-center text-danger text-sm font-weight-bold ms-auto">
                                            <del class="text-secondary me-2">AED {{round($packageDetails['UnitPrice'],2)}}</del>  AED {{round($packageDetails['DiscountedPrice'],2)}}
                                            </div>
                                        </div>
                                        <hr class="horizontal dark mt-3 mb-2">
                                    </li>
                                    @endforeach
                                </ul>
                                <p class="text-center h4"><s><small>AED</small> {{$unitPrice}}</s> <small>AED</small> {{$discountedPrice}}</p>
                            </div>
                            <div class="card-footer">
                                <div class="flex-column">
                                     <div class="text-center align-center">
                                        <a href="javascript:;" class="btn btn-icon bg-gradient-success mt-3 mb-0 " wire:click="subscribePackage()">Subscribe<i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
       </div>
    </div>
</div>
