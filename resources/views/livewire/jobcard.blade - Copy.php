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
    .right{
      direction: rtl;
    }
    .right li{
        list-style: arabic-indic;
    }
    .left li{
        list-style: binary;
    }
    
    

    .imagediv {
    float:left;
    margin-top:50px;
}
.imagediv .showonhover {
    background:red;
    padding:20px;
    opacity:0.9;
    color:white;
    width: 100%;
    display:block;  
    text-align:center;
    cursor:pointer;
}
</style>

<!-- Signature Pad Style -->
<style type="text/css">
    .wrapper {
      position: relative;
      width: 450px;
      height: 200px;
      -moz-user-select: none;
      -webkit-user-select: none;
      -ms-user-select: none;
      user-select: none;
      /*boreder:1px solid #000;
      border-radius: 13px;*/
    }

    .signature-pad {
      position: absolute;
      left: 0;
      top: 0;
      width:400px;
      height:200px;
    }

    .wrapper1 {
      position: relative;
      height:500px;
      -moz-user-select: none;
      -webkit-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    .signature-pad1 {
      position: absolute;
      left: 0;
      top: 0;
      
    }


</style>
<!-- End Signature Pad Style -->

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
                <div class="px-2 d-none">
                    <button wire:click="clickSearchBy('3')" class="btn @if($searchByChaisis) bg-gradient-primary @else bg-gradient-default @endif mb-0" data-toggle="modal" data-target="#new-board-modal">
                        Chaisis Number
                    </button>
                </div>
            </div>
        </div>
        @endif

        @if($selectedCustomerVehicle)
        <div class="row">
            <div class="col-md-12 my-2">
                <div class="card card-profile card-plain">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="javascript:;">
                                <div class="position-relative">
                                    <div class="blur-shadow-image">
                                        <img class="w-100 rounded-3 shadow-lg" src="{{url('storage/'.$selectedVehicleInfo['vehicle_image'])}}">
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-8 ps-0 my-auto">
                            <div class="card-body text-left">
                                <div class="p-md-0 pt-3">
                                    <h5 class="font-weight-bolder mb-0">{{$selectedVehicleInfo['name']}}</h5>
                                    <p class="text-sm font-weight-bold mb-2 text-capitalize"> - {{strtolower(str_replace("_"," ",$selectedVehicleInfo['customerType']))}}</p>
                                </div>
                                <p class="mb-4"><b>Vehicle:</b> {{$selectedVehicleInfo['vehicleName']}}, {{$selectedVehicleInfo['model']}}
                                    <br>
                                    <b>Plate Number:</b> {{$selectedVehicleInfo['plate_number_final']}}</p>
                                <p class="mb-4"><b>Chaisis:</b> {{$selectedVehicleInfo['chassis_number']}}
                                    <br>
                                    <b>KM Reading:</b> {{$selectedVehicleInfo['vehicle_km']}}</p>
                                
                                <button type="button" class="btn bg-gradient-primary btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Customer/Discount/Vehicle" data-container="body" data-animation="true" wire:click="editCustomer()"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button type="button" class="btn bg-gradient-primary btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Customer/Discount/Vehicle" data-container="body" data-animation="true" wire:click="addNewVehicle({{$customer_id}})"><i class="fa-solid fa-square-plus"></i></button>
                                <button type="button" class="d-none btn btn-danger btn-simple btn-lg mb-0 px-2">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="row">
        @if($newcustomeoperation)
        @include('components.newcustomeoperation')
        @endif
        </div>

        <!-- components.modals.servicemodel -->
        <!--include('components.plugins.fixed-plugin')-->
        @include('components.modals.customerSignatureModel')
        @if($markCarScratch)
        @include('components.modals.serviceCarImageEdit')
        @endif
        

        @if($showSearchModelView)
        @include('components.modals.newCarSearchOperation')
        @endif
        
    </div>
</main>

@push('custom_script')

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


window.addEventListener('loadCarImage',event=>{
    $('#serviceCarImageModal').modal('show');
    var imageUrl = $('#'+event.detail.imgId).attr('src');
    $("#carImagePad").attr("src",imageUrl);

$(document).ready(function() {
  initialize(imageUrl);
});



// works out the X, Y position of the click inside the canvas from the X, Y position on the page

function getPosition(mouseEvent, sigCanvas) {
    var rect = sigCanvas.getBoundingClientRect();
    return {
      X: mouseEvent.clientX - rect.left,
      Y: mouseEvent.clientY - rect.top
    };
}

/*function getPosition(mouseEvent, sigCanvas) {
  var x, y;
  if (mouseEvent.pageX != undefined && mouseEvent.pageY != undefined) {
    x = mouseEvent.pageX;
    y = mouseEvent.pageY;

  } else {
    x = mouseEvent.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
    y = mouseEvent.clientY + document.body.scrollTop + document.documentElement.scrollTop;
  }

  return {
    X: x - sigCanvas.offsetLeft,
    Y: y - sigCanvas.offsetTop
  };
}*/

function initialize(imageUrl) {
  // get references to the canvas element as well as the 2D drawing context
  var sigCanvas = document.getElementById("canvas");
  var context = sigCanvas.getContext("2d");
  context.strokeStyle = "#f53939";
  context.lineJoin = "round";
  context.lineWidth = 10;

  


    //apply width and height for canvas
        const  getMeta = (url, cb) => {
            const  img = new Image();
            img.onload = () => cb(null, img);
            img.onerror = (err) => cb(err);
            img.src = url;
        };

        // Use like:
        getMeta(imageUrl, (err, img) => {
            sigCanvas.width = img.naturalWidth     // 350px
            sigCanvas.height = img.naturalHeight    // 200px
            
        });



  // Add background image to canvas - remove for blank white canvas
  var background = new Image();
  background.src = imageUrl;
  // Make sure the image is loaded first otherwise nothing will draw.
  background.onload = function() {
    context.drawImage(background, 0, 0);
  }

  


  // This will be defined on a TOUCH device such as iPad or Android, etc.
  var is_touch_device = 'ontouchstart' in document.documentElement;

  if (is_touch_device) {
    // create a drawer which tracks touch movements
    var drawer = {
      isDrawing: false,
      touchstart: function(coors) {
        context.beginPath();
        context.moveTo(coors.x, coors.y);
        this.isDrawing = true;
      },
      touchmove: function(coors) {
        if (this.isDrawing) {
          context.lineTo(coors.x, coors.y);
          context.stroke();
        }
      },
      touchend: function(coors) {
        if (this.isDrawing) {
          this.touchmove(coors);
          this.isDrawing = false;
        }
      }
    };

    // create a function to pass touch events and coordinates to drawer
    function draw(event) {

      // get the touch coordinates.  Using the first touch in case of multi-touch
      var coors = {
        x: event.targetTouches[0].pageX,
        y: event.targetTouches[0].pageY
      };

      // Now we need to get the offset of the canvas location
      var obj = sigCanvas;

      if (obj.offsetParent) {
        // Every time we find a new object, we add its offsetLeft and offsetTop to curleft and curtop.
        do {
          coors.x -= obj.offsetLeft;
          coors.y -= obj.offsetTop;
        }
        // The while loop can be "while (obj = obj.offsetParent)" only, which does return null
        // when null is passed back, but that creates a warning in some editors (i.e. VS2010).
        while ((obj = obj.offsetParent) != null);
      }

      // pass the coordinates to the appropriate handler
      drawer[event.type](coors);

    }

    // attach the touchstart, touchmove, touchend event listeners.
    sigCanvas.addEventListener('touchstart', draw, false);
    sigCanvas.addEventListener('touchmove', draw, false);
    sigCanvas.addEventListener('touchend', draw, false);

    // prevent elastic scrolling
    sigCanvas.addEventListener('touchmove', function(event) {
      event.preventDefault();
    }, false);
  } else {

    // start drawing when the mousedown event fires, and attach handlers to
    // draw a line to wherever the mouse moves to
    $("#canvas").mousedown(function(mouseEvent) {
      var position = getPosition(mouseEvent, sigCanvas);
      context.moveTo(position.X, position.Y);
      context.beginPath();

      // attach event handlers
      $(this).mousemove(function(mouseEvent) {
        drawLine(mouseEvent, sigCanvas, context);
      }).mouseup(function(mouseEvent) {
        finishDrawing(mouseEvent, sigCanvas, context);
      }).mouseout(function(mouseEvent) {
        finishDrawing(mouseEvent, sigCanvas, context);
      });
    });

  }
}

// draws a line to the x and y coordinates of the mouse event inside
// the specified element using the specified context
function drawLine(mouseEvent, sigCanvas, context) {

  var position = getPosition(mouseEvent, sigCanvas);

  context.lineTo(position.X, position.Y);
  context.stroke();
}

// draws a line from the last coordiantes in the path to the finishing
// coordinates and unbind any event handlers which need to be preceded
// by the mouse down event
function finishDrawing(mouseEvent, sigCanvas, context) {
    var base64Canvas = '';
  // draw the line to the finishing coordinates
  drawLine(mouseEvent, sigCanvas, context);

  context.closePath();

  // unbind any events which could draw
  $(sigCanvas).unbind("mousemove")
    .unbind("mouseup")
    .unbind("mouseout");

    var sigCanvas = document.getElementById("canvas");
    var base64Canvas = sigCanvas.toDataURL("image/jpeg");
    console.log(event.detail.imgId);
    $('#'+event.detail.imgId).attr('src',base64Canvas);
    //$('#serviceCarImageModal').modal('hide');
}

// Clear the canvas context using the canvas width and height
function clearCanvas(canvas, ctx) {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
}
    
    
});

window.addEventListener('hideCarScratchImageh',event=>{
    $('#serviceCarImageModal').modal('hide');
});
</script>
<!-- End Signature Script-->


<script type="text/javascript">
    window.addEventListener('openServicesListModal',event=>{
        $('#servicePriceModal').modal('show');
    });
    window.addEventListener('closeServicesListModal',event=>{
        $('#servicePriceModal').modal('hide');
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">

    
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
    });
});
window.addEventListener('show-serviceModel',event=>{
    $('#serviceModel').modal('show');
});
window.addEventListener('hide-serviceModel',event=>{
    $('#serviceModel').modal('hide');
});

window.addEventListener('show-searchNewVehicle',event=>{
    $('#searchNewVehicleModal').modal('show');
});
window.addEventListener('hide-searchNewVehicle',event=>{
    $('#searchNewVehicleModal').modal('hide');
});


</script>


@endpush