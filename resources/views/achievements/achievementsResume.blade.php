@push('head-content')
    <link href="{{asset('css/achievements.css')}}" rel="stylesheet"/>
@endpush

<div class="themed-block col-12 col-md-10 mx-auto mt-4 p-2">
    <h3 class="section-title">Logros:</h3>
    <div class="d-flex justify-content-around">
        @dd($details)
        <img class="achievement-icon" src="{{asset('images/achievements/streak_grey.png')}}"/>
        <img class="achievement-icon" src="{{asset('images/achievements/streak_color.png')}}"/>
    </div>
</div>
