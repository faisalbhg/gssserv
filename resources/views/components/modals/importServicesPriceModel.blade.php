<style>
    .modal{
        z-index: 9999999 !important;
    }
    .swal-overlay {
        z-index: 99999999 !important;
    }
</style>
<!-- Modal -->
<div wire:ignore.self  class="modal fade bd-example-modal-lg" id="importServicesPriceModel" tabindex="-1" role="dialog" aria-labelledby="importServicesPriceModelLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        
        <div class="modal-header">
            <h5 class="modal-title" id="importServicesPriceModelLabel">Import Service Prices</h5>
            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
            <div class="modal-body">

                <div class="row">
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12  col-sm-12 col-xs-12 col-xxs-12">
                        <div class="card p-0 m-0" >
                            <div class="card-header m-2 p-2">
                                @if($isUploaded)
                                <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
                                    <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                    <span class="alert-text"><strong>Success!</strong> Imported Successfully..! </span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                @endif

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <form  autocomplete="off" wire:submit.prevent="storeUserData" method="POST"  enctype="multipart/form-data">
                                                <div class="col-md-12 mb-3">
                                                    <span wire:click="downloadExcelTemplate" class="cursor-pointer btn-sm badge bg-gradient-dark">Download Excel Template</span>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="nameInput">File</label>
                                                        <div class="input-group mb-0">
                                                            <input type="file" name="file" wire:model="excelFile" class="form-control">
                                                        </div>
                                                        @error('file') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                     <p class="text-sm text-black">
                                                        {{ $fileName }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        xls, xlsx, csv up to 10MB
                                                    </p>
                                                </div>
                                                
                                            
                                                
                                                <input type="hidden" wire:model="user_id" name="user_id">
                                                <button type="button" class="btn bg-gradient-warning" wire:click="SubmitImport()">Submit</button>
                                                <div wire:loading wire:target="SubmitImport">
                                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                        <div class="la-ball-beat">
                                                            <div></div>
                                                            <div></div>
                                                            <div></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-primary">Submit</button> -->
            </div>
        
    </div>
  </div>
</div>

