<form action="{{ route('change-branch') }}" method="POST">
    @csrf
    <div class="d-inline-block">
        <select class="form-control border-0 shadow-none" id="branch" name="branch"  onchange="this.form.submit()" style="background-position: right 5px center !important;">
            <option style="color: black" value="" disabled>Sucursal...</option>
            @foreach($branches as $branch)
                <option style="color: black" value="{{$branch->id}}" {{ $branch->id == session('branch') ? 'selected' : '' }}>{{$branch->name}}</option>
            @endforeach
        </select>
    </div>
</form>
