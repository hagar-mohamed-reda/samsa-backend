 
<table class="table table-border w3-bordered" id="table" >
    <thead>
        <tr class="w3-dark-gray" >
            <th scope="col" class="w3-large" >{{ __('key') }}</th>
            <th scope="col" class="w3-large">{{ __('Name in English') }}</th>
            <th scope="col" class="w3-large">{{ __('Name in Arabic') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach(App\Translation::all() as $row)                                    
        <tr class="trans-row" >
            <th scope="row" >
                {!! $row->key !!}
                <input type="hidden" class="form-control" name="key[]" value="{{ $row->key }}" >
                <input type="hidden" class="form-control id" name="id[]" value="{{ $row->id }}" >
            </th>
            <td>
                <input type="text" class="form-control form-control-sm w3-large name_en" name="name_en[]" value="{!! $row->name_en? $row->name_en : '' !!}" >
            </td>
            <td>
                <input type="text" class="form-control form-control-sm w3-large name_ar" name="name_ar[]" value="{!! $row->name_ar? $row->name_ar : '' !!}" >
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<br>
<div class="w3-center" >
    <button type="button" onclick="submitTrans(this)" class="btn btn-relief-primary mr-1 mb-1 waves-effect waves-light" >{{ __('save') }}</button> 
</div>