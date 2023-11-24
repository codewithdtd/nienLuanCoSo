$(document).ready(function () {
    $('.register-form').validate({
        rules: {
            fullname: 'required',
            birthday: 'required',
            // email: {email: true },  
            phone: { required: true, minlength: 10 },
            password: { required: true, minlength: 8 },
            password_confirm: {
                required: true,
                minlength: 8,
                equalTo: '.user__password',
            },
            address: 'required',
        },
        messages: {
            fullname: 'Bạn chưa nhập vào họ tên',
            birthday: 'Bạn chưa nhập ngày sinh',
            phone: { 
                required: 'Bạn chưa nhập vào số điện thoại', 
                minlength: 'Số điện thoại phải có đủ 10 chữ số', 
            },
            // email: 'Email không hợp lệ',
            password: { 
                required: 'Bạn chưa nhập mật khẩu', 
                minlength: 'Mật khẩu phải có ít nhất 8 ký tự',
            },
            password_confirm: {
                required: 'Bạn chưa nhập mật khẩu',
                minlength: 'Mật khẩu phải có ít nhất 8 ký tự',
                equalTo: 'Mật khẩu không trùng với mật khẩu đã nhập',
            },
            address: 'Bạn phải nhập địa chỉ của bạn',
        },
        errorClass: "error", // Lớp CSS khi có lỗi
        success: function(label) {
            label.addClass("valid"); // Lớp CSS khi validation thành công
          }, 
    });

    $('.login-form').validate({
        rules: {  
            phone: { required: true, minlength: 10 },
            password: { required: true, minlength: 8 },
        },
        messages: {
            phone: { 
                required: 'Bạn chưa nhập vào số điện thoại', 
                minlength: 'Số điện thoại phải có đủ 10 chữ số', 
            },
            password: { 
                required: 'Bạn chưa nhập mật khẩu', 
                minlength: 'Mật khẩu phải có ít nhất 8 ký tự',
            },
        },
        errorClass: "error", // Lớp CSS khi có lỗi
        success: function(label) {
            label.addClass("valid"); // Lớp CSS khi validation thành công
          }, 
    });


    $('.change_password').validate({
        rules: {
            pass_old: { required: true, minlength: 8 },
            pass_new: { required: true, minlength: 8 },
            pass_new_confirm: {
                required: true,
                minlength: 8,
                equalTo: '.pass_new',
            },
        },
        messages: {
            pass_old: { 
                required: '<span class="text-danger">Bạn chưa nhập mật khẩu</span>', 
                minlength: '<span class="text-danger">Mật khẩu phải có ít nhất 8 ký tự</span>',
            },
            pass_new: { 
                required: '<span class="text-danger">Bạn chưa nhập mật khẩu', 
                minlength: '<span class="text-danger">Mật khẩu phải có ít nhất 8 ký tự</span>',
            },
            pass_new_confirm: {
                required: '<span class="text-danger">Bạn chưa nhập mật khẩu</span>',
                minlength: '<span class="text-danger">Mật khẩu phải có ít nhất 8 ký tự</span>',
                equalTo: '<span class="text-danger">Mật khẩu không trùng với mật khẩu đã nhập</span>',
            },
        },
        errorClass: "error", // Lớp CSS khi có lỗi
        success: function(label) {
            label.addClass("valid"); // Lớp CSS khi validation thành công
          }, 
    });


     // Kích hoạt validation khi trường nhập liệu mất focus (blur)
    $(".user__name").blur(function () {
        $(this).valid(); 
    });

    $(".user__birthday").blur(function () {
        $(this).valid(); 
    });

    $(".user__phone").blur(function () {
        $(this).valid(); 
    });

    $(".user__email").blur(function () {
        $(this).valid(); 
    });

    $(".user__password").blur(function () {
        $(this).valid(); 
    });

    $(".user__password_confirm").blur(function () {
        $(this).valid(); 
    });

    $(".user__address").blur(function () {
        $(this).valid(); 
    });

    $(".pass_old").blur(function () {
        $(this).valid(); 
    });

    $(".pass_new").blur(function () {
        $(this).valid(); 
    });

    $(".pass_new_confirm").blur(function () {
        $(this).valid(); 
    });


    setTimeout(() => {
        $(".error_register").css('display','none');
    }, 3000);
})