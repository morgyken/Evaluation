<footer>
    <div style="float: right">
        <small>Pathologist:
            <?php
            try{
                echo $item?$item->doctors?$item->doctors->profile->full_name:'':\Auth::user()->full_name;
            }catch(\Exception $e){
                echo \Auth::user()->full_name;
            }
            ?>

        </small>
    </div>
    <br>
    <div class="page-number"></div>
    <div style="float: right"><small>&copy;All rights reserved<small> </div>
</footer>