<div class="row">
    
    <div class="col-12">
        <div class="form-group">
            <div class="controls">
                <img src="{{ isset($user)? url('public/' . $user->image) : url('/app-assets/images/avatar/avatar.png') }}" width="100px" id="imageView" class="image w3-round" >
                <p>
                    <input type="file" accept="image/*" name="image" id="file" onchange="loadFile(event)"
                          style="display: none;">
                </p>
                <p>
                    <button type="button" for="file" onclick="$('#file').click()" class="btn btn-instagram btn-sm" style="cursor: pointer;">{{ __('upload image') }} </button></p>
                <p><img id="output" width="200"/></p>
                @error('image')
                <span class="text-danger">{!! $message !!}</span>
                @enderror
                <div class="help-block"></div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="name"> {{ __('full name') }} </label>
                {!! Form::text('name',null,['class'=>'form-control','id'=>'name','placeholder'=> __('full name') ])!!}
                @error('name')
                <span class="text-danger">{!! $message !!}</span>
                @enderror
                <div class="help-block"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="username"> {{ __('username') }} </label>
                {!! Form::text('username',null,['class'=>'form-control','id'=>'username','placeholder'=> __('username') ])!!}
                @error('username')
                <span class="text-danger">{!! $message !!}</span>
                @enderror
                <div class="help-block"></div>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="username"> {{ __('phone') }} </label>
                {!! Form::text('phone',null,['class'=>'form-control','id'=>'username','placeholder'=> __('phone') ])!!}
                @error('phone')
                <span class="text-danger">{!! $message !!}</span>
                @enderror
                <div class="help-block"></div>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="email"> {{ __('email') }} </label>
                {!! Form::text('email',null,['class'=>'form-control','id'=>'username','placeholder'=> __('email') ])!!}
                @error('email')
                <span class="text-danger">{!! $message !!}</span>
                @enderror
                <div class="help-block"></div>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                <label for="email"> {{ __('role') }} </label>
                {!! Form::select('role_id',App\Role::pluck('name','id'),null,['class'=>'custom-select','id'=>'customSelect', 'placeholder' => __('role') ])!!}
                <div class="help-block"></div>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <div class="controls">
                    <div class="position-relative has-icon-left">
                        <label for="password"> {{ __('password') }} </label>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" value="{{ isset($user)? $user->password : '' }}">

                    </div>
                @error('password')
                <span class="text-danger">{!! $message !!}</span>
                @enderror
                <div class="help-block"></div>
            </div>
        </div>
    </div>
 
</div> 

@section('more_scripts')
<script language="javascript">


    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imageView').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $("#file").change(function () {
        readURL(this);
    });
</script>
<script> 
    $('input[name=role_id]').val('{{ isset($user)? $user->role_id : '' }}');
</script>
@endsection