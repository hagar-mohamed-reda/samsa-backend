<div class="modal fade" id="requiredDocumentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('registerationStatusUpdateRequiredData', $registerationStatus->id) }}" >
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="text-center w3-block modal-title w3-xlarge" >
                        {{ __('select required documents') }}
                        <br>
                        <span class="w3-large" >({{ $registerationStatus->name }})  </span>
                    </div>   
                </div>
                <div class="modal-body">
                    <ul class="w3-ul" >
                        <li>
                            <input class="w3-input" placeholder="{{ __('search') }}" onkeyup="searchDocument(this.value)" >
                        </li>
                        @foreach(Modules\Adminsion\Entities\RequiredDocument::all() as $item)
                        <li class="document-list-item w3-display-container w3-padding w3-hover-light-gray cursor w3-block" onclick="$(this).find('.checkbox-input').attr('checked', 'checked')" >
                            <button class="fa fa-newspaper-o w3-circle {{ randColor() }}" style="width: 40px;height: 40px;margin: 5px" ></button>
                            <span class="w3-large" >{{ $item->name }}</span>
                            
                            <div class="vs-checkbox-con vs-checkbox-primary w3-display-topleft w3-padding">
                                <input type="hidden"    value="{{ $item->id }}" name="required_document_id[]"  >
                                <input type="checkbox" class="checkbox-input" value="{{ $item->id }}"   name="required_document_check[]"
                                       @if($registerationStatus->requiredDocuments()->where('id', $item->id)->first())
                                       checked=""
                                       @endif
                                       >
                                <span class="vs-checkbox">
                                    <span class="vs-checkbox--check">
                                        <i class="vs-icon feather icon-check"></i>
                                    </span>
                                </span>
                                <span class=""></span>
                            </div> 
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <center>
                    <button type="button" class="btn btn-default shadow" data-dismiss="modal">{{ __('close') }}</button>
                    <button type="submit" class="btn btn-primary shadow">{{ __('save') }}</button>
                    </center>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->