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
    //post tt
    $(".delete_post").click(function () {
        Swal.fire(
            confirmObj("Bài viết sẽ được đưa vào thùng rác", "question", "Xóa")
        ).then((result) => {
            if (result.isConfirmed) {
                var id = $(this).attr("data-id");
                var curent = "tr-data-" + id;
                //Lấy session
                $.ajax({
                    data: { id: id },
                    url: "http://localhost/Laravel/unimart_laravelpro/admin/post/ajax",
                    type: "GET",
                    dataType: "text",
                    success: function (data) {
                        $("#" + curent).hide(function () {
                            showToast("success", "Xoá thành công");
                        }),
                            setTimeout(function () {
                                window.location.href = "list";
                            }, 1500);
                        $(".section").hide();

                        // $("#result").removeClass("d-none");
                        // $("tr td #result").text(data.output);
                        // $("button").addClass("d-none");
                    },
                });
            }
        });
    });
    //delete vv
       $(".delete_cat_trash").click(function () {
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
                    url: "http://localhost/Laravel/unimart_laravelpro/admin/post/cat/delete_trash",
                    data: { id: id },
                    type: "GET",
                    success: function (data) {
                        $("." + curent).hide(function () {
                            showToast("success", "Xoá thành công");
                        }),
                            setTimeout(function () {
                                window.location.href = "request";
                            }, 1500);
                        $(".section").hide();
                    },
                });
            }
        });
    });
    //category post
    //retore
    $(".cat_restore").click(function () {
        let timerInterval;
        Swal.fire({
            title: "Đang khôi phục!",
            html: "Vui lòng đợi trong giây lát",
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
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                var id = $(this).attr("data-id");
                var curent = "tr-data-" + id;
                $.ajax({
                 
                    data: { id: id },
                       url: "http://localhost/Laravel/unimart_laravelpro/admin/post/cat/restore",
                    type: "GET",
                   
                    success: function (data) {
                        window.location.href = "request";
                    },
                });
            }
        });
    });
    //delete_vv
    $(".delete_cat_trash").click(function () {
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
                    url: "delete_trash",
                    success: function (data) {
                        $("." + curent).hide(function () {
                            showToast("success", "Xoá thành công");
                        }),
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
        return jQuery.inArray(id, newArray);
    }
    $(".delete_cat_posts").click(function () {
        var id_data = $(this).attr("data-id");
        var id_je = (id_data);
        if (check_id(id_je) !== -1) {
            Swal.fire({
                position: "top",
                icon: "error",
                title: "Stop...",
                text: "Bạn không thể xóa do vẫn còn tồn tại lớp con nếu muốn xóa hãy xóa lớp con trước !",
                // footer: '',
            });
        } else {
            Swal.fire(
                confirmObj(
                    "Bài viết sẽ được đưa vào thùng rác",
                    "question",
                    "Xóa"
                )
            ).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).attr("data-id");
                    var curent = "tr-data-" + id;
                    $.ajax({
                        data: { id: id },
                        url: "delete",
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
        }
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
