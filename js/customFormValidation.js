jQuery.validator.addMethod("noSpace", function (value, element) {
    return value.indexOf(" ") < 0 && value != "";
}, "This field is required.");
$('#rollco_login_form').validate({// initialize the plugin
    rules: {
        email: {
            required: true,
            email: true,
            noSpace: true
        },
        password: {
            required: true,
            noSpace: true,
            minlength: 6
        },
        
    },
    messages: {
        email: "Please enter valid email",
        password: "Please enter valid password",
    },
});