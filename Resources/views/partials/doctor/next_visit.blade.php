<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>

<div class="row">
    <div class="form-horizontal">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::open(['id'=>'next_visit'])!!}
                {!! Form::hidden('visit',$visit->id) !!}
                <div class="box-body">
                    <input type="hidden" name="patient" value="{{$visit->patient}}"/>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Next Appointment Date: </label>
                        <div class="col-md-8">
                            <input type="text" id="datenext" value="{{$visit->next_visit}}" name="next_visit" class="form-control"
                                   placeholder="eg 1 month"/>
                            <div class="help-block"> <span class="text-success" id="samdate"></span></div>
                        </div>
                    </div>
                    <span class="pull-right">
                        <button type="submit" class="btn-success btn"><i class="fa fa-calendar-check-o"></i> Propose</button>
                    </span>
                </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        /* $('#datenext').datepicker({"dateFormat": 'yy-mm-dd', "minDate": 1, onSelect: function () {
         set_next_date();
         }});*/
        $('#datenext').blur(function () {
            set_next_date();
        });
        $("#next_visit").submit(function (e) {
            e.preventDefault();
            set_next_date();
        });
        function set_next_date() {
            var SET_DATE_URL = "{{route('api.evaluation.set_next_date')}}";
            var form_data = $('#next_visit').append('<input type="hidden" name="visit" value="' + VISIT_ID + '" /> ');
            form_data = form_data.append('<input type="hidden" name="user" value="' + USER_ID + '" /> ');
            $.ajax({type: "POST", url: SET_DATE_URL, data: form_data.serialize(), success: function () {
                    $('#samdate').html("<i class='fa fa-check-circle'></i> Next appointment date set");
                }
            });
        }
    });
</script>