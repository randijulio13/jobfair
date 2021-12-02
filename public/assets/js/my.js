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
    mySwal
        .fire({
            title: "Anda akan logout",
            text: "Sesi akan dihapus! anda yakin?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, logout",
        })
        .then((result) => {
            if (result.isConfirmed) {
                $.post("/admin/logout").then((res) => {
                    mySwal
                        .fire({
                            title: "Berhasil",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false,
                            text: res.message,
                        })
                        .then(() => (window.location.href = "/admin/login"));
                });
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
