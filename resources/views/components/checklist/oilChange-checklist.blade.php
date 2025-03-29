<div class="row">
    
    @foreach(config('global.check_list.oilChange.checklist.types') as $chTypeKey => $types)
        <h2 class="mb-0 mt-2 text-sm text-left">{{$types['title']}}</h2>
        @if($types['show_inner_section'])
            @foreach($types['subtypes'] as $chSubTypeKey => $subtype_list)
            <div class="col-md-6 px-1">
                <h3 class="mb-0 text-sm text-center">{{$subtype_list['name']}}</h3>
                <hr class="horizontal dark mt-0 mb-1">
                @foreach($subtype_list['inner_sections'] as $chSubTypeDtlkey => $subtypesdetails)
                    <div class="form-check ps-0">
                        <div class="card mb-2">
                            <div class="card-header p-2 pb-0">
                                <label class="custom-control-label" for="check{{$chTypeKey}}{{$chSubTypeKey}}{{$chSubTypeDtlkey}}">{{$subtypesdetails}}</label>
                            </div>
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="radio" wire:model="checklists.oilchange.{{$chTypeKey}}.{{$chSubTypeKey}}.{{$chSubTypeDtlkey}}" value="G" id="check{{$chTypeKey}}{{$chSubTypeKey}}{{$chSubTypeDtlkey}}G">
                                            <label class="custom-control-label" for="check{{$chTypeKey}}{{$chSubTypeKey}}{{$chSubTypeDtlkey}}G">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="radio" wire:model="checklists.oilchange.{{$chTypeKey}}.{{$chSubTypeKey}}.{{$chSubTypeDtlkey}}" value="NG" id="check{{$chTypeKey}}{{$chSubTypeKey}}{{$chSubTypeDtlkey}}NG">
                                            <label class="custom-control-label" for="check{{$chTypeKey}}{{$chSubTypeKey}}{{$chSubTypeDtlkey}}NG">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="radio" wire:model="checklists.oilchange.{{$chTypeKey}}.{{$chSubTypeKey}}.{{$chSubTypeDtlkey}}" value="NA" id="check{{$chTypeKey}}{{$chSubTypeKey}}{{$chSubTypeDtlkey}}NA">
                                            <label class="custom-control-label" for="check{{$chTypeKey}}{{$chSubTypeKey}}{{$chSubTypeDtlkey}}NA">Not Applicable</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-6 px-1 mb-4">
                <div class="form-group h-100 mb-2" style="display: grid;">
                    <textarea class="form-control" id="textArea{{$chTypeKey}}{{$chSubTypeKey}}" wire:model="checklist_comments.{{$chSubTypeKey}}" rows="3" placeholder="{{$subtype_list['name']}} Comments"></textarea>
                </div>
            </div>
            @endforeach
        @else
            @foreach($types['subtypes'] as $chSubTypeKey => $subtype_list)
                <div class="col-md-6 px-1">
                    <div class="form-check ps-0">
                        <div class="card mb-2">
                            <div class="card-header p-2 pb-0">
                                <label class="custom-control-label" for="check{{$chTypeKey}}{{$chSubTypeKey}}">{{$subtype_list}}</label>
                            </div>
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="radio" wire:model="checklists.oilchange.{{$chTypeKey}}.{{$chSubTypeKey}}" value="G" id="check{{$chTypeKey}}{{$chSubTypeKey}}G">
                                            <label class="custom-control-label" for="check{{$chTypeKey}}{{$chSubTypeKey}}G">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="radio" wire:model="checklists.oilchange.{{$chTypeKey}}.{{$chSubTypeKey}}" value="NG" id="check{{$chTypeKey}}{{$chSubTypeKey}}NG">
                                            <label class="custom-control-label" for="check{{$chTypeKey}}{{$chSubTypeKey}}NG">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="radio" wire:model="checklists.oilchange.{{$chTypeKey}}.{{$chSubTypeKey}}" value="NA" id="check{{$chTypeKey}}{{$chSubTypeKey}}NA">
                                            <label class="custom-control-label" for="check{{$chTypeKey}}{{$chSubTypeKey}}NA">Not Applicable</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 px-1 mb-2">
                    <div class="form-group h-100 mb-2" style="display: grid;">
                        <textarea class="form-control" id="textArea{{$chTypeKey}}{{$chSubTypeKey}}" wire:model="checklist_comments.{{$chSubTypeKey}}" rows="3" placeholder="{{$subtype_list}} Comments"></textarea>
                    </div>
                </div>
            @endforeach

        @endif
    @endforeach
</div>
