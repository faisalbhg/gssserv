<main class="main-content">
    <div class="container-fluid py-4">
        <div class="row ">
            <div class="col-12">
                <div class="card mb-4 p-4">
                    <div class="card-header p-0">
                        <h5 class="modal-title" id="serviceUpdateModalLabel">
                            <span class="float-start badge badge-lg {{config('global.payment.status_class')[$payment_status]}}"> #{{$job_number}} - {{config('global.payment.status')[$payment_status]}}</span>
                        </h5>
                    </div>
                    
                    <div class="card-body px-0 pt-0 pb-2 ">
                        <div class="row">
                            <div class="col-md-12 mt-0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-profile card-plain p-2">
                                            <div class="row">
                                                <div class="col-xxs-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                    <a href="javascript:;">
                                                        <div class="position-relative">
                                                        <div class="blur-shadow-image">
                                                            <img class="w-100 rounded-3 shadow-lg" src="{{url('public/storage/'.$vehicle_image)}}">
                                                        </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-xxs-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                    <div class="card-body text-left">
                                                        

                                                       <div class="row ">
                                                            <table border="0" class="table align-items-center justify-content-center mb-0">
                                                                <tr>
                                                                    <td><h6>Payment: </h6></td>
                                                                    <td>
                                                                        <span class="badge badge-sm {{config('global.payment.status_class')[$payment_status]}}"> {{config('global.payment.status')[$payment_status]}}</span>
                                                                         <p class="text-sm text-gradient {{config('global.payment.text_class')[$payment_type]}}  font-weight-bold mb-0">{{config('global.payment.type')[$payment_type]}}</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                    <h6>Job Status:</h6>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge badge-sm {{config('global.job_status_text_class')[$job_status]}}">{{config('global.job_status')[$job_status]}}</span>

                                                                        <div class="d-flex align-items-center justify-content-center">
                                                                        <span class="me-2 text-xs font-weight-bold">{{config('global.status_perc')[$job_status]}}</span>
                                                                        <div>
                                                                        <div class="progress">
                                                                        <div class="progress-bar {{config('global.status_perc_class')[$job_status]}}" role="progressbar" aria-valuenow="{{config('global.status_perc')[$job_status]}}" aria-valuemin="0" aria-valuemax="100" style="width: {{config('global.status_perc')[$job_status]}};"></div>
                                                                        </div>
                                                                        </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <hr class="horizontal dark mt-3">
                                                            <button type="button" class="btn btn-dark">
                                                                <h5 class="font-weight-bolder mb-0">{{$make}}</h5>
                                                                <p class="text-sm font-weight-bold mb-0">{{$model}} ({{$plate_number}})</p>
                                                                <p class="text-sm mb-0">Chassis Number: {{$chassis_number}}</p>
                                                                <p class="text-sm mb-3">K.M Reading: {{$vehicle_km}}</p>
                                                            </button>
                                                            <hr class="horizontal dark mt-3">
                                                            <button type="button" class="btn btn-outline-dark">
                                                                <p class="text-sm mb-0">Name: {{$name}}</p>
                                                                <p class="text-sm mb-0">Mobile: <a href="tel:{{$mobile}}">{{$mobile}}</a></p>
                                                                <p class="text-sm mb-0">Email: {{$email}}</p>
                                                            </button>
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
                </div>
            </div>
        </div>
    </div>
</main>

