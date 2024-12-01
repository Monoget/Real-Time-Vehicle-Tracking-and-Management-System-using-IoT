let x = getCookie('alert');

function getCookie(name) {
    let nameEQ = name + "=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

if (x == 1) {
    toastr.success("Login Successful", "Successful", {
        timeOut: 3000,
        closeButton: !0,
        debug: !1,
        newestOnTop: !0,
        progressBar: !0,
        positionClass: "toast-bottom-right",
        preventDuplicates: !0,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
        iconClass: "toast-success",
        tapToDismiss: !1
    })

    eraseCookie('alert');
}

if (x == 2) {
    toastr.success("Logout Successful", "Successful", {
        timeOut: 3000,
        closeButton: !0,
        debug: !1,
        newestOnTop: !0,
        progressBar: !0,
        positionClass: "toast-bottom-right",
        preventDuplicates: !0,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
        iconClass: "toast-success",
        tapToDismiss: !1
    })

    eraseCookie('alert');
}

if (x == 3) {
    toastr.success("Data Inserted Successful", "Successful", {
        timeOut: 3000,
        closeButton: !0,
        debug: !1,
        newestOnTop: !0,
        progressBar: !0,
        positionClass: "toast-bottom-right",
        preventDuplicates: !0,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
        iconClass: "toast-success",
        tapToDismiss: !1
    })

    eraseCookie('alert');
}


if (x == 4) {
    toastr.success("Data Updated Successful", "Successful", {
        timeOut: 3000,
        closeButton: !0,
        debug: !1,
        newestOnTop: !0,
        progressBar: !0,
        positionClass: "toast-bottom-right",
        preventDuplicates: !0,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
        iconClass: "toast-success",
        tapToDismiss: !1
    })

    eraseCookie('alert');
}

if (x == 5) {
    toastr.success("Data Delete Successful", "Successful", {
        timeOut: 3000,
        closeButton: !0,
        debug: !1,
        newestOnTop: !0,
        progressBar: !0,
        positionClass: "toast-bottom-right",
        preventDuplicates: !0,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
        iconClass: "toast-success",
        tapToDismiss: !1
    })

    eraseCookie('alert');
}

if (x == 6) {
    toastr.error("Something went wrong", "Unsuccessful", {
        timeOut: 3000,
        closeButton: !0,
        debug: !1,
        newestOnTop: !0,
        progressBar: !0,
        positionClass: "toast-bottom-right",
        preventDuplicates: !0,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
        iconClass: "toast-error",
        tapToDismiss: !1
    })

    eraseCookie('alert');
}

if (x == 7) {
    toastr.error("Duplicate Email", "Unsuccessful", {
        timeOut: 3000,
        closeButton: !0,
        debug: !1,
        newestOnTop: !0,
        progressBar: !0,
        positionClass: "toast-bottom-right",
        preventDuplicates: !0,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
        iconClass: "toast-error",
        tapToDismiss: !1
    })

    eraseCookie('alert');
}

function eraseCookie(name) {
    document.cookie = name + '=;';
}
