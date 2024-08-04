$(document).ready(function () {
    function confirmObj(text, icon, confirmText) {
        return {
            position: "top",
            title: "Bạn thực sự muốn xóa ?",
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: confirmText,
            cancelButtonText: "Hủy",
        };
    }
    //delete_tt
    $(".delete_product").click(function () {
        Swal.fire(
            confirmObj("Sản phẩm sẽ được đưa vào thùng rác", "question", "Xóa")
        ).then((result) => {
            if (result.isConfirmed) {
                var id = $(this).attr("data-id");
                var curent = "tr-data-" + id;
                //Lấy session
                $.ajax({
                    url: "http://localhost/Laravel/unimart_laravelpro/admin/product/ajax",
                    data: { id: id },
                    type: "GET",
                    success: function (data) {
                        $("#" + curent).hide(function () {
                            showToast("success", "Xoá thành công");
                        }),
                            setTimeout(function () {
                                window.location.href = "list";
                            }, 1500);
                        $(".section").hide();
                    },
                });
            }
        });
    });
    //Xóa vv
    $(".delete_product_trash").click(function () {
        Swal.fire(
            confirmObj(
                "Sản phẩm sẽ bị xóa vĩnh viễn khỏi hệ thống !",
                "question",
                "Đồng ý"
            )
        ).then((result) => {
            if (result.isConfirmed) {
                var id = $(this).attr("data-id");
                var curent = "tr-data-" + id;
                $.ajax({
                    data: { id: id },
                    type: "GET",
                    url: "delete_trash",
                    success: function (data) {
                        $("#" + curent).hide(function () {
                            showToast("success", "Xoá thành công");
                        }),
                            setTimeout(function () {
                                window.location.href = "list?status=Trash";
                            }, 1500);
                        $(".section").hide();
                    },
                });
            }
        });
    });
    //Restore
    $(".product_restore").click(function () {
        let timerInterval;
        Swal.fire({
            title: "Đang khôi phục!",
            html: "Vui lòng đợi trong giây lát",
            footer: "Verrygood",
            timer: 1000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            },
            willClose: () => {
                clearInterval(timerInterval);
            },
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                var id = $(this).attr("data-id");
                var curent = "tr-data-" + id;
                $.ajax({
                    url: "http://localhost/Laravel/unimart_laravelpro/admin/product/restore",
                    data: { id: id },
                    type: "GET",
                    success: function (data) {
                        window.location.href = "list?status=Trash";
                    },
                });
            }
        });
    });
    //category post
    //retore
    $(".cat_restore_product").click(function () {
        let timerInterval;
        Swal.fire({
            title: "Đang khôi phục!",
            html: "Vui lòng đợi trong giây lát",
            timer: 1000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                const b = Swal.getHtmlContainer().querySelector("b");
                timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft();
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            },
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                var id = $(this).attr("data-id");
                var curent = "tr-data-" + id;
                $.ajax({
                    data: { id: id },
                    type: "GET",
                    url: "http://localhost/Laravel/unimart_laravelpro/admin/product/cat/restore",
                    success: function (data) {
                        window.location.href = "request";
                    },
                });
            }
        });
    });
    //delete_vv
    $(".delete_cat_trash_product").click(function () {
        Swal.fire(
            confirmObj(
                "Danh mục sẽ bị xóa vĩnh viễn khỏi hệ thống !",
                "question",
                "Đồng ý"
            )
        ).then((result) => {
            if (result.isConfirmed) {
                var id = $(this).attr("data-id");
                var curent = "tr-data-" + id;
                $.ajax({
                    data: { id: id },
                    type: "GET",
                    url: "http://localhost/Laravel/unimart_laravelpro/admin/product/cat/delete_trash",
                    success: function (data) {
                        timerInterval(
                            "top",
                            "Đang tiến hành",
                            "<p class='tomato'>Vui lòng chờ trong giây lát</p>",
                            "<p class='font-20'>Very Good</p>"
                        );
                        setTimeout(function () {
                            window.location.href = "request";
                        }, 1500);
                        $(".section").hide();
                    },
                });
            }
        });
    });
    //delete_tt
    function check_id(id) {
        var array = JSON.parse($("#array").val());
        var newArray = [];
        $.each(array, function (index, object) {
            newArray.push(object);
        });
        return newArray.indexOf(id);
     
    }
    // xóa tạm thời
    $(".delete_cat_products").click(function () {
        var id_data = $(this).attr("data-id");
        var id_je = (id_data);
        if(check_id(id_je) !== -1) {
            Swal.fire({
                position: "top",
                icon: "error",
                title: "Stop...",
                text: "Bạn không thể xóa do vẫn còn tồn tại lớp con nếu muốn xóa hãy xóa lớp con trước !",
            });
        } else {
            Swal.fire(
                confirmObj(
                    "Sản phẩm sẽ được đưa vào thùng rác",
                    "question",
                    "Xóa"
                )
            ).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).attr("data-id");
                    var curent = "tr-data-" + id;
                    $.ajax({
                        data: { id: id },
                        url: "http://localhost/Laravel/unimart_laravelpro/admin/product/cat/delete",
                        type: "GET",
                        success: function (data) {
                            timerInterval(
                                "top",
                                "Đang tiến hành",
                                "<p class='tomato'>Vui lòng chờ trong giây lát</p>",
                                "<p class='font-20'>Very Good</p>"
                            );
                            setTimeout(function () {
                                window.location.href = "list";
                            }, 1500);
                            $(".section").hide();
                        },
                    });
                }
            });
        }
    });
    //num_qty
    $(".num_qty").on("change touchstart", function () {
        var num_qty = parseInt($(this).val());
        var id = $(this).attr("data-id");
        var curent = $(".auth_id");
        var stock = "stock-" + id;
        var currentScrollPosition = $(window).scrollTop();
        $.ajax({
            data: { num_qty: num_qty, id: id },
            method: "get",
            url: "http://localhost/Laravel/unimart_laravelpro/admin/product/change_num",
            dataType: "json",
            success: function (data) {
                curent.notify("Cập nhật số lượng thành công", {
                    position: "left",
                    className: "success",
                });
                $("#" + stock).html(data.chang_name);
            },
        });
    });

    // Thư viện
    function timerInterval(position, title, html, text) {
        let timerInterval;
        Swal.fire({
            position: position,
            title: title,
            html: html,
            footer: text,
            timer: 1000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                timerInterval = setInterval(() => {
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            },
        });
    }
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });
    function showToast(icon, massage) {
        Toast.fire({
            icon: icon,
            title: " " + massage,
        });
    }
});
