
<!-- Modal -->
<div wire:ignore.self  class="modal fade bd-example-modal-lg" id="sectionModel" tabindex="-1" role="dialog" aria-labelledby="sectionModelLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        
        <div class="modal-header">
            <h5 class="modal-title" id="sectionModelLabel">{{$sectionTitle}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
            <div class="modal-body">

                <div class="row">
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12  col-sm-12 col-xs-12 col-xxs-12">
                        <div class="card p-0 m-0" >
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <form  autocomplete="off" wire:submit.prevent="manageDepartment" method="POST"  enctype="multipart/form-data">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="sectionCodeInput">Section Code</label>
                                                    <div class="input-group mb-0">
                                                        <input class="form-control" placeholder="Section Code" type="text" wire:model="section_code" name="section_code" id="sectionCodeInput">
                                                    </div>
                                                    @error('section_code') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group openDiv">
                                                    <label for="sectionNameInput">Section Name</label>
                                                    <input type="text" class="form-control" wire:model="section_name" name="section_name" placeholder="Section Name" id="sectionNameInput">
                                                    @error('section_name') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group openDiv">
                                                    <label for="sectionDescriptionInput">Section Description</label>
                                                    <input type="text" class="form-control" wire:model="section_description" name="section_description" placeholder="Section Name" id="sectionDescriptionInput">
                                                    @error('section_description') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group openDiv">
                                                    <label for="isActiveSelect">is Active</label>
                                                    <select class="form-control" wire:model="is_active" name="is_active" id="isActiveSelect">
                                                        <option value="">-Select-</option>
                                                        <option @if($is_active==1) selected @endif value="1">Active</option>
                                                        <option @if($is_active==0) selected @endif value="0">Dissable</option>
                                                    </select>
                                                    @error('is_active') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>

                                            <input type="hidden" wire:model="section_id">
                                            <button wire:click="manageSection()" type="button" class="btn bg-gradient-warning">Save</button>
                                            
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

