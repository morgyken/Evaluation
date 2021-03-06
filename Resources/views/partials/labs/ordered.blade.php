@if(!$investigations->isEmpty())
    <div class="accordion">
        @foreach($labs as $item)
            @if($item->procedures && ($item->is_paid || $item->invoiced))
                <?php $subtests = get_lab_template($item->procedures->id); ?>
                <h4>{{$item->procedures->name}}</h4>
                <div>
                    <form method="POST" action="" accept-charset="UTF-8" id="results_form{{$item->id}}"
                          enctype="multipart/form-data">
                        {!! Form::hidden('visit',$visit->id)!!}
                        {!! Form::token() !!}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Test Results</label>
                                <input type="hidden" name="item{{$item->id}}" value="{{$item->id}}"/>
                            @if($item->procedures->sensitivity)
                                <?php
                                $s_item = $item->procedures;
                                ?>
                                @include('evaluation::partials.labs.sensitivity')
                                @include('evaluation::partials.labs.comment')
                            @else
                                @if(!empty($item->procedures->templates_lab))
                                    @if(has_headers($item->procedures->id))
                                        <!-- Procedure has pre-defined template -->
                                        @include('evaluation::partials.labs.preload')
                                    @else
                                        <!-- Procedure has pre-defined template -->
                                        @include('evaluation::partials.labs.preload_no_headers')
                                    @endif
                                @else
                                    @if(!$item->procedures->children->isEmpty())
                                        <!-- Procedure has children -->
                                        @if(!$item->procedures->titles->isEmpty())
                                            <!-- Procedure has titles (full haemogram) -->
                                            @include('evaluation::partials.labs.with_titles')
                                        @else
                                            <!-- Procedure has no titles -->
                                            @include('evaluation::partials.labs.without_titles')
                                        @endif
                                    @else
                                        <!--Procedure has no children -->
                                            @include('evaluation::partials.labs.without_children')
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 col-md-offset-2">
                            <div class="form-group">
                                <label>File</label>
                                <input type="file" class="form-control" name="file{{$item->id}}"/>
                            </div>
                            <hr/>
                            <dl class="dl-horizontal">
                                <dt>Requested By:</dt>
                                <dd>{{$item->doctors?$item->doctors->profile->full_name:''}}</dd>
                                <dt>Instructions:</dt>
                                <dd><p>{{$item->instructions ?? 'Not provided'}}</p></dd>
                                <dt>Price:</dt>
                                <dd>{{$item->pesa}}</dd>
                                <dt>Units performed:</dt>
                                <dd><p>{{$item->quantity}}</p></dd>
                                <dt>Discount:</dt>
                                <dd><p>{{$item->discount}}</p></dd>
                                <dt>Charges:</dt>
                                <dd>{{$item->amount>0?$item->amount:$item->pesa}}</dd>
                                <dt>Date:</dt>
                                <dd>{{smart_date_time($item->created_at)}}</dd>
                            </dl>
                            <hr/>
                            <!-- Consumables -->
                            <?php get_consumables($item->procedure) ?>
                        </div>
                        <div class="pull-right">
                            <a style="color: white" class="btn btn-xs btn-success" onclick="flag({{$item->id}})">
                                <i class="fa fa-save"></i>Save</a>
                            <button type="reset" class="btn btn-warning btn-xs">Cancel</button>
                        </div>
                    </form>
                    {!! Form::close()!!}
                </div>
            @else
                <h4>Laboratory Procedure {{$loop->iteration}} <span class="text-danger">NOT PAID</span></h4>
                <div>
                    <span class="text-danger">NOT PAID</span><br/>
                    <p>Cannot show procedure . Send patient to cashier</p>
                </div>
            @endif
        @endforeach
    </div>
    <script type="text/javascript">
        $('.summernote').summernote();

        function flag(id) {
            $.ajax({
                type: "get",
                url: "{{route('api.evaluation.investigation_result')}}",
                data: $('#results_form' + id + '').serialize(),
                success: function () {
                    alertify.success('<i class="fa fa-check-circle"></i> Results Posted');
                    location.reload();
                },
                error: function () {
                    alertify.error('<i class="fa fa-check-warning"></i> Something went wrong, Retry');
                }
            });
        }
    </script>
@else
    <p>No laboratory procedures have been ordered for this patient</p>
@endif

