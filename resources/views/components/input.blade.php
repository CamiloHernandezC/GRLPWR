<div class="form-group row">
    <label for="{{$name}}" class="col-md-4 col-form-label text-md-center">{{$description}}</label>
    <div class="col-md-6">
        <input id="{{$name}}" class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}" name="{{$name}}" value="{{ old($name) }}" {{$attributes}} autofocus>
        @if ($errors->has($name))
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first($name) }}</strong>
                    </span>
        @endif
    </div>
</div>