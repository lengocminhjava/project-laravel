$(document).ready(function () {
    $(".nav-link.active .sub-menu").slideDown();
    // $("p").slideUp();
    $("#sidebar-menu .arrow").click(function () {
        $(this).parents("li").children(".sub-menu").slideToggle();
        $(this).toggleClass("fa-angle-right fa-angle-down");
    });
    let check_table = $(".check-name");
    check_table.click(function () {
        let $checkboxes = $(this).closest("table").find("input:checkbox");
        $checkboxes.prop("checked", this.checked);
    });
    $("input[name='checkall']").click(function () {
        var checked = $(this).is(":checked");
        $(".table-checkall tbody tr td input:checkbox").prop(
            "checked",
            checked
        );
    });
    //color text
    $("tr td span.permission").addClass("badge badge-primary");
    //status
    $("tr td span.status:contains('Công khai')").addClass(
        "badge badge-success"
    );
    $("tr td span.status:contains('Đơn hàng hủy')").addClass(
        "badge badge-secondary"
    );
    $("tr td span.status:contains('Đơn thành công')").addClass(
        "badge badge-success"
    );
    $("tr td span.status:contains('Đang vận chuyển')").addClass(
        "badge badge-warning"
    );
    $("tr td span.status:contains('Đang xử lí')").addClass(
        "badge badge-warning"
    );
    $("tr td span.status:contains('Chờ duyệt')").addClass(
        "badge badge-warning"
    );
    //stock
    $("tr td span.stock:contains('Còn hàng')").addClass("badge badge-info");
    $("tr td span.stock:contains('Hết hàng')").addClass(
        "badge badge-secondary"
    );
    //highlight
    $("tr td span.highlight:contains('Nổi bật')").addClass(
        "badge badge-danger"
    );
    $("tr td span.selling:contains('Bán chạy')").addClass(
        "badge badge-success"
    );
    //font-size
    $("tr td span.price").css({ "font-size": "15px" });
    $("tr td span.price_old").css({ "font-size": "15px" });
    $("tr td span.category").css({ "font-size": "15px" });
    //Name file
    let input = $("#customFile");
    let fileName = $("#name_file");

    input.on("change", function () {
        // Lấy tên của file
        let name = input.val().split("\\").pop();

        // Cập nhật nội dung của thẻ HTML
        fileName.html(name);
    });
    // Hiện hình ảnh
    let inputImage = $("#customFile");
    let previewImage = $("#previewImage");
    inputImage.on("change", function () {
        // Kiểm tra xem có file
        if (inputImage[0].files && inputImage[0].files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                // localStorage.setItem("avatar", reader.result);
                // Thêm hình ảnh mới vào #image-container
                previewImage.attr("src", e.target.result);
            };

            reader.readAsDataURL(inputImage[0].files[0]);
        } else {
            // Xoá hiển thị nếu không có file
            previewImage.attr("src", "");
        }
    });
    //Hiển thị nhiều hình ảnh
    $("#files").change(function () {
        // Lấy danh sách các hình ảnh được chọn
        var files = $(this)[0].files;
        // Hiển thị các hình ảnh được chọn
        $("#images-container").html("");
        $.each(files, function (index, file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#images-container").append(
                    '<img src="' + e.target.result + '">'
                );
            };
            reader.readAsDataURL(file);
        });
    });
    //images
    $("#images").change(function () {
        // Lấy danh sách các hình ảnh được chọn
        var files = $(this)[0].files;
        // Hiển thị các hình ảnh được chọn
        $("#files-containers").html("");
        $.each(files, function (index, file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#files-container").append(
                    '<img src="' + e.target.result + '">'
                );
            };
            reader.readAsDataURL(file);
        });
    });
    $(".num_product").keyup(function () {
        var num = $(this).val();
        let id = $(this).attr("data-id");
        $.ajax({
            url: "http://localhost/Laravel/unimart_laravelpro/admin/order/total",
            data: { num: num, id: id },
            dataType: "json",
            success: function (data) {
                $(".total_product").val(data);
            },
        });
    });
    const $imageInput = $("#image-input");
    const $imageList = $("#image-list");

    $imageInput.on("change", (event) => {
        const images = event.target.files;
        for (let i = 0; i < images.length; i++) {
            const imageURL = URL.createObjectURL(images[i]);
            addImageToDOM(imageURL);
        }
    });
    function addImageToDOM(imageURL) {
        const $li = $("<li class='item_image'>");
        const $img = $("<img>").attr("src", imageURL);
        const $deleteButton = $(
            "<button class='delete_image'><img src ='https://png.pngtree.com/png-vector/20190124/ourlarge/pngtree-x-red-cross-png-picture-red-png-image_550969.jpg'></button>"
        );
        $img.appendTo($li);
        $deleteButton.appendTo($li);
        $li.appendTo($imageList);
        $li.data("url", imageURL);
    }

    $imageList.on("click", "li", (event) => {
        $(event.currentTarget).remove();
    });
    $imageList.on("click", "button", (event) => {
        const $li = $(event.currentTarget).closest("li");
        const imageURL = $li.data("url");
        $li.remove();
        // Xử lý xóa hình ảnh khỏi server
        // ...
    });
    //update
    const $imageInputs = $("#image-inputs");
    const $imageLists = $("#image-lists");

    $imageInputs.on("change", (event) => {
        const images = event.target.files;
        for (let i = 0; i < images.length; i++) {
            const imageURL = URL.createObjectURL(images[i]);
            addImageToDOM(imageURL);
        }
    });
    function addImageToDOM(imageURL) {
        const $li = $("<li class='item_images'>");
        const $img = $("<img>").attr("src", imageURL);
        // const $deleteButton = $("<button class='delete_image'></button>");
        $img.appendTo($li);
        // $deleteButton.appendTo($li);
        $li.appendTo($imageLists);
        $li.data("url", imageURL);
    }

    $imageLists.on("click", "li", (event) => {
        $(event.currentTarget).remove();
    });
    $imageLists.on("click", "button", (event) => {
        const $li = $(event.currentTarget).closest("li");
        const imageURL = $li.data("url");
        $li.remove();
        // Xử lý xóa hình ảnh khỏi server
        // ...
    });
    //add
    // Khi người dùng chọn file (điều kiện: file là hình ảnh)
    $("#my-file-input").on("change", function () {
        var files = $(this)[0].files;
        for (var i = 0; i < files.length; i++) {
            if (files[i].type.match(/image.*/)) {
                var reader = new FileReader();
                reader.onload = function (event) {
                    $("<div>", { class: "image-preview" })
                        .append($("<span>", { class: "delete-image" }))
                        .append($("<img>").attr("src", event.target.result))
                        .appendTo("#image-preview-container");
                };
                reader.readAsDataURL(files[i]);
            }
        }
    });

    // Xóa hình ảnh khi click vào bất kì vị trí nào trên hình
    $(document).on("click", ".image-preview img", function (event) {
        event.stopPropagation(); // ngăn chặn sự kiện click lan ra các phần tử nằm bên ngoài
        $(this).parent(".image-preview").remove();
    });
});
function delete_images(id) {
    $(".item_image").on("touchstart", function () {
        // Code xử lý sự kiện touchstart
        var imageContainer = "image-" + id;
        $.ajax({
            data: { id: id },
            url: "http://localhost/Laravel/unimart_laravelpro/admin/product/delete_img",
            dataType: "json",
            success: function (data) {
                const $li = $("#" + imageContainer).remove();
            },
        });
    });
}
