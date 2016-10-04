<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>
<div class="row">
    <div class="col-md-12">
        {!! Form::open(['id'=>'prescription_form'])!!}
        <div class="box box-primary">
            <div class="box-header with-border">
                <h4 class="box-title">Prescriptions</h4>
            </div>
            <div class="box-body">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>&nbsp;</td>
                        <td>Drug</td>
                        <td colspan="2">
                            <div class="demo">
                                <div class="ui-widget">
                                    <input id="drug" type="text" name='drug'  size=58/>
                                </div>
                            </div>
                        </td>
                        <td colspan=2></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Dose</td>
                        <td width="17%"><input type="text" name="take" id="Take" size="10" />
                        </td>
                        <td width="65%">
                            {!! Form::select('prescription_whereto',mconfig('evaluation.options.prescription_whereto'),[])!!}
                            {!! Form::select('prescription_method',mconfig('evaluation.options.prescription_method'),[])!!}
                        </td>
                        <td width="10%"></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Duration</td>
                        <td colspan="4">
                            <input type="text" name="duration" placeholder="e.g 3 days" />
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td width="26%">Substitution allowed </td>
                        <td colspan="4">
                            <input type="checkbox" name="allow_substitution" value="1"/>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <button type="submit" class="btn btn-xs btn-primary" id="savePrescription"><i class="fa fa-save"></i> Save</button>
                        </td>
                    </tr>
                </table>

                @if(!$data['visits']->prescriptions->isEmpty())
                <table id="prescribed" class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Drug</th>
                            <th>Dose</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($data['visits']->prescriptions as $pres)
                        <tr>
                            <td>{{$pres->drug}}</td>
                            <td>{{$pres->take}}</td>
                            <td>{{$pres->duration}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <span class="pull-right">
                    <a class="btn btn-primary btn-xs" href="{{route('system.print.print_prescriptions',$data['visit'])}}" target="_blank">
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