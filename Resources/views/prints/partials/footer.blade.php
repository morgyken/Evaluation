<div id="footer">
    <div style="text-align: right; color: black; margin-top: 10px">
        <small style="font-weight: bolder">
            @if(isset($type))
                Radiologist:
            @else
                Pathologist:
            @endif
            <?php
            if (isset($item)) {
                echo $item->doctors ? $item->doctors->profile->full_name : '';
            } else {
                echo \Auth::user()->profile->full_name;
            }
            ?>
        </small><br/>
        <small class="page-number"></small>
        <small><?php echo 'of '.session()->get('pages').' ' ?></small>
        |<small> Printed on {{date("d-m-y") }}</small><br/>
        <small style="color: black">&copy;{{ config('practice.name') }} All rights reserved</small>
    </div>
</div>