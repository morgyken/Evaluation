
<br>
<footer>
    <div style="float: right">
        <small>Pathologist:
            <?php
            if (isset($item)){
                echo $item->doctors?$item->doctors->profile->full_name:'';
            }else{
                echo \Auth::user()->profile->full_name;
            }
            ?>
        </small>
    </div>
    <br>
    <div class="page-number"></div>
    <div style="float: right"><small>&copy;All rights reserved<small> </div>
</footer>