
var check = function ()
{
    document.getElementById("dugme").disabled = true;
    document.getElementById("mess").innerHTML = "Nije potvrdjeno";
    document.getElementById('mess').style.color = 'red';
    if(document.getElementById('pas1').value == document.getElementById('pas2').value)
    {
        document.getElementById("mess").innerHTML = "Potvrdjeno";
        document.getElementById('mess').style.color = 'green';
        document.getElementById("dugme").disabled = false;
    }
}

function editMail()
{
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

    document.getElementById("dugme").disabled = false;
    document.getElementById("mejl").innerHTML = "Unos je ispravan!";
    document.getElementById('mejl').style.color = 'green';
    if(reg.test(form.email.value)==false)
    {
        document.getElementById("dugme").disabled = true;
        document.getElementById("mejl").innerHTML = "Unos nije ispravan!";
        document.getElementById('mejl').style.color = 'red';
        return false;
    }
    return true;
}

function messageDelete(id)
{
    var r = confirm("Da li ste sigurni da želite obrisati ovog korisnika?");
    if (r == true)
    {
        window.location = 'index.php?view=deleteuser&id='+id;
    }
}

function pickeredit(){
    $("#date").datepicker(/*{ beforeShowDay: $.datepicker.noWeekends }*/);
    $("#date1").datepicker();
}

function checkforblank()
{
        if ($('#rola').val() == "") {
            alert("Id role je obavezno polje za unos!");
            return false;
        }
        if ($('#place').val() == "") {
            alert("Id radnog mjesta je obavezno polje za unos!");
            return false;
        }
        if ($('#org_list').val() == "") {
            alert("Organizaciona jedinica je obavezno polje za unos!");
            return false;
        }
        if ($('#name').val() == "") {
            alert("Ime je obavezno polje za unos!");
            return false;
        }
        if ($('#lastname').val() == '') {
            alert("Prezime je obavezno polje za unos!");
            return false;
        }
        if ($('#email').val() == '') {
            alert("Email je obavezno polje za unos!");
            return false;
        }
        if($('#date').val() == '') {
            alert("Datum zasnivanja radnog odnosa je obavezno polje za unos!");
            return false;
        }
        if($('#year').val() == '') {
            alert("Godine radnog staza je obavezno polje za unos!");
            return false;
        }
}

function checkPlace()
{
    if ($('#name').val() == "") {
        alert("Naziv radnog mjesta je obavezno polje za unos!");
        return false;
    }
}

function placeDelete(id)
{
    var r = confirm("Da li ste sigurni da želite obrisati ovo radno mjesto?");
    if (r == true)
    {
        window.location = 'index.php?view=deleteplace&id='+id;
    }
}

function requestDelete(id)
{
    var r = confirm("Da li ste sigurni da želite obrisati ovaj zahtjev?");
    if (r == true)
    {
        window.location = 'index.php?view=deleterequest&id='+id;
    }
}

function ownrequestDelete(id)
{
    var r = confirm("Da li ste sigurni da želite obrisati ovaj zahtjev?");
    if (r == true)
    {
        window.location = 'index.php?view=deleteownrequest&id='+id;
    }
}

function checkPass()
{
    var pas=document.getElementById( "pas" ).value;
    var forma = $("#form");

     $.ajax({
         url: "/pavle_projekat/views/editprofile.php?old_pswd=true",
         method: "POST",
         dataType: 'json',
         data: forma.serialize(),
         success:function(data){
             if (data.status == true) {
                 forma.submit();
             }
             else
             {
                $("#message").html("Pogresna sifra!");
                $("#message").attr('hidden',false);
             }
         },
         error:function(data, txtStatus, xhrObject) {
             alert(txtStatus);
         }

     })
 }

function checkDates(minus)
{
    var oneDay = 24*60*60*1000;
    var startDate = $('#date').datepicker('getDate');
    var endDate = $('#date1').datepicker('getDate');
    var count = 0;
    var curDate = startDate;
    while (curDate <= endDate) {
        var dayOfWeek = curDate.getDay();
        if(!((dayOfWeek == 6) || (dayOfWeek == 0)))
            count++;
        curDate.setDate(curDate.getDate() + 1);
    }
    //var noOfDays = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
    var type = $('#first').val();
    var btn = $('#button');

        if(type=='Da' && count<10)
        {
            btn.attr('disabled', true);
            $('#mes').attr('hidden', false);
            $('#mes').html('Za prvi dio odmora minimalan broj dana je 10!');
        }
        else if(minus<count)
        {
            btn.attr('disabled', true);
            $('#mes').attr('hidden', false);
            $('#mes').html('Preostalo je '+minus+' dana!');
        }
        else
        {
            $('#mes').attr('hidden', true);
            btn.attr('disabled', false);
        }

}
function editRequest($id)
{
    var employee_id = $id;
    var modal = $('#data_Modal');
    $.ajax({
        url:"/pavle_projekat/views/editrequest.php",
        method:"post",
        data:{employee_id:employee_id},
        success:function(data){
            $('#employee_detail').html(data);
            modal.modal("show");
        }
    });
}

