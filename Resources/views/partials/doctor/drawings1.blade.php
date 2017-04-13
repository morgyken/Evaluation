<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */

// Copied from -http://yiom.github.io/sketchpad/
// see also http://intridea.github.io/sketch.js/
// intresting http://zwibbler.com/docs/ <--- paid
//atempting http://literallycanvas.com/installing.html
?>
<div class="row">
    <div class="col-md-12">
        <div class="">
           <!-- <canvas id="sketchpad"></canvas>-->
            <div class="my-drawing"></div>
            <div class="btn-group-sm">
                <form id="photobg"  enctype="multipart/form-data">
                    <input type="hidden" name="visit" value="{{$data['visit']}}"/>
                    <input type="hidden" name="user" value="{{Auth::user()->user_id}}"/>
                    <input type="file" class="btn" id="background" name="image"/>
                    <span class="help-block" id="message"></span>
                </form>
                <button class="btn" id="undo"><i class="fa fa-undo"></i></button>
                <button class="btn" id="redo"><i class="fa fa-repeat"></i></button>
                <input type="color" id="color" class="btn"/>
                <button class="btn" id="animate"><i class="fa fa-eye-slash"></i> Preview</button>
                <button class="btn" id="saveDrawing"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        LC.init(
                document.getElementsByClassName('my-drawing')[0],
                {imageURLPrefix: '/plugins/literally/img'}
        );
        /*
         var sketchpad = new Sketchpad({
         element: '#sketchpad',
         width: 400,
         height: 400,
         });
         if (typeof setting !== 'undefined') {
         try {
         sketchpad = new Sketchpad(setting);
<?php if (!empty($data['visits']->drawings)): ?>
             $("#sketchpad").css("background-image", "url('data:image/jpeg;base64,{{$data['visits']->drawings->background}}')");
<?php endif;
?>
         } catch (e) {
         }

         } else {
         // Change color
         sketchpad.color = '#FF0000';
         // Change stroke size
         }
         sketchpad.penSize = 1;
         $('#undo').click(function () {
         sketchpad.undo();
         });
         $('#redo').click(function () {
         sketchpad.redo();
         });
         $('#color').val(sketchpad.color);
         $('#color').change(color);
         $('#animate').click(animate);
         $('#saveDrawing').click(function () {
         // var jsons = sketchpad.toJSON();
         var objects = sketchpad.toObject();
         $.ajax({
         type: "POST",
         url: DRAWINGS_URL,
         data: {
         'visit': "{{$data['visit']}}",
         'user': "{{Auth::user()->user_id}}",
         'objects': objects
         }
         });
         });
         $('#background').change(set_bg);
         function color(event) {
         sketchpad.color = $(event.target).val();
         }

         function animate() {
         sketchpad.animate(10);
         }

         function set_bg(event) {
         var getImagePath = URL.createObjectURL(event.target.files[0]);
         $('#sketchpad').css('background-image', 'url(' + getImagePath + ')');
         //var formData = new FormData($('#photobg'));
         var file = this.files[0];
         var imagefile = file.type;
         var match = ["image/jpeg", "image/png", "image/jpg"];
         if (!((imagefile === match[0]) || (imagefile === match[1]) || (imagefile === match[2])))
         {
         $("#message").html("<p class='text-danger'>Please select a valid image. Only jpeg,png,jpg allowed</p>");
         return false;
         }
         $("#message").html("<p class='text-success'>Background set</p>");
         $("#photobg").submit();
         }
         $("#photobg").submit(function (e) {
         e.preventDefault();
         formData = new FormData(this);
         $.ajax({
         type: "POST",
         url: DRAWINGS_URL,
         data: formData,
         contentType: false, // The content type used when sending data to the server.
         cache: false, // To unable request pages to be cached
         processData: false,
         });
         });*/
    });
</script>
<link href="{{asset('plugins/literally/css/literallycanvas.css')}}"/>
<!-- dependency: React.js -->
<script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-with-addons.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-dom.js"></script>
<script src="{{asset('plugins/literally/js/literallycanvas.min.js')}}"></script>
<style>
    #sketchpad,.my-drawing {
        outline: 1px solid orange;
        background-color: white;
        background-repeat: no-repeat;
    }
</style>
<?php
if (!empty($data['visits']->drawings)):
    echo "<script type='text/javascript'>";
    echo "var setting = " . json_encode(unserialize($data['visits']->drawings->object)) . ";";
    echo "setting.element = '#sketchpad';";
    // echo "var background= '" . $data['visits']->drawings->background . "';";
    echo "</script>";
endif;