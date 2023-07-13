<style>
    .modal-dialog {
        max-width: 100%;
    }
    .modal{
        z-index: 99999;
    }
</style>

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="serviceCarImageModal" tabindex="-1" role="dialog" aria-labelledby="serviceCarImageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content ">
            <!-- <div class="modal-header">

                <h5 class="modal-title" id="serviceCarImageModalLabel">#{{$job_number}} Update</h5>
            </div>
             -->
             <div class="modal-body ">
                <div class="row">
                    <div class="card text-white border-0">

                        <div id="iframe" class="btn btn-outline-dark">
  <canvas id="canvas" width="500px" height="500px"></canvas>
  <!-- 
  <input type="submit" value="Clear Canvas" id="clearbutton" onclick="clearCanvas(canvas,ctx);"> -->
</div>

                        <!-- <img id="carImagePad" class="card-img w-100" src="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg" alt="Card image"> -->
                    
                    </div>
                </div>
            </div>
            <div class="modal-footer z-index-stick">
                <button type="button" class="btn bg-gradient-secondary" wire:click="closeMarkScrach()"  data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn bg-gradient-secondary" id="clearM1" >Clear</button>
                <button type="submit" class="btn bg-gradient-primary" id="saveM1"  >Save</button>
            </div>
       </div>
    </div>
</div>
