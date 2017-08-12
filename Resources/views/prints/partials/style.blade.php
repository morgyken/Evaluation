<style type="text/css">

    @page {
        margin: 2cm;
    }

    *{
        font-size:14px;
        /* line-height:24px;*/
        font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }

    body {
        font-family: sans-serif;
        margin: 0.5cm 0;
        text-align: justify;
    }

    #header,
    #footer {
        position: fixed;
        left: 0;
        right: 0;
        color: #aaa;
        font-size: 0.9em;
    }

    #header {
        top: 0;
        /*border-bottom: 0.1pt solid #aaa;*/
    }

    #header_2 {
        border-bottom: 1pt solid deepskyblue;
        border-top: 1pt solid deepskyblue;
    }

    #key {
        border-bottom: 0.1pt solid deepskyblue;
        border-top: 0.1pt solid deepskyblue;
        border-right: 0.1pt solid deepskyblue;
        border-left: 0.1pt solid deepskyblue;
        text-align: center;
        font-weight: bolder;
        width: 70%;
        margin-left: 20%;
    }

    #footer {
        bottom: 0;
        border-top: 0.1pt solid deepskyblue;
    }

    #header table,
    #footer table {
        width: 100%;
        border-collapse: collapse;
        border: none;
        color: black;
    }

    #header td,
    #footer td {
        padding: 0;
        width: 50%;
    }

    .page-number {
        text-align: right;
        color:black;
    }

    .page-number:before {
        content: "Page " counter(page) " of " counter(page);
    }

    hr {
        page-break-after: always;
        border: 0;
    }

    table{
        width:100%;
    }

    table tr.heading td{
        background:#eee;
        border-bottom:1px solid #ddd;
        font-weight:bold;
    }

    table td{
        padding:1px;
    }

    #results td{
        font-size: 11px;
    }

</style>