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
            <ul class="nav nav-tabs">
                <li class="active"><a href="#laser"  data-toggle="tab">REFRACTIVE LASER SURGERY</a></li>
                <li><a href="#pterygium" data-toggle="tab">PTERYGIUM EXCISION</a></li>
                <li><a href="#keratoplasty" data-toggle="tab">PENETRATING KERATOPLASTY</a></li>
                <li><a href="#cataract" data-toggle="tab">CATARACT SURGERY</a></li>
                <li><a href="#yag" data-toggle="tab">YAG LASER</a></li>
                <li><a href="#cross_linking" data-toggle="tab">CROSS LINKING</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="laser">
                    @include('evaluation::partials.theatre.laser')
                </div>
                <div class="tab-pane" id="pterygium">
                    @include('evaluation::partials.theatre.pterygium')
                </div>
                <div class="tab-pane" id="keratoplasty">
                    @include('evaluation::partials.theatre.keratoplasty')
                </div>
                <div class="tab-pane" id="cataract">
                    @include('evaluation::partials.theatre.cataract')
                </div>
                <div class="tab-pane" id="yag">
                    @include('evaluation::partials.theatre.yag')
                </div>
                <div class="tab-pane" id="cross_linking">
                    @include('evaluation::partials.theatre.cross_linking')
                </div>
            </div>
        </div>
    </div>
</div>