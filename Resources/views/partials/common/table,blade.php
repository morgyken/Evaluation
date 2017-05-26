<table class="table table-condensed table-borderless table-responsive" id="procedures">
    <tbody>
        @foreach($procedures as $procedure)
        <tr id="row{{$procedure->id}}">
            <td>
                <input type="checkbox" name="item{{$procedure->id}}" value="{{$procedure->id}}" class="check"/>
            </td>
            <td>
                <span id="name{{$procedure->id}}"> {{$procedure->name}}</span><br/>
                <span class="instructions">
                    <textarea placeholder="Instructions" name="instructions{{$procedure->id}}" disabled cols="50">
                    </textarea>
                </span>
                <input type="hidden" name="type{{$procedure->id}}" value="{{$type}}" disabled />
            </td>
            <td>
                <input type="text" name="price{{$procedure->id}}" value="{{$procedure->price}}" id="cost{{$procedure->id}}" size="5" readonly=""/>
            </td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
    <thead>
        <tr>
            <th></th>
            <th>Test</th>
            <th>Price</th>
            <th></th>
        </tr>
    </thead>
</table>