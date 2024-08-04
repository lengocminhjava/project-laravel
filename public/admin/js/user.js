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
    $(".delete_user").click(function () {
        Swal.fire(
            confirmObj("User sẽ được đưa vào thùng rác", "question", "Xóa")
        ).then((result) => {
            if (result.isConfirmed) {
                var id = $(this).attr("data-id");
                var curent = "tr-data-" + id;
                //Lấy session
                $.ajax({
                    data: { id: id },
                    url: "http://localhost/Laravel/unimart_laravelpro/admin/user/ajax",
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
    //delete vv
    $(".delete_user_trash").click(function () {
        Swal.fire(
            confirmObj("User sẽ bị xóa vĩnh viễn", "question", "Xóa")
        ).then((result) => {
            if (result.isConfirmed) {
                var id = $(this).attr("data-id");
                var curent = "tr-data-" + id;
                //Lấy session
                $.ajax({
                    data: { id: id },
                    url: "http://localhost/Laravel/unimart_laravelpro/admin/user/delete_vv",
                    type: "GET",
                    success: function (data) {
                        $("#" + curent).hide(function () {
                            showToast("success", "Xoá thành công");
                        }),
                            setTimeout(function () {
                                window.location.href = "list?status";
                            }, 1500);
                        $(".section").hide();
                    },
                });
            }
        });
    });
    //
    $(".user_restore").click(function () {
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
                    url: "http://localhost/Laravel/unimart_laravelpro/admin/user/restore",
                    data: { id: id },
                    type: "GET",
                    success: function (data) {
                        window.location.href = "list?status=trash";
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
