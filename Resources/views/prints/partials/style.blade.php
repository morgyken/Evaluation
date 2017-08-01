
<style>
    @page { margin: 100px 25px; }

    *{
        font-size:14px;
        line-height:24px;
        font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color:#555;
    }

    header {
        top: 0;
        left: 0;
        right: 0;
        height: auto;
    }

    footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 30px;
        border-top: 1px solid #C1CED9;
        text-align: right;
    }

    .page-number:after {
        counter-increment: page;
        content: "Page " counter(page) " of " counter(page);
    }

    .page-number {
        text-align: right;
    }

    hr {
        page-break-after: always;
        border: 0;
    }

    .titles th{
        text-align: left;
    }

    table{
        width:100%;
    }

    table td{
        padding:2px;
    }

    table th{
        padding:5px;
        vertical-align:top;
        position: fixed;
    }

    table tr.top table td.title{
        font-size:45px;
        line-height:45px;
        color:#333;
    }


    table tr.heading td{
        background:#eee;
        border-bottom:1px solid #ddd;
        font-weight:bold;
    }

    table tr.item td{
        border-bottom:1px solid #eee;
    }

    table tr.item.last td{
        border-bottom:none;
    }

    table tr.total td:nth-child(2){
        border-top:2px solid #eee;
        font-weight:bold;
    }
</style>