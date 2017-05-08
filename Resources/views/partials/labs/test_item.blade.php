
<h4>{{$item->procedures->name}}</h4>
<div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Results</label>
            <input type="hidden" name="item{{$item->id}}" value="{{$item->id}}" />
            <input type="hidden" name="test{{$item->id}}[]" value="{{$item->procedures->id}}" />
            <textarea id="{{$item->id}}" name="results{{$item->id}}[]" class="form-control" >
                <?php get_reverted_test($item->procedures->id) ?>
            </textarea>
            <!-- Consumables -->
            <?php get_consumables($item->procedures->id) ?>
        </div>
    </div>
    <div class="col-md-4 col-md-offset-2">
        <div class="form-group">
            <label>File</label>
            <input type="file" class="form-control" name="file{{$item->id}}"/>
        </div>
        <hr/>
        <dl class="dl-horizontal">
            <dt>Requested By:</dt><dd>{{$item->doctors->profile->full_name}}</dd>
            <dt>Instructions:</dt><dd><p>{{$item->instructions ?? 'Not provided'}}</p></dd>
            <dt>Price:</dt><dd>{{$item->pesa}}</dd>
            <dt>Units performed:</dt><dd><p>{{$item->quantity}}</p></dd>
            <dt>Discount:</dt><dd><p>{{$item->discount}}</p></dd>
            <dt>Charges:</dt><dd>{{$item->amount>0?$item->amount:$item->pesa}}</dd>
            <dt>Date:</dt><dd>{{smart_date_time($item->created_at)}}</dd>
        </dl>
        <hr/>
    </div>
    <div class="pull-right">
        <a href="" id="{{$item->id}}" class="save btn btn-xs btn-success"><i class="fa fa-save"></i> Save</a>
        <button type="reset" class="btn btn-warning btn-xs">Cancel</button>
    </div>
</div>