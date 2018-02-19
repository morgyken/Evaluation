<div class="input-group, pull-right">
    <form method="POST" action="{{ route('evaluation.queues_patient_search', ['department'=> $department]) }}" class="navbar-form navbar-left" role="search">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="text" name="search" size="25" class="form-control" placeholder="Search: name">
        </div>
        <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
    </form>
</div>