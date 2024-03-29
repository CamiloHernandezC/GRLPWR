<div class="form-group">
    <span class="material-icons">directions_run</span>
    <label for="classTypeSelector" class="h4">Tipo de clase</label>
    <select class="form-control pl-1 {{$color ?? 'color-white'}}  {{$bg ?? 'bg-dark'}}" id="classTypeSelector" name="classType">
        @isset($showAll)
            <option value="all" selected>Todas</option>
        @else
            <option value="" disabled selected>selecciona</option>
        @endisset
        @foreach($classTypes as $classType)
            <option value="{{$classType->id}}">{{$classType->type}}</option>
        @endforeach
    </select>
</div>
