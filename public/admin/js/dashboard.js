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
    $(".delete_dashboard").click(function () {
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
                                window.location.href = "dashboard";
                            }, 1500);
                        $(".section").hide();
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