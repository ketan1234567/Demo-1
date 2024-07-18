$(document).ready(function () {


    //ajax request for reterving Data
    let output = "";
    function showData(page = 1) {
    //alert(page);
    $.ajax({
        url: `retreive.php?page=${page}`,
        method: 'GET',
        dataType: "json",
        success: function (data) {
            if (data && data.data) {
                let x = data.data;

                for (let i = 0; i < x.length; i++) {
                    output +=
                        `<tr>
                            <td>${x[i].id}</td>
                            <td>${x[i].name}</td>
                            <td>${x[i].email}</td>
                            <td>${x[i].password}</td>
                            <td>
                                <button class='btn btn-warning btn-sm btn-edit' data-sid="${x[i].id}">Edit</button>
                                <button class='btn btn-danger btn-sm btn-del' data-sid="${x[i].id}">Delete</button>
                            </td>
                        </tr>`;
                }
                $('#tbody').html(output);
            } else {
                $('#tbody').html("<tr><td colspan='5'>No data found</td></tr>");
            }
        },
        error: function (xhr, status, error) {
            console.error("An error occurred: " + status + " " + error);
            $('#tbody').html("<tr><td colspan='5'>Error retrieving data</td></tr>");
        }
    });

}

const urlParams = new URLSearchParams(window.location.search);

const page = urlParams.get('page');

//alert(page);
showData(page)



    //insert code to jquery
    $('#btn').click(function (e) {
        //alert("btn");
        e.preventDefault();
        let stid = $("#stuid").val()
        let fn = $('#name').val()
        let em = $('#email').val()
        let pm = $('#password').val()

        mydata = { id: stid, name: fn, email: em, password: pm }


        //console.log(mydata);
        $.ajax({
            url: "insert.php",
            method: 'POST',
            data: JSON.stringify(mydata),
            success: function (data) {
                msg = "<div class='alert alert-dark mt-3'>" + data + "</div>";
                $('#msg').html(data);
                $('#myform')[0].reset();

                showData();

            }
        });



    });

    //delete code from ajax

    $("tbody").on("click", ".btn-del", function () {
        let id = $(this).attr("data-sid");
        //console.log(id);

        mydata = { sid: id }
        mythis = this;
        $.ajax({

            url: "delete.php",
            method: "POST",
            data: JSON.stringify(mydata),
            success: function (data) {
                console.log(data);

                if (data == 1) {
                    msg = "<div class='alert alert-dark mt-3'>student Deleted Sucessfully</div>";

                } else if (data == 0) {
                    msg = "<div class='alert alert-dark mt-3'>Unable to deleted student</div>";
                }
                $("#msg").html(msg)
            }
        });


    });


    $("tbody").on("click", ".btn-edit", function () {

        let id = $(this).attr("data-sid");
        // console.log("edit button clicked",id);

        mydata = { sid: id }

        $.ajax({

            url: "edit.php",
            method: "post",
            data: JSON.stringify(mydata),
            success: function (data) {
                $("#stuid").val(JSON.parse(data).id)
                $("#name").val(JSON.parse(data).name)
                $("#email").val(JSON.parse(data).email)
                $("#password").val(JSON.parse(data).password)
            }
        });



    });

});