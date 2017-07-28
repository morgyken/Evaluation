<div id="header">
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
    <div id="logo">
        <img src="{{realpath(base_path('/public/logo.jpg'))}}"/>
        <div style="float: right">
            <address>
                <strong>{{config('practice.name')}}, {{$visit->clinics->name}}<br></strong>
                Visit us at: {{$clinic->bulding?$clinic->bulding.',':''}}<br>
                {{$clinic->street?$clinic->street.',':''}}
                {{$clinic->town}}<br>
                {{$clinic->address?'Address:- '.$clinic->address:''}}<br/>
                {{$clinic->telephone?'Telephone:- '.$clinic->telephone:''}}<br/>
                {{$clinic->mobile?'Mobile:- '.$clinic->mobile:''}}
            </address>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <table class="topper">
        <tr>
            <td style="text-align: left">
                <strong style="float: top">Patient Details</strong><br>
                <address>
                    Names: {{$visit->patients->full_name}}.<br>
                    Patient No: {{$visit->patients->id}}<br>
                    DOB: {{$visit->patients->dob}}<br>
                    Gender: {{$visit->patients->sex}}<br>
                    Primary Number: {{$visit->patients->phone}}
                </address>
            </td>
            <td style="text-align: left">
                <strong style="float: top">Sample Details</strong><br>
                <address>
                    Visit Number: 00{{$visit->id}}<br>
                    Registered On: {{$visit->created_at}}<br>
                    Collected On: {{$visit->updated_at}}<br>
                    Received On: {{$visit->created_at}}<br>
                    Reported On:
                </address>
            </td>
            <td style="text-align: left">
                <strong style="float: top">Client Details</strong>
                <address>
                    <?php try{ ?>
                    {{$item->visits->external_doctors?$item->visits->external_doctors->profile->full_name:''}}<br>
                    {{$item->visits->external_doctors?"(".$item->visits->external_doctors->profile->partnerInstitution->name.")":''}}
                    <br/>
                    <?php
                    }catch(\Exception $e){ ?>
                        <span style="float:top">Self : {{$visit->patients->full_name}}<br></span>
                    <?php
                    }
                    ?>
                </address>
            </td>
        </tr>
    </table>
</div>