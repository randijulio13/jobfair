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
function errorValidasiName(xhr) {
    return $.each(xhr.responseJSON.errors, function (index, value) {
        $(`input[name="${index}"]`)
            .addClass("is-invalid")
            .siblings("div.invalid-feedback")
            .text(value[0]);
    });
}

$("#modalPassword").on("hidden.bs.modal", function () {
    $("#formPassword").trigger("reset");
});

$("#modalPassword").on("shown.bs.modal", function () {
    $("#old_password").focus();
});

$("#gantiPassword").on("click", function (e) {
    e.preventDefault();
    $("#modalPassword").modal("show");
});

$("#formPassword").on("submit", async function (e) {
    e.preventDefault();
    $(this).find('.is-invalid').removeClass('is-invalid')
    let data = $(this).serialize();
    try {
        let res = await $.ajax({
            type: "patch",
            url: "/admin/password",
            data,
            dataType: "json",
        });
        Swal.fire({
            icon: "success",
            title: "Berhasil",
            text: res.message,
            timer: 1500,
            showConfirmButton: false,
            timerProgressBar: true,
        });
        $('#modalPassword').modal('hide')
    } catch (err) {
        if (err.status == 422) return errorValidasi(err);
        Swal.fire({
            icon: "error",
            title: "Error",
            text: err.responseJSON.message,
            timer: 5000,
            showConfirmButton: false,
            timerProgressBar: true,
        });
    }
});

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
$(".userLogout").on("click", function (e) {
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

function mySwalLoading(title = "Loading", text = "Harap tunggu...") {
    return Swal.fire({
        title: title,
        html:
            '<div class="spinner-border text-dark mb-1" role="status"><span class="sr-only">Loading...</span> </div><br> ' +
            text,
        showConfirmButton: false,
        allowOutsideClick: false,
    });
}
