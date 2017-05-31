<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>
<div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8">
                <div class="accordion">
                    <h4>Laboratory</h4>
                    <div class="investigation_item">
                        @include('evaluation::partials.external.laboratory')
                    </div>
                    <h4>Radiology</h4>
                    <div class="investigation_item">
                        @include('evaluation::partials.external.radiology')
                    </div>
                    <h4>Ultrasound</h4>
                    <div class="investigation_item">
                        @include('evaluation::partials.external.ultrasound')
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12" id="show_selection">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h4 class="box-title">Selected procedures</h4>
                            </div>
                            <div class="box-body">
                                <div id="diagnosisTable">
                                    <table id="diagnosisInfo" class=" table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Test</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <div class="pull-right">
                                        <button class="btn btn-success" id="saveOrder">
                                            <i class="fa fa-save"></i> Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .investigation_item{
        height:400px;
        overflow-y: scroll;
    }
</style>