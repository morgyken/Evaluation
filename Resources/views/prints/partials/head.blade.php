<html>
<head>
    <style>
        @page { margin: 180px 50px;}
        #header { position: fixed; left: 0px; top: -180px; right: 0px; height: auto; background-color: #eee; text-align: center; }
        #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 150px; background-color: #eee; }
        #footer .page:after { content: counter(page) " of " counter(page); }

        table{
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        table th{
            border: 1px solid #ddd;
            text-align: left;
            padding: 1px;
        }

        table tr:nth-child(even){background-color: #f2f2f2}

        table tr:hover {background-color: #ddd;}

        table th{
            padding-top: 1px;
            padding-bottom: 1px;
            background-color: /*#4CAF50*/ #eee;
            color: black;
        }
        .left{
            width: 40%;
            float: left;
        }
        .right{
            width: 40%;
            float: right;
        }
        .clear{
            clear: both;
        }
        img{
            width:50%;
            height: 50%/*auto*/;
            float: right;
        }
        td{
            font-size: 70%;
        }
        div #footer{
            font-size: 70%;
            float: right;
        }
        th{
            font-size: 80%;
        }
    </style>
<body>

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

<div id="header">
    <div class="left">
        <img width="200" style="float: left" src="{{realpath(base_path('/public/logo.jpg'))}}"/>
    </div>
    <div class="right">
        <table>
            <tr>
                <td>
                    <strong>{{config('practice.name')}},{{$visit->clinics->name}}<br></strong>
                    {{$clinic->bulding?$clinic->bulding.',':''}}
                    {{$clinic->street?$clinic->street.',':''}}
                    {{$clinic->town}}<br>
                    {{$clinic->address?'Address:- '.$clinic->address:''}}<br/>
                    {{$clinic->telephone?'Telephone:- '.$clinic->telephone:''}}<br/>
                    {{$clinic->mobile?'Mobile:- '.$clinic->mobile:''}}
                    <br><br>
                </td>
            </tr>
        </table>
    </div>
    <br><br>
    <br><br>
    <table>
        <tr>
            <td>
                <p>
                    <strong>PATIENT DETAILS</strong><br>
                    <strong>Patient: </strong>{{$visit->patients->full_name}}<br>
                    <strong>Patient No: </strong>{{$visit->patients->id}}<br>
                    <strong>DOB: </strong> {{$visit->patients->dob}}<br>
                    <strong>Gender: </strong> {{$visit->patients->sex}}<br>
                    <strong>Primary Number: </strong> {{$visit->patients->phone}}<br>
                </p>
            </td>
            <td>
                <p>
                    <strong>SAMPLE DETAILS</strong><br>
                    <strong>Accession number: </strong><br>
                    <strong>Registered On: </strong><br>
                    <strong>Collected On: </strong><br>
                    <strong>Received On: </strong><br>
                    <strong>Reported On: </strong><br>
                </p>
            </td>
            <td>
                <strong>CLIENT DETAILS</strong><br>
                <strong>Refered By:</strong>
                <?php try{ ?>
                {{$item->visits->external_doctors?$item->visits->external_doctors->profile->full_name:''}}<br>
                {{$item->visits->external_doctors?"(".$item->visits->external_doctors->profile->partnerInstitution->name.")":''}}
                <br/>
                <?php
                }catch(\Exception $e){

                }
                ?>
            </td>
        </tr>
    </table>

</div>