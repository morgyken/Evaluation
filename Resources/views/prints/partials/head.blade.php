<?php
extract($data);
$patient = $data['visit']->patients;
$dob = \Carbon\Carbon::parse($patient->dob);
$age_days = $dob->diffInDays();
$age_str = (new Date($dob))->diff(Carbon\Carbon::now())->format('%y years, %m months and %d days');
$age_years = $dob->age;
$item = $data['results'];
$clinic = $visit->clinics;
?>
<header>
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="5">
                <table>
                    <tr>
                        <td class="title">
                            <img width="200" src="{{realpath(base_path('/public/logo.jpg'))}}"/>
                        </td>
                        <td style="text-align: right">
                            <small>
                                <strong><?php echo ucfirst(config('practice.name')) ?>, {{ ucfirst($visit->clinics->name)}}<br></strong>
                                {{$clinic->telephone?'Tel:- '.$clinic->telephone:','}}
                                {{$clinic->mobile?', '.$clinic->mobile:''}}<br/>
                                {{$clinic->email?'Email:- '.$clinic->email:''}}
                            </small>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="5">
                <table>
                    <tr>
                        <td style="text-align: center">
                            <strong><h1 style="font-weight: bolder; font-size: 14px">Lab Report</h1></strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="border-bottom: 1px black" class="information">
            <td colspan="5">
                <table>
                    <tr>
                        <td>
                                <strong style="float: top">Patient Details</strong><br>
                                Name: {{$visit->patients->full_name}}.<br>
                                Patient No: {{$visit->patients->id}}<br>
                                DOB: {{smart_date($visit->patients->dob)}},
                                {{$visit->patients->sex}}<br>
                        </td>
                        <td style="padding-left: 10%; font-size: 6px">
                            <small>
                                <strong style="float: top">Sample Details</strong><br>
                                Visit Number: 00{{$visit->id}}<br>
                                Registered: {{smart_date($visit->created_at)}}<br>
                                Collected: {{smart_date_time($visit->updated_at)}}<br>
                                Received: {{smart_date_time($visit->created_at)}}<br></small>
                        </td>
                        <td style="text-align: right">
                                <strong style="float: top">Client Details</strong><br>
                                <?php try{ ?>
                                {{$item->visits->external_doctors?$item->visits->external_doctors->profile->full_name:''}}<br>
                                {{$item->visits->external_doctors?"(".$item->visits->external_doctors->profile->partnerInstitution->name.")":''}}
                                <br/>
                                <?php
                                }catch(\Exception $e){ ?>
                                <span style="float:top">Name : {{$visit->patients->full_name}}<br></span>
                                <span>Tel : {{$visit->patients->mobile}}<br></span>
                                <span>Email : {{$visit->patients->email}}<br></span>
                                <?php
                                }
                                ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</header>
<br>