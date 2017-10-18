<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Revenue Per Department</h3>
        </div><!-- /.box-header -->
        <div class="box-body no-padding">
            {{Form::open(['method'=>'get'])}}
            <div class="form-inline">
                <div class="form-group">
                    <label for="email">From:</label>
                    <input type="text" class="form-control input-sm days" value="{{request('rpd_from')}}"
                           name="ppd_from"/>
                </div>
                <div class="form-group">
                    <label for="email">To:</label>
                    <input type="text" class="form-control input-sm days" value="{{request('rpd_to')}}" name="ppd_to"/>
                </div>
                <input type="hidden" name="section" value="patients_pd"/>
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            </div>
            {{Form::close()}}
            <div class="charts" style="background: inherit;">
                <div data-duration="500" class="charts-loader enabled"
                     style="display: none; position: relative; top: -30px; height: 0;">
                    <center>
                        <div class="loading-spinner"
                             style="border: 3px solid #000000; border-right-color: transparent;"></div>
                    </center>
                </div>
                <div class="charts-chart">
                    <div id="revenue_pd" style=""></div>
                </div>
            </div>

            {!!$revenue_pd_chart->script() !!}
        </div><!-- /.box-body -->
        <div class="box-footer">
        </div><!-- /.box-header -->
    </div>
    <script>
        $(function () {
            $('.days').datepicker({maxDate: '0', dateFormat: 'yy-m-d'});
        });
    </script>
</div>