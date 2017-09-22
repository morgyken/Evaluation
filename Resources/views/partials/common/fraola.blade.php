<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 9/22/17
 * Time: 10:46 AM
 */
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{m_asset('evaluation:css/fraola/froala_editor.css')}}">
<link rel="stylesheet" href="{{m_asset('evaluation:css/fraola/froala_style.css')}}">
<link rel="stylesheet" href="{{m_asset('evaluation:css/fraola/plugins/code_view.css')}}">
<link rel="stylesheet" href="{{m_asset('evaluation:css/fraola/plugins/colors.css')}}">
<link rel="stylesheet" href="{{m_asset('evaluation:css/fraola/plugins/emoticons.css')}}">
<link rel="stylesheet" href="{{m_asset('evaluation:css/fraola/plugins/image_manager.css')}}">
<link rel="stylesheet" href="{{m_asset('evaluation:css/fraola/plugins/image.css')}}">
<link rel="stylesheet" href="{{m_asset('evaluation:css/fraola/plugins/line_breaker.css')}}">
<link rel="stylesheet" href="{{m_asset('evaluation:css/fraola/plugins/table.css')}}">
<link rel="stylesheet" href="{{m_asset('evaluation:css/fraola/plugins/char_counter.css')}}">
<link rel="stylesheet" href="{{m_asset('evaluation:css/fraola/plugins/video.css')}}">
<link rel="stylesheet" href="{{m_asset('evaluation:css/fraola/plugins/fullscreen.css')}}">
<link rel="stylesheet" href="{{m_asset('evaluation:css/fraola/plugins/file.css')}}">
<link rel="stylesheet" href="{{m_asset('evaluation:css/fraola/themes/gray.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">

<!-- <textarea></textarea> -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/froala_editor.min.js')}}"></script>
<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/align.min.js')}}"></script>
{{--<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/code_beautifier.min.js')}}"></script>--}}
{{--<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/code_view.min.js')}}"></script>--}}
<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/colors.min.js')}}"></script>
<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/draggable.min.js')}}"></script>
{{--<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/emoticons.min.js')}}"></script>--}}
<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/font_size.min.js')}}"></script>
<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/font_family.min.js')}}"></script>
<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/image.min.js')}}"></script>
{{--<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/file.min.js')}}"></script>--}}
<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/image_manager.min.js')}}"></script>
<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/line_breaker.min.js')}}"></script>
<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/link.min.js')}}"></script>
<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/lists.min.js')}}"></script>
<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/paragraph_format.min.js')}}"></script>
<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/paragraph_style.min.js')}}"></script>
{{--<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/video.min.js')}}"></script>--}}
<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/table.min.js')}}"></script>
<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/url.min.js')}}"></script>
{{--<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/entities.min.js')}}"></script>--}}
<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/char_counter.min.js')}}"></script>
<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/inline_style.min.js')}}"></script>
<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/save.min.js')}}"></script>
<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/fullscreen.min.js')}}"></script>
{{--<script type="text/javascript" src="{{m_asset('evaluation:js/fraola/plugins/quote.min.js')}}"></script>--}}
<script>
    $(function(){
        $('#edit').froalaEditor({
            theme: 'gray'
        })
        $('textarea').froalaEditor({
            theme: 'gray'
        })
    });
</script>

