

@if(!empty($item->procedures->remarks))
    <label>Remarks</label>
    <textarea id="{{$item->id}}" rows="5" name="comments{{$item->id}}" class="form-control"><?php echo strip_tags($item->procedures->remarks->remarks) ?>
    </textarea>
@endif
<label>Comments</label>
<textarea id="{{$item->id}}" rows="5" name="comments{{$item->id}}" class="form-control"></textarea>
