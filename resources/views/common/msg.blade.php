<div style="margin-top: 3px" id="common">
    @if(session()->has('info'))
        <div class="alert alert-info alert-dismissable">
            <i class="fa fa-info-circle"></i> 
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>    
             {{ session('info') }}
        </div>
    @endif
    
    @if(session()->has('warning'))
        <div class="alert alert-warning alert-dismissable">
            <i class="fa fa-warning"></i> 
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>    
             {{ session('warning') }}
        </div>
    @endif
    
    @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-times-circle"></i> 
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>    
             {{ session('error') }}
        </div>
    @endif

</div>
