<div class="row">
    <div class="col-12 col-md-12 col-xl-6 my-4">
        <div class="card">
            <div class="card-header text-center pt-4 pb-3">
                <h5 class="font-weight-bold mt-2">Vehicle Sides Images</h5>
            </div>
            
            
            <div class="card-body text-left pt-0">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <input type="file" id="img1File" wire:model="checklists.vehicleImages.vImageR1Cl1" accept="image/*" capture style="display:block"/>
                        <img class="w-75 float-end" id="img1" src="{{asset('img/checklist/car1.png')}}" style="cursor:pointer" wire:click="markScrach('img1')" />
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <input type="file" id="img2File" wire:model="checklists.vehicleImages.vImageR2Cl1" accept="image/*" capture style="display:block"/>
                        <img class="w-75 float-start" id="img2" src="{{asset('img/checklist/car2.png')}}" style="cursor:pointer" wire:click="markScrach('img2')" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <input type="file" id="vImageFFile" wire:model="checklists.vehicleImages.vImageFCl1" accept="image/*" capture style="display:block"/>
                        <img class="w-75 float-end" id="img3" src="{{asset('img/checklist/car3.jpg')}}" style="cursor:pointer" wire:click="markScrach('img3')" />
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <input type="file" id="vImageBFile" wire:model="checklists.vehicleImages.vImageBCl1" accept="image/*" capture style="display:block"/>
                        <img class="w-75 float-start" id="img4" src="{{asset('img/checklist/car4.jpg')}}" style="cursor:pointer" wire:click="markScrach('img4')" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <input type="file" id="vImageL1File" wire:model="checklists.vehicleImages.vImageL1Cl1" accept="image/*" capture style="display:block"/>
                        <img class="w-75 float-end" id="img5" src="{{asset('img/checklist/car5.png')}}" style="cursor:pointer" wire:click="markScrach('img5')" />
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <input type="file" id="vImageL2File" wire:model="checklists.vehicleImages.vImageL2Cl1" accept="image/*" capture style="display:block"/>
                        <img class="w-75 float-start" id="img6" src="{{asset('img/checklist/car6.png')}}" style="cursor:pointer" wire:click="markScrach('img6')" />
                    </div>
                </div>

                @if($jobcardDetails->is_contract==1)
                <h5 class="font-weight-bold mt-2">Interior Vehicle Images</h5>
                <div class="row m-4">
                    <div class="col-md-6 col-sm-6">
                        <input type="file" id="dashImage1File" wire:model="checklists.vehicleImages.dash_image1Cl1" accept="image/*" capture style="display:block"/>
                        <img class="img-fluid img-thumbnail shadow" id="dashImage1" src="{{asset('img/dashImage1.jpg')}}" style="cursor:pointer"  />
                        @error('dash_image1') <span class="text-danger">Missing Image..!</span> @enderror
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <input type="file" id="dashImage2File" wire:model="checklists.vehicleImages.dash_image2Cl1" accept="image/*" capture style="display:block"/>
                        <img class="img-fluid img-thumbnail shadow" id="dashImage2" src="{{asset('img/dashImage2.jpg')}}" style="cursor:pointer"  />
                        @error('dash_image2') <span class="text-danger">Missing Image..!</span> @enderror
                    </div>
                    <hr>
                </div>
                <div class="row m-4">
                    <div class="col-md-6 col-sm-6">
                        <input type="file" id="passengerSeatImageFile" wire:model="checklists.vehicleImages.passenger_seat_imageCl1" accept="image/*" capture style="display:block"/>
                        <img class="img-fluid img-thumbnail shadow" id="passengerSeatImage" src="{{asset('img/passangerSeat1.jpg')}}" style="cursor:pointer"  />
                        @error('passenger_seat_image') <span class="text-danger">Missing Image..!</span> @enderror
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <input type="file" id="driverSeatImageFile" wire:model="checklists.vehicleImages.driver_seat_imageCl1" accept="image/*" capture style="display:block"/>
                        <img class="img-fluid img-thumbnail shadow" id="driverSeatImage" src="{{asset('img/driverSeat1.jpg')}}" style="cursor:pointer"  />
                        @error('driver_seat_image') <span class="text-danger">Missing Image..!</span> @enderror
                    </div>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <input type="file" id="backSeat1ImageFile" wire:model="checklists.vehicleImages.back_seat1Cl1" accept="image/*" capture style="display:block"/>
                        <img class="img-fluid img-thumbnail shadow" id="backSeat1Image" src="{{asset('img/backSeat1.jpg')}}" style="cursor:pointer"  />
                        @error('back_seat1') <span class="text-danger">Missing Image..!</span> @enderror
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <input type="file" id="backSeat2ImageFile" wire:model="checklists.vehicleImages.back_seat2Cl1" accept="image/*" capture style="display:block"/>
                        <img class="img-fluid img-thumbnail shadow" id="backSeat2Image" src="{{asset('img/backSeat2.jpg')}}" style="cursor:pointer"   />
                        @error('back_seat2') <span class="text-danger">Missing Image..!</span> @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <input type="file" id="backSeat3ImageFile" wire:model="checklists.vehicleImages.back_seat3Cl1" accept="image/*" capture style="display:block"/>
                        <img class="img-fluid img-thumbnail shadow" id="backSeat3Image" src="{{asset('img/backSeat1.jpg')}}" style="cursor:pointer"  />
                        @error('back_seat3') <span class="text-danger">Missing Image..!</span> @enderror
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <input type="file" id="backSeat4ImageFile1" wire:model="checklists.vehicleImages.back_seat4Cl1" accept="image/*" capture style="display:block"/>
                        <img class="img-fluid img-thumbnail shadow" id="backSeat4Image1" src="{{asset('img/backSeat2.jpg')}}" style="cursor:pointer"   />
                        @error('back_seat4') <span class="text-danger">Missing Image..!</span> @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input type="file" id="backSeat3ImageFile1" wire:model="checklists.vehicleImages.roof_imagesCl1" accept="image/*" capture style="display:block"/>
                        <img class="img-fluid img-thumbnail shadow" id="backSeat3Image1" src="{{asset('img/roofimage1.jpg')}}" style="cursor:pointer"  />
                        @error('roof_images') <span class="text-danger">Missing Image..!</span> @enderror
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @foreach(config('global.check_list.interiorCleaning.checklist.types') as $chTypeKey => $types)
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
                                            <input class="form-check-input" type="radio" wire:model="checklists.interior.{{$chTypeKey}}.{{$chSubTypeKey}}.{{$chSubTypeDtlkey}}" value="G" id="check{{$chTypeKey}}{{$chSubTypeKey}}{{$chSubTypeDtlkey}}G">
                                            <label class="custom-control-label" for="check{{$chTypeKey}}{{$chSubTypeKey}}{{$chSubTypeDtlkey}}G">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="radio" wire:model="checklists.interior.{{$chTypeKey}}.{{$chSubTypeKey}}.{{$chSubTypeDtlkey}}" value="NG" id="check{{$chTypeKey}}{{$chSubTypeKey}}{{$chSubTypeDtlkey}}NG">
                                            <label class="custom-control-label" for="check{{$chTypeKey}}{{$chSubTypeKey}}{{$chSubTypeDtlkey}}NG">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="radio" wire:model="checklists.interior.{{$chTypeKey}}.{{$chSubTypeKey}}.{{$chSubTypeDtlkey}}" value="NA" id="check{{$chTypeKey}}{{$chSubTypeKey}}{{$chSubTypeDtlkey}}NA">
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
                                            <input class="form-check-input" type="radio" wire:model="checklists.interior.{{$chTypeKey}}.{{$chSubTypeKey}}" value="G" id="check{{$chTypeKey}}{{$chSubTypeKey}}G">
                                            <label class="custom-control-label" for="check{{$chTypeKey}}{{$chSubTypeKey}}G">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="radio" wire:model="checklists.interior.{{$chTypeKey}}.{{$chSubTypeKey}}" value="NG" id="check{{$chTypeKey}}{{$chSubTypeKey}}NG">
                                            <label class="custom-control-label" for="check{{$chTypeKey}}{{$chSubTypeKey}}NG">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="radio" wire:model="checklists.interior.{{$chTypeKey}}.{{$chSubTypeKey}}" value="NA" id="check{{$chTypeKey}}{{$chSubTypeKey}}NA">
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
