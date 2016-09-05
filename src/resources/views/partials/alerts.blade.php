@if(Session::has('success'))
    <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Well done!</strong> {{ Session::get('success') }}
            </div>
        </div>
    </div>
    </div>
@endif

@if(Session::has('info'))
    <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="alert alert-info alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Heads up!</strong> {{ Session::get('info') }}
            </div>
        </div>
    </div>
    </div>
@endif

@if(Session::has('warning'))
    <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Warning!</strong> {{ Session::get('warning') }}
            </div>
        </div>
    </div>
    </div>
@endif

@if(Session::has('danger'))
    <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Oh snap!</strong> {{ Session::get('danger') }}
            </div>
        </div>
    </div>
    </div>
@endif



