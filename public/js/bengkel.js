$(document).ready(function () {
    let pekerjaanCount = 0;
    let selectedpekerjaan = new Set();

    // Initialize DataTable
    var table = $("#tablepekerjaan").DataTable({
        responsive: true,
        lengthChange: false,
        bInfo: false,
        ordering: false,
    });

    // Handle Add Button Click
    $(".add_data_pekerjaan").on("click", function () {
        const pekerjaanSelect = $("#pekerjaan");
        const selectedOption = pekerjaanSelect.find("option:selected");
        const pekerjaanId = selectedOption.val();
        const pekerjaanName = selectedOption.data("pekerjaan");
        const remark = $('input[name="remarkpekerjaan"]').val().trim();

        // Validation
        if (!pekerjaanId) {
            swal("Error", "pekerjaan tidak boleh kosong.", "error");
            return;
        }

        if (!remark) {
            swal("Error", "Remark tidak boleh kosong.", "error");
            return;
        }

        if (selectedpekerjaan.has(pekerjaanId)) {
            swal("Error", "Pekerjaan Usdah ada.", "error");
            return;
        }

        // Add to selected pekerjaan set and increment count
        selectedpekerjaan.add(pekerjaanId);
        pekerjaanCount++;

        // Add row to DataTable
        table.row
            .add([
                pekerjaanCount,
                `<input type="hidden" name="pekerjaan_ids[]" value="${pekerjaanId}">${pekerjaanName}`,
                `<input type="hidden" name="pekerjaan_data[]" value='${JSON.stringify(
                    { id: pekerjaanId, remark: remark }
                )}'>${pekerjaanName}`,
                `<input type="hidden" name="remark_pekerjaan[]" value="${remark}">${remark}`,
                `<a href="javascript:;" class="remove_data text-center">
                <i class="fas fa-times"></i>
            </a>`,
            ])
            .draw(false);

        // Update hidden input with selected pekerjaan IDs
        $("#selectedpekerjaanInput").val(Array.from(selectedpekerjaan));

        // Clear input fields
        $('input[name="remarkpekerjaan"]').val("");
        pekerjaanSelect.val("").trigger("change");
    });

    // Handle Remove Button Click
    $("#tablepekerjaan tbody").on("click", ".remove_data", function () {
        var row = $(this).closest("tr");
        var pekerjaanId = row.find('input[type="hidden"]').first().val();

        // Remove from selected pekerjaan set
        selectedpekerjaan.delete(pekerjaanId);

        // Remove row from DataTable
        table.row(row).remove().draw(false);

        // Update pekerjaan count and table indexes
        pekerjaanCount--;
        updateTableIndexes();

        // Update hidden input with selected pekerjaan IDs
        $("#selectedpekerjaanInput").val(Array.from(selectedpekerjaan));
    });

    // Function to update table row indexes
    function updateTableIndexes() {
        table.rows().every(function (rowIdx) {
            this.cell(rowIdx, 0)
                .data(rowIdx + 1)
                .draw(false);
        });
    }
});

$(document).ready(function () {
    let partCount = 0;
    let selectedpart = new Set();

    // Initialize DataTable
    var table = $("#tablepart").DataTable({
        responsive: true,
        lengthChange: false,
        bInfo: false,
        ordering: false,
    });

    // Handle Add Button Click
    $(".add_data_part").on("click", function () {
        const partSelect = $("#part");
        const selectedOption = partSelect.find("option:selected");
        const partId = selectedOption.val();
        const partName = selectedOption.data("part");
        const remark = $('input[name="remarkpart"]').val().trim();

        // Validation
        if (!partId) {
            swal("Error", "part tidak boleh kosong.", "error");
            return;
        }

        if (!remark) {
            swal("Error", "Remark tidak boleh kosong.", "error");
            return;
        }

        if (selectedpart.has(partId)) {
            swal("Error", "part sudah ada.", "error");
            return;
        }

        // Add to selected part set and increment count
        selectedpart.add(partId);
        partCount++;

        // Add row to DataTable
        table.row
            .add([
                partCount,
                `<input type="hidden" name="part_ids[]" value="${partId}">${partName}`,
                `<input type="hidden" name="remarks_part[]" value="${remark}">${remark}`,
                `<input type="hidden" name="part_data[]" value='${JSON.stringify(
                    { id: partId, remark: remark }
                )}'>${partName}`,
                `<a href="javascript:;" class="remove_data">
                <i class="fas fa-times"></i>
            </a>`,
            ])
            .draw(false);

        // Update hidden input with selected part IDs
        $("#selectedpartInput").val(Array.from(selectedpart));

        // Clear input fields
        $('input[name="remarkpart"]').val("");
        partSelect.val("").trigger("change");
    });

    // Handle Remove Button Click
    $("#tablepart tbody").on("click", ".remove_data", function () {
        var row = $(this).closest("tr");
        var partId = row.find('input[type="hidden"]').first().val();

        // Remove from selected part set
        selectedpart.delete(partId);

        // Remove row from DataTable
        table.row(row).remove().draw(false);

        // Update part count and table indexes
        partCount--;
        updateTableIndexes();

        // Update hidden input with selected part IDs
        $("#selectedpartInput").val(Array.from(selectedpart));
    });

    // Function to update table row indexes
    function updateTableIndexes() {
        table.rows().every(function (rowIdx) {
            this.cell(rowIdx, 0)
                .data(rowIdx + 1)
                .draw(false);
        });
    }
});

// $(document).ready(function () {
//     $("#submitUpload").on("click", function () {
//         const fileInput = $("#fileInput")[0].files;
//         const remarkInput = $("#remarkInput").val().trim();
//         const allowedFileTypes = ["image/jpeg", "image/png", "video/mp4"];
//         const fileTableBody = $("#fileTable tbody");

