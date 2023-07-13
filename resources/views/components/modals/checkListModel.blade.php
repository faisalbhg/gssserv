
<!-- Modal -->
<div wire:ignore.self  class="modal fade bd-example-modal-lg" id="checkListModel" tabindex="-1" role="dialog" aria-labelledby="checkListModelLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        
        <div class="modal-header">
            <h5 class="modal-title" id="checkListModelLabel">{{$title}}</h5>
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
                                            <form  autocomplete="off" wire:submit.prevent="saveCheckList" method="POST"  enctype="multipart/form-data">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="stationCodeInput">Check List Label</label>
                                                    <div class="input-group mb-0">
                                                        <input class="form-control" placeholder="Checklist Label" type="text" wire:model="checklist_label" name="checklist_label" id="checklistLabelInput">
                                                    </div>
                                                    @error('checklist_label') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="stationSelect">Service Group</label>
                                                    <select class="form-control" id="service_group_id" wire:model="service_group_id">
                                                        <option value="">-Select-</option>
                                                        @foreach($service_group as $group)
                                                        <option @if($group->id==$service_group_id) selected @endif value="{{$group->id}}">{{$group->service_group_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('service_group_id') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            <input type="hidden" wire:model="checklist_id">
                                            <button wire:click="updateCheckList()" type="button" class="btn bg-gradient-warning">Save</button>
                                            
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

