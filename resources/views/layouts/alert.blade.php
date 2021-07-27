@if (session('success'))
<div class="row" id="proBanner">
    <div class="col-12">
        <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
</div>
@endif
<!-- Alert Message For info -->
@if (session('info'))
<div class="row" id="proBanner">
    <div class="col-12">
        <div class="alert alert-info alert-dismissible fade show">
            {{ session('info') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
</div>
@endif
<!-- Alert Message For error -->
@if (session('error'))
<div class="row" id="proBanner">
    <div class="col-12">
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
</div>
@endif
<!-- Alert Message For warning -->
@if (session('warning'))
<div class="row" id="proBanner">
    <div class="col-12">
        <div class="alert alert-warning alert-dismissible fade show">
            {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
</div>
@endif
