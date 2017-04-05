$(document).ready(function () {
    //$('#myModal').modal('show');
    $(window).on('beforeunload', function () {
        console.log("beforeUnload event!");
    });
});
/*
 $(function () {
 alert('Bye.');
 $(window).unload(function () {
 alert('Bye.');
 //$('#myModal').modal('show');
 });
 });*/

