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
    //post
    $(".delete_order").click(function () {
        Swal.fire(
            confirmObj("Đơn hàng sẽ được đưa vào thùng rác", "question", "Xóa")
        ).then((result) => {
            if (result.isConfirmed) {
                var id = $(this).attr("data-id");
                var curent = "tr-data-" + id;
                //Lấy session
                $.ajax({
                    data: { id: id },
                    url: "http://localhost/Laravel/unimart_laravelpro/admin/order/delete",
                    type: "GET",
                    success: function (data) {
                        $("#" + curent).hide(function () {
                            showToast("success", "Xoá thành công");
                        }),
                            setTimeout(function () {
                                window.location.href =
                                    "http://localhost/Laravel/unimart_laravelpro/admin/order/list";
                            }, 1500);
                        $(".section").hide();
                    },
                });
            }
        });
    });
    //delete vv
    $(".delete_order_trash").click(function () {
        Swal.fire(
            confirmObj("Đơn hàng sẽ bị xóa vĩnh viễn", "question", "Xóa")
        ).then((result) => {
            if (result.isConfirmed) {
                var id = $(this).attr("data-id");
                var curent = "tr-data-" + id;
                //Lấy session
                $.ajax({
                    data: { id: id },
                    url: "http://localhost/Laravel/unimart_laravelpro/admin/order/delete_trash",
                    type: "GET",
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
    //retore
    $(".restore_order").click(function () {
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
                    url: "http://localhost/Laravel/unimart_laravelpro/admin/order/restore",
                    success: function (data) {
                        window.location.href = "list?status=Trash";
                    },
                });
            }
        });
    });

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
