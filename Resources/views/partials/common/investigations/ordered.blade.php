@if(!$investigations->isEmpty())
{!! Form::open(['id'=>'results_form','files'=>true]) !!}
{!! Form::hidden('visit',$visit->id)!!}
<div class="accordion">
    @foreach($investigations as $item)
    <h4>{{$item->procedures->name}}</h4>
    <div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Results</label>
                <input type="hidden" name="item{{$item->id}}" value="{{$item->id}}" />
                <textarea name="results{{$item->id}}" class="form-control" >
                    <?php get_template($item->procedures->id, $item->procedures->category) ?>
                </textarea>
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
                        <dd>{{$item->doctors->profile->full_name}}</dd>
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
                </div>
                <div>
                    <div class="pull-left">
                        <?php $x = getOrthanc($visit->patient, $item->id); ?>
                        @if(empty($x))
                            <p class="text-warning">No dicom images</p>
                        @else
                            <a href="{{$x}}" target="_blank" class="btn btn-default"><i class="fa fa-eye"></i> View
                                Dicom
                                images</a>
                        @endif
                    </div>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-xs btn-success">
                            <i class="fa fa-save"></i>
                            Save
                        </button>
                        <button type="reset" class="btn btn-warning btn-xs">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>File</label>
                <input type="file" class="form-control" name="file{{$item->id}}"/>
            </div>
            <table class="table table-striped table-condensed">
                <tr>
                    <td>Requested By:</td>
                    <td>{{$item->doctors?$item->doctors->profile->full_name:''}}</td>
                </tr>
                <tr>
                    <td>Instructions:</td>
                    <td>{{$item->instructions ?? 'Not provided'}}</td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>{{$item->pesa}}</td>
                </tr>
                <tr>
                    <td>Units Performed</td>
                    <td>{{$item->quantity}}</td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td>{{$item->discount}}</td>
                </tr>
                <tr>
                    <td>Charges</td>
                    <td>{{$item->amount>0?$item->amount:$item->pesa}}</td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td>{{smart_date_time($item->created_at)}}</td>
                </tr>
            </table>
            <hr/>
        </div>
        <div class="col-md-6">
            <!-- Consumables -->
            <?php get_consumables($item->procedure) ?>
        </div>
        <div class="col-md-12">
            <div class="pull-right">
                <button type="submit" class="btn btn-xs btn-success">
                    <i class="fa fa-save"></i>
                    Save</button>
                <button type="reset" class="btn btn-warning btn-xs">Cancel</button>
            </div>
        </div>
    </div>
    @endforeach
</div>
{!! Form::close()!!}
@else
    <p>No radiology procedures have been ordered for this patient</p>
@endif

