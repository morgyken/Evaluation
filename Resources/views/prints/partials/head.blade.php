<style>
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
        background-color: /*#4CAF50*/ #BBBBBB;
        color: white;
    }
    .left{
        width: 60%;
        float: left;
    }
    .right{
        float: left;
        width: 40%;
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
    }
    th{
        font-size: 80%;
    }
</style>
<div class="box box-info">
    <div class="left">
        <p>
            <strong>{{config('practice.name')}}</strong><br/>
            {{config('practice.building')}},
            {{config('practice.street')?config('practice.street').',':''}}<br/>
            {{config('practice.town')}}<br>
            {{config('practice.telephone')?'Call Us:- '.config('practice.telephone'):''}}<br/>
            {{config('practice.email')?'Email:- '.config('practice.email'):''}}
        </p>
    </div>
    <div class="right">
        <img src="{{realpath(base_path('/public/logo.png'))}}"/>
    </div>
    <div class="clear"></div>
    <div class="content">
        <div id="content">
            <div class="box-body">
