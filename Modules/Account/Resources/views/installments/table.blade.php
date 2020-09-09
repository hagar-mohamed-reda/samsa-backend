
<!-- DataTable starts -->
<div class="table-responsive material-shadow w3-white w3-padding-0">
    <table class="table data-list- default-" id="table" >
        <thead>
            <tr class="w3-large w3-padding" >
                <th></th> 
                <th>{{ __('date_from') }}</th> 
                <th>{{ __('date_to') }}</th> 
                <th>{{ __('value') }}</th>  
                <th>{{ __('paid_value') }}</th>
                <th>{{ __('remain_value') }}</th>  
                <th>{{ __('student') }}</th> 
                <th>{{ __('user_id') }}</th>  
                <th>{{ __('target') }}</th>    
                <th>{{ __('notes') }}</th>  
            </tr>
        </thead>
        <tbody>
            @foreach($resources as $row)
            <tr>
                <td>{!! $loop->iteration !!}</td>
                <td >{!! $row->date_from !!}</td>
                <td >{!! $row->date_to !!}</td>
                <td >{!! number_format($row->value) !!} EGP </td> 
                <td >{!! number_format($row->paid) !!} EGP </td>
                <td >{!! number_format($row->remaining) !!} EGP </td> 
                <td >{!! optional($row->student)->name !!}</td>
                <td >{!! optional($row->user)->name !!}</td>
                <td >{!! __($row->target) !!}</td>
                <td >{!! str_replace("\n", "<br>", $row->notes) !!}</td>

                <td >
                    <div class="product-action btn-group" style="width: 250px" >
                        @if ($row->type == 'main')
                        @if ($row->installments()->count() <= 0)
                        @if ($row->paid != '1')
                        <span class="action-edit" style="margin: 3px" >
                            <a class="btn shadow font-large btn-sm w3-indigo" href="{{ route('installments.install', $row->id) }} ">                          
                                <div class="fonticon-wrap ">{{ __('install') }}</div> 
                            </a>
                        </span>
                        @endif
                        @endif
                        @endif
                        @if (!$row->isPaid() && $row->installments()->count() <= 0)
                        <span style="margin: 3px" class="action-edit">
                            <a class="btn shadow font-large btn-sm w3-green" href="{{ route('payments.index') }}?installment_id={{ $row->id }}&action=create"> 
                                <div class="fonticon-wrap w3-text-white">{{ __('pay') }}</div> 
                            </a>
                        </span>
                        @endif
                        @if ($row->type == 'main')
                        @if ($row->installments()->count() > 0)
                        <span style="margin: 3px" class="action-edit">
                            <a class="btn shadow font-large btn-sm w3-blue" href="{{route('installments.index')}}?resource_id={{ $row->id }}&action=show"> 
                                <div class="fonticon-wrap w3-text-white">{{ __('show') }}</div> 
                            </a>
                        </span>
                        @endif
                        @endif

                        @if ($row->paid == '1')
                        <span style="margin: 3px" class="action-edit">
                            <a class="btn shadow font-large btn-sm w3-dark-gray"  onclick="$('#paymentDetailModal{{ $row->id }}').modal('show')" href="#"> 
                                <div class="fonticon-wrap w3-text-white">{{ __('payment details') }}</div> 
                            </a>
                        </span> 
                        @endif

                        @if (!$row->payment && $row->installments()->count() <= 0 && $row->paid != '1' )
                        <span class="action-edit">
                            <a href="{{route('installments.index')}}?resource_id={{ $row->id }}&action=edit">
                                <div class="col-md-4 col-sm-6 col-12">
                                    <div class="fonticon-wrap"><i class="fa fa-edit"></i></div>
                                </div>
                            </a>
                        </span>
                        @endif
                        @if (!$row->payment && $row->installments()->count() <= 0 && $row->paid != '1' )
                        <span class="action-delete">
                            <a onclick="Delete({{'deleteForm'.$row->id}})" id="type-warning">
                                <div class="col-md-4 col-sm-6 col-12">
                                    <div class="fonticon-wrap"><i class="fa fa-trash-o"></i></div>
                                </div>
                            </a> 
                            <form id="deleteForm{{$row->id}}" action="{{route('installments.destroy',$row->id)}}" method="post">
                                @method("DELETE")
                                @csrf
                            </form>
                        </span>
                        @endif
                    </div>
                </td>
            </tr> 
            @endforeach
        </tbody>
    </table>
</div>
<!-- DataTable ends -->




@foreach($resources as $row)

@if ($row->paid == '1')
<div class="modal fade" id="paymentDetailModal{{ $row->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="text-center w3-block modal-title w3-xlarge" >
                    {{ __('payment details') }} 
                </div>   
            </div> 
            <div class="modal-body"> 
                <table class="table" >
                    <tr>
                        <th>{{ __('date') }}</th>
                        <td>{{ optional($row->payment)->date }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('installment_value') }}</th>
                        <td>{{ $row->value }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('payment_value') }}</th>
                        <td>{{ optional($row->payment)->value }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('discount') }}</th>
                        <td>{{ optional($row->payment)->discount }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('type') }}</th>
                        <td>{{ __(optional($row->payment)->payment_type) }}</td>
                    </tr>
                    @if (optional($row->payment)->payment_type == 'store')
                    <tr>
                        <th>{{ __('store') }}</th>
                        <td>{{ optional(optional($row->payment)->store)->name }}</td>
                    </tr>
                    @endif
                    @if (optional($row->payment)->payment_type == 'check')
                    <tr>
                        <th>{{ __('check_number') }}</th>
                        <td>{{ __(optional($row->payment)->check_number) }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('account_number') }}</th>
                        <td>{{ __(optional($row->payment)->account_number) }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('bank_name') }}</th>
                        <td>{{ __(optional($row->payment)->bank_name) }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('branch') }}</th>
                        <td>{{ __(optional($row->payment)->branch) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>{{ __('user_id') }}</th>
                        <td>{{ optional(optional($row->payment)->user)->name  }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('notes') }}</th>
                        <td>{{  optional($row->payment)->notes  }}</td>
                    </tr>
                    @if (optional($row->payment)->attachment)
                    <tr>
                        <th>{{ __('attachment') }}</th>
                        <td >
                            <a target="_blank" href="{!! optional($row->payment)->attachment_url !!}" class="w3-border-bottom w3-border-blue"  >{!! __('attachment') !!}</a>
                           
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
            <div class="modal-footer text-center">
                <center>
                    <button type="button" class="btn btn-default shadow"  onclick="$('#paymentDetailModal{{ $row->id }}').modal('hide')" >{{ __('close') }}</button> 
                </center>
            </div>  
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endif
@endforeach
