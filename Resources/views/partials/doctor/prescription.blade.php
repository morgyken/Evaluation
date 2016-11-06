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
            {!! Form::open(['id'=>'prescription_form'])!!}
            {!! Form::hidden('visit',$visit->id) !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Prescriptions</h4>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label col-md-4">Drug</label>
                        <div class="col-md-8">
                            <input id="drug" type="text" name='drug' class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Dose</label>
                        <div class="col-md-8">
                            <div class="col-md-4">
                                <input type="text" name="take" id="Take" class="form-control"/>
                            </div>
                            <div class="col-md-4">
                                {!! Form::select('prescription_whereto',mconfig('evaluation.options.prescription_whereto'),null,['class'=>'form-control'])!!}
                            </div>
                            <div class="col-md-4">
                                {!! Form::select('prescription_method',mconfig('evaluation.options.prescription_method'),null,['class'=>'form-control'])!!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Duration</label>
                        <div class="col-md-8" >
                            <input type="text" name="duration" placeholder="e.g 3 days" class='form-control'/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-md-offset-4 col-md-8"><input type="checkbox" name="allow_substitution" value="1"/> Substitution allowed</label>
                    </div>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-xs btn-primary" id="savePrescription">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>

                    @if(!$visit->prescriptions->isEmpty())
                    <table id="prescribed" class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Drug</th>
                                <th>Dose</th>
                                <th>Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($visit->prescriptions as $pres)
                            <tr>
                                <td>{{$pres->drug}}</td>
                                <td>{{$pres->take}}</td>
                                <td>{{$pres->duration}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <span class="pull-right">
                        <a class="btn btn-primary btn-xs"
                           href="{{route('system.print.print_prescriptions',$data['visit'])}}" target="_blank">
                            <i class="fa fa-print"></i> Print</a>
                    </span>
                    @else
                    <i class="fa fa-info-circle"></i> No previously administered prescriptions
                    @endif
                </div>

            </div>
            {!! Form::close()!!}
        </div>
    </div>
</div>