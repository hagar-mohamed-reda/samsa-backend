 
@php
$links = [
['name' => __('home'), 'url' => url('/')],
['name' => __('plans'), 'url' => route('plans.index')],
['name' => $resource->name, 'active' => true],
];
@endphp

<div class="modal fade" id="showModal{{ $resource->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="text-center w3-block modal-title w3-xlarge" >
                    {{ $resource->name }}
                </div>   
            </div>
            @include('layouts.breadcrumb', ['links' => $links, "shadow" => false])   
            <div class="modal-body">  
                <table class="table" >
                    <tr>
                        <th>{{ __('name') }}</th>
                        <td>
                            {{ $resource->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ __('value') }}</th>
                        <td>
                            {{ $resource->value }}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ __('expense_maincategory') }}</th>
                        <td>
                            {{ optional($resource->expenseMainCategory)->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ __('level') }}</th>
                        <td>
                            {{ optional($resource->level)->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ __('academic_year') }}</th>
                        <td>
                            {{ optional($resource->academicYear)->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ __('notes') }}</th>
                        <td>
                            {{ $resource->notes }}
                        </td>
                    </tr> 
                    <tr>
                        <th>{{ __('case_constaints') }}</th>
                        <td>
                            {{ implode(", ", $resource->caseContraintModels()->pluck('name')->toArray()) }}
                        </td>
                    </tr> 
                </table>
                <br>
                <div class="w3-large w3-padding" >{{ __('details') }}</div>
                <table class="table table-border" > 
                    <tr>
                        <th>{{ __('date_from') }}</th>
                        <th>{{ __('date_to') }}</th>
                        <th>{{ __('value') }}</th>
                        <th>{{ __('fine') }}</th>
                        <th>{{ __('notes') }}</th>
                        <th>{{ __('expense_maincategorys') }}</th>
                    </tr>
                    @foreach($resource->details()->get() as $item)
                    <tr>
                        <td>{{ $item->date_from }}</td>
                        <td>{{ $item->date_to }}</td>
                        <td>{{ number_format($item->value, 2) }} EGP</td>
                        <td>{{ optional($item->fine)->name }} - {{ number_format(optional($item->fine)->value, 2) }} EGP</td>
                        <td>{{ $item->notes }}</td>
                        <td>
                            <ul>
                                <li>{!! implode("<li>", $item->expenseMainCategorys()->pluck('name')->toArray()) !!}
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <div class="modal-footer text-center">
                <center>
                    <button type="button" class="btn btn-default shadow" data-dismiss="modal">{{ __('close') }}</button> 
                </center>
            </div>  
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->