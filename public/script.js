// wait for DOM to load
$(() => {
    $("#form-vaild").validate({
        rules: {
            firstname: {
                required: true,
                minlength: 3,
                maxlength: 150
            },
            lastname: {
                required: true,
                minlength: 3,
                maxlength: 150
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 8,
                passwordvaild: true
            },
            confirm_password: {
                required: true,
                minlength: 8,
                equalTo: '[name="password"]'
            },
            photo: {
                imgcheck: true
            },
            terms: {
                required: true
            }
        },
        messages: {
            password: {
                passwordvaild: "password must conain characters and numbers"
            },
            photo: {
                imgcheck: "Image must be png or jpg",
                required: false
            }
        }
    });
    $.validator.addMethod("passwordvaild", function(value) {
        return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/.test(value);
    });
    $.validator.addMethod("imgcheck", function(value, element) {
        return this.optional(element) || (/\.(jpg||png)$/i).test(value);
    });
})