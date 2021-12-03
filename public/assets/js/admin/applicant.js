$(function () {
    $("#tableApplicant").DataTable({
        searchDelay: 500,
        processing: true,
        serverSide: true,
        language: {
            processing:
                '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only"></span><br>Loading... ',
        },
        ajax: {
            url: "/admin/applicant/datatables",
        },
        order: [[0, "desc"]],
        columns: [
            { data: "DT_RowIndex" },
            { data: "name" },
            { data: "last_edu" },
            { data: "fields" },
            { data: "aksi" },
        ],
    });
});
