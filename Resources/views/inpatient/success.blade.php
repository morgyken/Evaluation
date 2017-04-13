@if(\Illuminate\Support\Facades\Session::has('success'))
    <div class="alert alert-success">
        <span>{{\Illuminate\Support\Facades\Session::get('success')}}</span>
    </div>
    @endif