@php
    $the_list = get_procedures_for($_list)
@endphp
<tbody>
@foreach($the_list as $procedure)
    <?php
    $price = get_price_procedure($visit, $procedure);
    ?>
    <tr id="row{{$procedure->id}}">
        <td>
            <input type="checkbox" id="checked_{{$procedure->id}}" name="item{{$procedure->id}}"
                   value="{{$procedure->id}}" class="check"/>
        </td>
        <td>
            <span id="name{{$procedure->id}}"> {{$procedure->name}}</span>
        </td>
        <td>
            <input class="quantity" size="5" value="1" id="quantity{{$procedure->id}}"
                   type="text"
                   name="quantity{{$procedure->id}}"/>
        </td>
        <td>
            @if(!m_setting('evaluation.hide_procedure_prices'))
                <input class="discount" size="5" value="0"
                       id="discount{{$procedure->id}}" type="hidden"
                       name="discount{{$procedure->id}}"/>
                <input type="hidden" name="type{{$procedure->id}}" value="{{$_type}}" disabled/>
                <input disabled="" type="text" name="price{{$procedure->id}}" value="{{$price}}"
                       id="cost{{$procedure->id}}" size="5" readonly=""/>
                <input size="5" id="amount{{$procedure->id}}" type="hidden"
                       name="amount{{$procedure->id}}" value="{{$price}}"/>
                @else

                <input class="discount" size="5" value="0"
                       id="discount{{$procedure->id}}" type="hidden"
                       name="discount{{$procedure->id}}"/>
                <input type="hidden" name="type{{$procedure->id}}" value="{{$_type}}" />
                <input disabled="" type="hidden" name="price{{$procedure->id}}" value="{{$price}}"
                       id="cost{{$procedure->id}}" size="5" />
                <input size="5" id="amount{{$procedure->id}}" type="hidden"
                       name="amount{{$procedure->id}}" value="{{$price}}"/>
            @endif
        </td>
    </tr>
@endforeach
</tbody>
<thead>
<tr>
    <th>#</th>
    <th>Procedure</th>
    <th>Number Performed</th>
    <th>
        @if(!m_setting('evaluation.hide_procedure_prices'))
        Price
        @endif
    </th>
</tr>
</thead>

