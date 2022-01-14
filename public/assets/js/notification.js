$(function () {
    $(".btn-close").on("click", function (e) {
        let id = $(this).data("id");
        $.ajax({
            type: "delete",
            url: `/profile/notification/${id}`,
            dataType: "json",
        });
    });
});
