<link rel="stylesheet" href="{{url('/css/app.css')}}">
<div class="container">
    <div class="col-lg-8">
        <h2>Deposit Slip:</h2>

        <div class="col-lg-6">
            <div class="form-group">
                <label for="" class="label-control">Name:</label>
                {{$patient->name}}
            </div>
            <div class="form-group">
                <label for="" class="label-control">Reference:</label>
                {{$tras->reference}}
            </div>
            <div class="form-group">
                <label for="" class="label-control">Detail:</label>
                {{$tras->details}}
            </div>

        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="" class="label-control">Date / Time:</label>
                {{$tras->created_at}}
            </div>

            <div class="form-group">
                <label for="" class="label-control">Deposit Amount:</label>
                {{$amount}}
            </div>

            <div class="form-group">
                <label for="" class="label-control">Account Balance:</label>
                {{$balance}}
            </div>

        </div>
    </div>
</div>