$(document).ready(function(){

    $(function(){
        $("#date").datepicker({ beforeShowDay: $.datepicker.noWeekends,
            minDate: date,
            maxDate: (date.getFullYear()+1)+'-06-30'});
        $("#date1").datepicker({ beforeShowDay: $.datepicker.noWeekends,
            minDate: date,
            maxDate: (date.getFullYear()+1)+'-06-30'});
    });

    $("#search_text").keyup(function(){
        var search1 = $("#search_text").val();
        var rez = $("#result");
        var gif = $("#gif");
        if(search1=='')
        {
            window.location="index.php?view=userslist";
        }
        else
        {
            gif.show();
            $.ajax(
                {
                    url: "/pavle_projekat/views/fetch.php?search="+search1,
                    method: "get",
                    dataType: "text",
                    success:function(data)
                    {
                        gif.hide();
                        rez.html(data);
                    }
                });
        }
    })


    $("#search_place").keyup(function(){
        var searchp = $("#search_place").val();
        var rez = $("#result_place");
        var gif = $("#gif");
        if(searchp=='')
        {
            window.location="index.php?view=workplaceslist";
        }
        else
        {
            gif.show();
            $.ajax(
                {
                    url: "/pavle_projekat/views/searchp.php?search="+searchp,
                    method: "get",
                    dataType: "text",
                    success:function(data)
                    {
                        gif.hide();
                        rez.html(data);
                    },
                    error:function(data, txtStatus, xhrObject) {
                        alert(txtStatus);}
                });
        }
    })

    $('#button').click(function(){
        event.preventDefault();
        var modal = $('#add_data_Modal');
        var forma = $("#insert");
            $.ajax({
                url:"/pavle_projekat/views/insert.php",
                method:"post",
                dataType: 'json',
                data: forma.serialize(),
                success:function(data){
                    if(data.status==true)
                    {
                        forma.submit();
                        modal.modal('hide');
                    }
                    else
                    {
                        $("#mes").html("Niste unijeli sve podatke!");
                        $("#mes").attr('hidden',false);
                    }

                }
            });
    });

    var date = new Date();
    $.datepicker.setDefaults({
        dateFormat: 'yy-mm-dd'
        /*beforeShowDay: $.datepicker.noWeekends,
        minDate: date,
        maxDate: (date.getFullYear()+2)+'-06-30'*/
    });

    $(function(){
        $("#from_date").datepicker();
        $("#to_date").datepicker();
    });
    $('#filter').click(function(){
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        if(from_date != '' && to_date != '')
        {
            $.ajax({
                url:"/pavle_projekat/views/filter.php?d1="+from_date+"&d2="+to_date,
                method:"GET",
                dataType: "text",
                success:function(data)
                {
                    $('#date_filter').html(data);
                }
            });
        }
        else
        {
            alert("Izaberi datum!");
        }
    });

    $('#filter_own').click(function(){
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        if(from_date != '' && to_date != '')
        {
            $.ajax({
                url:"/pavle_projekat/views/filterforownlist.php?d1="+from_date+"&d2="+to_date,
                method:"GET",
                dataType: "text",
                success:function(data)
                {
                    $('#date_filter').html(data);
                }
            });
        }
        else
        {
            alert("Izaberi datum!");
        }
    });


    var form = $('#formica').html();
    $('#formica').html('');
    $('[data-toggle="popover"]').popover({
        title: "Dodaj radno mjesto",
        placement: 'right',
        html: true,
        content: form,
        container: 'body'
    });

    $('body').on('click','button#add' ,function(){
        var forma = $("form#popover_forma").serialize();
        var popover_div=$('#popover_div');
        $.ajax({
            url:"/pavle_projekat/views/placeinmodal.php",
            type:"post",
            dataType: 'json',
            data: forma,
            success:function(data){
                if(data.status==true)
                {
                    popover_div.html(data.content);
                    $('[data-toggle="popover"]').popover('hide');
                }
                else
                {
                    $("#mes").html("Uneiste naziv!");
                    $("#mes").attr('hidden',false);
                }

            },error:function(data, txtStatus, xhrObject) {
                alert(txtStatus);}
        });
    });

    $('body').on('click','button#close' ,function(){
        $('[data-toggle="popover"]').popover('hide');
    });


    function showNotification(msg) {
        // Let's check if the browser supports notifications
        if (!("Notification" in window)) {
            alert("This browser does not support desktop notification");
        }

        // Let's check whether notification permissions have already been granted
        else if (Notification.permission === "granted") {
            // If it's okay let's create a notification
            var notification = new Notification(msg);
        }

        // Otherwise, we need to ask the user for permission
        else if (Notification.permission !== "denied") {
            Notification.requestPermission().then(function (permission) {
                // If the user accepts, let's create a notification
                if (permission === "granted") {
                    var notification = new Notification(msg);
                }
            });
        }

    }

});












<<<<<<< HEAD


=======
>>>>>>> 7f18819a3ab94576c208b058c75d23f89b92abff
