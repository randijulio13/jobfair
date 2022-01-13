$(function () {
    $("#formConfig").on("submit", async function (e) {
        e.preventDefault()
        let data = $(this).serialize();
        try {
            let update = await $.ajax({
                url: "/admin/config",
                type: "patch",
                dataType: "json",
                data,
            });

            Swal.fire({
                icon: "success",
                timer: 2000,
                title: "Berhasil",
                text: 'Konfigurasi berhasil diperbarui',
                showConfirmButton: false,
                timerProgressBar: true,
            });
        } catch (err) {
            Swal.fire({
                icon: "error",
                timer: 3000,
                title: "Error",
                text: err.responseJSON.message,
                showConfirmButton: false,
                timerProgressBar: true,
            });
        }
    });
});
