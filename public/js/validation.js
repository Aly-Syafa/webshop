jQuery(document).ready(function($){

    var base_url = location.protocol + "//" + location.host+"/";

    $( "#login" ).validate({
        rules: {
            password: "required",
            password_confirmation: {equalTo: "#password"},
            email: {
                required: true,
                email: true,
                remote: {
                    url: base_url + "check/email",
                    type: "post",
                    data: {
                        email: function() {
                            return $( "#email" ).val();
                        },
                        _token: $("meta[name='_token']").attr('content')
                    }
                }
            },
        }
    });

    $( "#registeraccount" ).validate({
        rules: {
            first_name: "required",
            last_name: "required",
            adresse: "required",
            ville: "required",
            npa: "required",
            password: "required",
            password_confirmation: {equalTo: "#password"},
            email: {
                required: true,
                email: true,
                remote: {
                    url: base_url + "check/email",
                    type: "post",
                    data: {
                        email: function() {
                            return $( "#email" ).val();
                        },
                        _token: $("meta[name='_token']").attr('content')
                    }
                }
            },
        }
    });


    $( "#subscribe" ).validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        errorElement : 'div',
        errorPlacement: function(error, element)
        {
            if (element.is(":text"))
            {
                error.prependTo(element.closest('.form'));
            }
            else
            { // This is the default behavior of the script for all fields
                error.insertAfter(element);
            }
        }
    });


    var $billing = $("#billing");

    if($billing.length){

        $billing.validate({
            focusInvalid: false,
            rules: {
                first_name: "required", last_name: "required", adresse: "required", ville: "required", npa: "required",
                email: {
                    required: true,
                    email: true
                }
            }
        }).form();

        $billing.validate({
            focusInvalid: false,
            rules: {
                first_name: "required", last_name: "required", adresse: "required", ville: "required", npa: "required",
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: base_url + "check/email",
                        type: "post",
                        data: {
                            email: function() {
                                return $( "#email" ).val();
                            },
                            _token: $("meta[name='_token']").attr('content')
                        }
                    }
                }
            }
        });
    }

    $( "#colloque-inscription" ).validate({
        errorElement : 'div',
        errorPlacement: function(error, element)
        {
            if (element.is(":radio") || element.is(":checkbox")) {
                error.prependTo(element.parent());
            } else { // This is the default behavior of the script for all fields
                error.insertAfter(element);
            }
        }
    });
});

