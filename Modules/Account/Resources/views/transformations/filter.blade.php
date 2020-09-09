
<div class="card material-shadow " >
    <div class="w3-border-bottom w3-border-light-gray w3-padding" >
        <div class="w3-margin-right w3-xlarge" ><i class="fa fa-angle-double-left" style="margin-left: 5px" ></i>{{ __('transformations') }}</div>
    </div>
    <div class="card-body filter" style="display: none" >
        <form  method="get" action="" >
            <div class="row" >

                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="form-group">
                        <div class="controls">
                            <label class="label-r" for="date_from">{{ __('date_from') }}</label>
                            {!! Form::date('date_from',null,['class'=>'custom-select','id'=>'customSelect'])!!}
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="form-group">
                        <div class="controls">
                            <label class="label-r" for="date_to">{{ __('date_to') }}</label>
                            {!! Form::date('date_to',null,['class'=>'custom-select','id'=>'customSelect'])!!}
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="form-group">
                        <div class="controls">
                            <label class="label-r" for="bank">{{ __('bank') }}</label>
                            {!! Form::select('bank_id',\Modules\Account\Entities\Bank::select('*', DB::raw('CONCAT(name, " > ", FORMAT(balance, 2), " EGP") as title'))->pluck('title','id'),null,['class'=>'custom-select select2','id'=>'customSelect', 'required' ])!!} 
            
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="form-group">
                        <div class="controls">
                            <label class="label-r" for="level_id">{{ __('store') }}</label>
                            {!! Form::select('store_id',\Modules\Account\Entities\Store::select('*', DB::raw('CONCAT(name, " > ", FORMAT(balance, 2), " EGP") as title'))->pluck('title','id'),null,['class'=>'custom-select select2','id'=>'customSelect', 'required' ])!!} 
            
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="form-group">
                        <div class="controls">
                            <label class="label-r" for="type">{{ __('type') }}</label>
                            @php
                                $type = [
                                    '' => __('select all'),
                                    'bank_to_store' => __('bank_to_store'),
                                    'store_to_bank' => __('store_to_bank')
                                ];
                            @endphp
                            {!! Form::select('type', $type,null,['class'=>'custom-select','id'=>'customSelect select2', 'required' ])!!} 
            
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="form-group">
                        <div class="controls">
                            <label class="label-r" for="user_id">{{ __('user') }}</label>
                            {!! Form::select('user_id',App\User::pluck('name','id'),null,['class'=>'custom-select select2','id'=>'customSelect', 'placeholder' => ''])!!}

                        </div>
                    </div>
                </div>



                <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('search') }}</button>
                    <a role="button" href="{{ route('transformations.index') }}" class="btn btn-danger waves-effect waves-light">{{ __('select all') }}</a>
                </div>
            </div>
        </form>
    </div>
</div>