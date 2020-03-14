<!DOCTYPE html>
<html>

<head>
    <title>Event Booking System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>


    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
    .error {
        color: red;
    }
</style>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">Book your ticket now</div>
            <div class="card-body">
                <h5 class="card-title text-center">The Greek Campus Event</h5>
                <div id="messages"></div>
                <form class="form" method="POST" action="javascript:void(0)" id="form-data">
                    {{csrf_field()}}
                    <div class="alert alert-success d-none" id="msg_div">
                        <span id="res_msg"></span>
                    </div>
                    <div class="form-group" id='name'>
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Please enter your name">

                    </div>
                    <div class="form-group" id='email'>
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" id="e" placeholder="Please enter your email address">
                        <span id="error_email"></span>
                    </div>
                    <div class="form-group" id='phone'>
                        <label>Mobile number</label>
                        <input type="text" class="form-control" name="mobile_number" id="mobile_number" placeholder="Please enter your phone number">

                    </div>
                    <div class="form-group" id='type'>
                        <label>Ticket type</label>
                        <span class="small">Student/Normal</span>
                        <select class="custom-select mr-sm-2" name="ticket_type" id="ticket_type">
                            <option class="form-control" value="student"> Student Ticket for 200 EGP </option>
                            <option class="form-control" value="normal"> Normal Ticket for 400 EGP </option>
                        </select>
                        <span id="error_ticket"></span>
                    </div>

                    <button type="submit" class="center btn btn-primary" id="send-form">Submit</button>
                </form>
            </div>

        </div>

    </div>


</body>


<script type="text/javascript">
    $(document).ready(function() {
        // $(":input").attr('autocomplete', 'off');

        // $(":input").css('box-shadow', 'none');
        // $("#e").blur(function() {
        //     alert("This input field has lost its focus.");
        // });
        $('#ticket_type').blur(function() {
            $.ajax({
                method: 'POST',
                url: '{{url("book.ticketNumber")}}',
                data: $('#form-data').serialize(),
                success: function(result) {
                    if (result == "invalid") {
                        $('#send-form').attr('disabled', 'disabled');
                        $('#error_ticket').html("<label class='text-danger'>Sorry Tickets are sold out</label>");

                    }
                }

            });
        });

        $('#e').blur(function() {

            var error_email = "";
            var email = $('#email').val();
            var _token = $('input[name="_token"]').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: 'POST',
                url: "{{url('book.check')}}",
                //  dataType: email,
                data: $('#form-data').serialize(),
                success: function(result) {
                    if (result == "unique") {
                        $('#error_email').html('<label class="text-success">Email Available</label>');
                        $('#send-form').attr('disabled', false);
                    } else {
                        $('#error_email').html('<label class="text-danger">Email not Available</label> ');
                        $('#send-form').attr('disabled', 'disabled');

                    }
                }
            });
        });

        $('#form-data').validate({
            rules: {

                name: {
                    required: true
                },

                email: {

                    required: true,
                    email: true,

                },

                mobile_number: {
                    required: true,
                    digits: true
                },

                ticket_type: {
                    required: true,
                },
            }

        });



        $('#send-form').click(function(e) {

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#send-form').html('Booking...');
            $.ajax({
                method: 'POST',
                url: "{{url('book')}}",
                data: $('#form-data').serialize(),
                success: function(response) {
                    $('#send-form').html('Submit');
                    $('#res_msg').show();
                    $('#res_msg').html(response.msg);
                    $('#msg_div').removeClass('d-none');

                    document.getElementById("form-data").reset();
                    setTimeout(function() {
                        $('#res_msg').hide();
                        $('#msg_div').hide();
                    }, 10000);
                }



            });
        });
    });
</script>

</html>