//         // Validasi input
//         if (fileInput.length === 0) {
//             alert("Please select at least one file.");
//             return;
//         }

//         if (!remarkInput) {
//             alert("Please input remark.");
//             return;
//         }

//         $("#fileInfo").empty();
//         fileTableBody.empty(); // Clear existing table rows

//         let validFiles = true;

//         Array.from(fileInput).forEach((file) => {
//             if (!allowedFileTypes.includes(file.type)) {
//                 alert(
//                     "Invalid file type. Please upload JPG, PNG images or MP4 videos."
//                 );
//                 validFiles = false;
//                 return;
//             }

//             // Check file size (Optional: limit size to 10MB)
//             if (file.size > 10 * 1024 * 1024) {
//                 alert(
//                     "File is too large. Please upload a file smaller than 10MB."
//                 );
//                 validFiles = false;
//                 return;
//             }
//         });

//         if (validFiles) {
//             uploadFiles(fileInput, remarkInput);
//         }

//         $("#fileInput").val("");
//         $("#remarkInput").val("");
//     });

//     $("#fileTable").on("click", ".remove-file", function () {
//         $(this).closest("tr").remove();
//     });

//     function uploadFiles(files, remark) {
//         const formData = new FormData();
//         const id = $("#idInput").val().trim();
//         const nopol = $("#nopolInput").val().trim();
//         const uploadUrl = $("#uploadFileUrl").val();
//         const csrfToken = $('meta[name="csrf-token"]').attr("content");

//         // Menambahkan setiap file ke FormData
//         Array.from(files).forEach((file) => {
//             formData.append("file[]", file); // Nama "file[]" akan di-parse sebagai array di Laravel
//         });
//         formData.append("remark", remark);
//         formData.append("id", id);
//         formData.append("nopol", nopol);

//         $.ajax({
//             headers: { "X-CSRF-TOKEN": csrfToken },
//             url: uploadUrl,
//             type: "POST",
//             data: formData,
//             processData: false,
//             contentType: false,
//             success: function (response) {
//                 if (response.success) {
//                     alert("Files uploaded successfully!");
//                     const fileName = file.name;
//                     fileTableBody.append(`
//                         <tr>
//                             <td>${fileName}</td>
//                             <td>${remarkInput}</td>
//                             <td><button type="button" class="btn btn-danger btn-sm remove-file">Remove</button></td>
//                         </tr>
//                     `);

//                     $("#uploadModal").modal("hide");
//                 } else {
//                     alert("Failed to upload files: " + response.message);
//                 }
//             },
//             error: function (jqXHR, textStatus, errorThrown) {
//                 alert("Error occurred: " + textStatus);
//             },
//         });
//     }
// });

$(document).ready(function () {
    $("#submitUpload").on("click", function () {
        const fileInput = $("#fileInput")[0].files;
        const remarkInput = $("#remarkInput").val().trim();
        const allowedFileTypes = ["image/jpeg", "image/png", "video/mp4"];
        const fileTableBody = $("#fileTable tbody");

        // Validasi input
        if (fileInput.length === 0) {
            swal("Error", "Please select at least one file", "error");
            return;
        }

        if (!remarkInput) {
            swal("Error", "Please input remark", "error");
            return;
        }

        let validFiles = true;

        Array.from(fileInput).forEach((file) => {
            if (!allowedFileTypes.includes(file.type)) {
                swal(
                    "Error",
                    "Invalid file type. Please upload JPG, PNG images or MP4 videos",
                    "error"
                );
                validFiles = false;
                return;
            }

            if (file.size > 10 * 1024 * 1024) {
                swal(
                    "Error",
                    "File is too large. Please upload a file smaller than 10MB",
                    "error"
                );

                validFiles = false;
                return;
            }
        });

        if (validFiles) {
            $("#loader").show();
            $("#submitUpload").prop("disabled", true);
            uploadFiles(fileInput, remarkInput);
        }
    });

    $("#fileTable").on("click", ".remove-file", function () {
        $(this).closest("tr").remove();
    });

    function uploadFiles(files, remark) {
        const formData = new FormData();
        const uploadUrl = $("#uploadFileUrl").val();
        const csrfToken = $('meta[name="csrf-token"]').attr("content");
        const id = $("#idInput").val().trim();
        const nopol = $("#nopolInput").val().trim();
        const fileTableBody = $("#fileTable tbody");

        Array.from(files).forEach((file) => {
            formData.append("file[]", file);
        });

        formData.append("remark", remark);
        formData.append("id", id);
        formData.append("nopol", nopol);

        $.ajax({
            headers: { "X-CSRF-TOKEN": csrfToken },
            url: uploadUrl,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $("#loader").hide();
                if (response.success) {
                    swal(
                        "Success",
                        "Files uploaded successfully!",
                        "success"
                    ).then(() => {
                        response.data.forEach((data) => {
                            fileTableBody.append(`
                                <tr>
                                    <td>${data.filename}</td>
                                    <td>${data.remark}</td>
                                    <td><button type="button" class="btn btn-danger btn-sm remove-file">Remove</button></td>
                                </tr>
                            `);
                        });
                        $("#fileInput").val("");
                        $("#remarkInput").val("");
                        $("#uploadModal").modal("hide");
                    });
                } else {
                    swal(
                        "Error",
                        "Failed to upload files: " + response.message,
                        "error"
                    );
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#loader").hide(); // Hide loader
                $("#fileInput").val("");
                $("#remarkInput").val("");
                swal("Error", "Error occurred: " + textStatus, "error");
            },
        });
    }
});
