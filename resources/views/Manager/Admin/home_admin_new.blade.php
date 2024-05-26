@extends('layouts.layoutmaster')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header mx-4 p-3 text-center">
                            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg"
                                style=" background-image: linear-gradient(310deg, #51068f 0%, #9355e4 100%);">
                                <i class="fa fa-user-astronaut opacity-10"></i>
                            </div>
                        </div>
                        <div class="card-body pt-0 p-3 text-center">
                            <h6 class="text-center mb-0">ADMIN (MANAGER)</h6>
                            <span class="text-xs">This is the person who manages the entire yard and website</span>
                            <hr class="horizontal dark my-3">
                            <h5 class="mb-0"> <i class="fa fa-user-astronaut opacity-10"></i> : <strong
                                    style="color:red">{{ $adminCount }}</strong></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-md-0 mt-4">
                    <div class="card">
                        <div class="card-header mx-4 p-3 text-center">
                            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg"
                                style=" background-image: linear-gradient(310deg, #fce042 0%, #97970c 100%);">
                                <i class="fa fa-newspaper opacity-10"></i>
                            </div>
                        </div>
                        <div class="card-body pt-0 p-3 text-center">
                            <h6 class="text-center mb-0">SCHEDULING FORM</h6>
                            <span class="text-xs">These are customer yard orders</span>
                            <hr class="horizontal dark my-3">
                            <h5 class="mb-0"> <i class="fa fa-newspaper opacity-10"></i> : <strong
                                    style="color:red">{{ $schedulingCount }}</strong></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12" style="margin-top:20px;">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header mx-4 p-3 text-center">
                            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg"
                                style=" background-image: linear-gradient(310deg, #105521 0%, #84eb51 100%);">
                                <i class="fa fa-user opacity-10"></i>
                            </div>
                        </div>
                        <div class="card-body pt-0 p-3 text-center">
                            <h6 class="text-center mb-0">CUSTOMERS</h6>
                            <span class="text-xs">These are the people who rent the ballpark</span>
                            <hr class="horizontal dark my-3">
                            <h5 class="mb-0"> <i class="fa fa-user opacity-10"></i> : <strong
                                    style="color:red">{{ $customerCount }}</strong></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-md-0 mt-4">
                    <div class="card">
                        <div class="card-header mx-4 p-3 text-center">
                            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg"
                                style=" background-image: linear-gradient(310deg, #ed6161 0%, #ac0606 100%);">
                                <i class="fas fa-futbol opacity-10"></i>
                            </div>
                        </div>
                        <div class="card-body pt-0 p-3 text-center">
                            <h6 class="text-center mb-0">PITCH</h6>
                            <span class="text-xs">These are the existing football fields</span>
                            <hr class="horizontal dark my-3">
                            <h5 class="mb-0"> <i class="fas fa-futbol opacity-10"></i> : <strong
                                    style="color:red">{{ $pitchCount }}</strong></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
