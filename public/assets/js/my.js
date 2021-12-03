$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="token"]').attr("content"),
    },
});

function errorValidasi(xhr) {
    return $.each(xhr.responseJSON.errors, function (index, value) {
        $("#" + index)
            .addClass("is-invalid")
            .siblings("div.invalid-feedback")
            .text(value[0]);
    });
}

$("#adminLogout").on("click", function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Anda akan logout",
        text: "Sesi akan dihapus! anda yakin?",
        icon: "warning",
        confirmButtonColor: "#3085d6",
        showCancelButton: true,
        confirmButtonText: "Ya, logout",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/admin/logout";
        }
    });
});
$("#userLogout").on("click", function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Anda akan logout",
        text: "Sesi akan dihapus! anda yakin?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Ya, logout",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/logout";
        }
    });
});

const mySwal = Swal.mixin({
    customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "ml-2 btn btn-danger",
    },
    buttonsStyling: false,
});
