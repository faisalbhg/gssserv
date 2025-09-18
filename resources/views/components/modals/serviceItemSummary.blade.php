<!-- Modal -->
            <style type="text/css">
                .modal-body{
                    max-height: calc(100vh - 300px);
                    overflow-y: auto;
                }
            </style>
            <div class="modal fade" id="serviceItemSummaryModal" tabindex="-1" role="dialog" aria-labelledby="servicePriceModalLabel" aria-hidden="true" wire:ignore.self style="z-index:99999;" >
                <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:90%;">
                    <div class="modal-content">
                        
                        <div class="modal-header">
                            <h5 class="modal-title" id="serviceItemSummaryModalLabel">{{$serviceSectionSelected}}</h5>
                            <button type="button" class="btn-close text-dark " style="font-size: 2.125rem !important;" data-bs-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true" class="text-xl">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body py-0">
                            <div class="row">
                                @forelse($serviceItemSummaryLists as $serviceItem)
                                    
                                    <div class="col-md-6 col-sm-6">
                                        
                                        <div class="bg-gray-100 shadow my-3 p-2">
                                            <div class="row">
                                                <div class="col-12">
                                                    
                                                    <div class="d-flex border-radius-lg p-0 mt-2">
                                                        <p class="text-sm text-center font-weight-bold text-dark">
                                                        @if($serviceItem->serviceMaster!=null)
                                                        {{$serviceItem->serviceMaster['ItemName']}}- {{$serviceItem->serviceMaster['ItemCode']}}
                                                        @else
                                                        {{$serviceItem->itemMaster['ItemName']}} - {{$serviceItem->itemMaster['ItemCode']}}
                                                        @endif
                                                    </p>
                                                        <a href="javascript:;" class="btn bg-outline-primary mb-0 ms-auto btn-sm" >{{$serviceItem->order_count}}</a>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                                
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" class="btn bg-gradient-primary">Save changes</button> -->
                        </div>
                    </div>
                </div>
            </div>