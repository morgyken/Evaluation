<?php
/**
 * Created by PhpStorm.
 * User: bravo
 * Date: 7/27/17
 * Time: 10:27 AM
 */
?>
<style>

    body {
        color: #001028;
        background: #FFFFFF;
        font-family: Arial, sans-serif;
        font-size: 12px;
        font-family: Arial;
    }

    header {
        padding: 10px 0;
        margin-bottom: 10%;
        position: fixed;
        height: auto;
    }

    #logo {
        text-align: center;
        margin-bottom: 10%;
        width: 100%;
    }

    #logo img {
        width: 90px;
        float: left;
    }

    #project {
        float: left;
    }

    #project span {
        color: #5D6975;
        text-align: right;
        width: 52px;
        margin-right: 10px;
        display: inline-block;
        font-size: 0.8em;
    }

    #company {
        float: right;
        text-align: right;
    }

    #project div,
    #company div {
        white-space: nowrap;
    }

    table {
        width: 100%;
        border-spacing: 0;
        margin-bottom: 20px;
    }

    table tr:nth-child(2n-1) td {
        /*background: #F5F5F5;*/
    }


    table th {
        border-bottom: 1px solid #eee;
        font-weight: bolder;
        text-align: left;
    }

    .topper td {
        padding: 20px;
    }

    table td {
        text-align: left;
    }

    #notices .notice {
        color: black;
        font-size: 1.2em;
    }

    footer {
        width: 100%;
        bottom: 0;
        border-top: 1px solid #C1CED9;
        position: fixed;
        left: 0px;
        right: 0px;
        height: 30px;
    }

    footer .page:after { content: counter(page) " of " counter(page); }
    footer .page{
        text-align: right;
    }

    footer .info{
        text-align: left;
    }

    .key{
        float: left;
    }

    .key li{
        display: inline;
        text-align: left;
    }
</style>
