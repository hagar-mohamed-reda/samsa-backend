
<div class="card material-shadow " >
    <div class="w3-border-bottom w3-border-light-gray w3-padding" >
        <div class="w3-margin-right w3-xlarge" ><i class="fa fa-angle-double-left" style="margin-left: 5px" ></i>{{ __('filter') }}</div>
    </div>
    <div class="card-body filter" style="display: none" > 
        <form  method="get" action="" >
            <div class="row" >  

                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="form-group">
                        <div class="controls">
                            <label class="label-r" for="level_id">{{ __('store') }}</label>
                            {!! Form::select('store_id',\Modules\Account\Entities\Store::select('*', DB::raw('CONCAT(name, " > ", FORMAT(balance, 2), " EGP") as title'))->pluck('title','id'),null,['class'=>'custom-select select2','id'=>'customSelect', '', 'placeholder' => __('select all') ])!!} 
            
                        </div>
                    </div>
                </div> 
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="form-group">
                        <div class="controls">
                            <label class="label-r" for="user_id">{{ __('expense_maincategorys') }}</label>
                            {!! Form::select('expenses_maincategory_id',\Modules\Account\Entities\ExpenseMainCategory::select('*', DB::raw('(CONCAT(name, "[", FORMAT(value, 2), "]" )) as title'))->pluck('title','id'),null,['class'=>'custom-select select2','id'=>'customSelect', 'placeholder' => __('select all') ])!!}
                        </div>
                    </div>
                </div>



                <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('search') }}</button>
                    <a role="button" href="{{ route('expense_subcategorys.index') }}" class="btn btn-danger waves-effect waves-light">{{ __('select all') }}</a>
                </div>
            </div>
        </form>
    </div>
</div>