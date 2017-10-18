<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 9/22/17
 * Time: 2:04 PM
 */
?>
<link rel="stylesheet" type="text/css" href="{{m_asset('evaluation:redactor/css/style.css')}}" />
<!-- Redactor is here -->
<link rel="stylesheet" href="{{m_asset('evaluation:redactor/redactor/redactor.css')}}" />
<script src="{{m_asset('evaluation:redactor/redactor/redactor.js')}}"></script>
<script type="text/javascript">
    $(document).ready(
        function() {
            $('textarea').redactor({
            fixed: true
        });
        }
    );
</script>
