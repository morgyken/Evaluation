<?php $id = $type . '_form'; ?>
{!! Form::open(['id'=>$id])!!}
{!! Form::hidden('patient_id',$patient->id) !!}
{!! Form::hidden('institution',$institution) !!}
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
                    <textarea placeholder="Instructions" name="instructions{{$procedure->id}}" disabled cols="50"></textarea>
                </span>
                <input type="hidden" name="type{{$procedure->id}}" value="{{$type}}" disabled />
            </td>
            <td>
                <input class="quantity" value="1" id="quantity{{$procedure->id}}" type="hidden" name="quantity{{$procedure->id}}"/>
                <input style="color:red" class="discount" size="5" value="0" id="discount{{$procedure->id}}" type="hidden" name="discount{{$procedure->id}}" readonly=""/>
                <input type="text" name="price{{$procedure->id}}" value="{{$procedure->price}}" id="cost{{$procedure->id}}" size="5" readonly=""/>
                <input id="amount{{$procedure->id}}" type="hidden" name="amount{{$procedure->id}}" readonly=""/>
            </td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
    <thead>
        <tr>
            <th></th>
            <th>Item</th>
            <th>Price</th>
            <th></th>
        </tr>
    </thead>
</table>
{!! Form::close()!!}