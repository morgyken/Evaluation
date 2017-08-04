<div id="footer">
    <div style="text-align: right; color: black">
        <br/>
        <small>
            Pathologist:
            <?php
            if (isset($item)){
                echo $item->doctors?$item->doctors->profile->full_name:'';
            }else{
                echo \Auth::user()->profile->full_name;
            }
            ?>
        </small><br/>
        <small class="page-number"></small><br/>
        <small style="color: black">&copy;All rights reserved<small>
    </div>
</div>