<!-- Modal -->
<div wire:ignore.self class="modal fade" id="customerSignatureModal" tabindex="-1" role="dialog" aria-labelledby="customerSignatureModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content ">
             <div class="modal-body ">
                <div class="row">
                    <div class="card text-white border-0">

                        <div class="wrapper btn btn-outline-dark">
                            <!-- <img src="https://preview.ibb.co/jnW4Qz/Grumpy_Cat_920x584.jpg" width=400 height=200 /> -->
                            <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>
                            
                        </div>
                    
                    </div>
                </div>
            </div>
            <div class="modal-footer z-index-stick">
                <button type="button" class="btn bg-gradient-secondary" wire:click="closeMarkScrach()"  data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn bg-gradient-secondary" id="clearSignature" >Clear</button>
                <button type="submit" class="btn bg-gradient-primary" id="saveSignature" >Save</button>
            </div>
       </div>
    </div>
</div>
