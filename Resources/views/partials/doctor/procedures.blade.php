<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */

$performed = get_investigations($visit, ['treatment']);
$discount_allowed = json_decode(m_setting('evaluation.discount'));

$co = null;
$visit = \Ignite\Evaluation\Entities\Visit::find($visit->id);
if ($visit->payment_mode == 'insurance') {
    $co = $visit->patient_scheme->schemes->companies->id;
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-8">
            <div class="accordion">
                <h4>Doctor Procedures</h4>
                <div class="treatment_item">
                    @include('evaluation::partials.doctor.procedures-doctor')
                </div>
                <h4>Nurse Procedures</h4>
                <div class="treatment_item">
                    @include('evaluation::partials.doctor.procedures-nursing')
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12" id="selected_treatment">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h4 class="box-title">Selected procedures</h4>
                        </div>
                        <div class="box-body">
                            <table id="treatment" class=" table table-condensed">
                                <thead>
                                <tr>
                                    <th>Procedure</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="pull-right">
                                <button class="btn btn-success" id="saveTreatment"><i class="fa fa-save"></i> Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <br/>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header">
                <h4 class="box-title">Previously administered procedures</h4>
            </div>
            <div class="box-body">
                @if(!$performed->isEmpty())
                    <table class="table table-condensed">
                        <thead>
                        <tr>
                            <th>Procedure</th>
                            <th>Price</th>
                            <th>Number Performed</th>
                            <th>Discount(%)</th>
                            <th>Amount</th>
                            <th>Payment</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php try { ?>
                        @foreach($performed as $item)
                            <?php try { ?>
                            <tr>
                                <td>{{str_limit($item->procedures->name,40,'...')}}</td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->quantity}}</td>
                                <td>{{$item->discount}}</td>
                                <td>
                                    <?php try { ?>
                                    @if($item->amount>0)
                                        {{$item->amount}}
                                    @else
                                        {{$item->price}}
                                    @endif
                                    <?php } catch (Exception $ex) { ?>

                                        <?php } ?>
                                </td>
                                <td>{!! payment_label($item->is_paid) !!}</td>
                            </tr>
                            <?php
                            } catch (Exception $ex) {

                            }
                            ?>
                        @endforeach
                        <?php
                        } catch (Exception $ex) {

                        }
                        ?>
                        </tbody>
                    </table>
                @else
                    <p class="text-info"><i class="fa fa-info"></i> No previous treatment</p>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- -->
<style>
    #treatment_form {
        height: 400px;
        overflow-y: scroll;
    }

    .treatment_item {
        overflow: auto;
    }
</style>
<script type="text/javascript">
    $(function () {
        $('#treatment_form').find('input').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
