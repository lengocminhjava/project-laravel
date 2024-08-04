$(document).ready(function () {
    //Thông báo xóa
    $(".num-order").change(function () {
        var rowId = $(this).attr("data-id");
        var qty_ = $(this).val();
        var curent = "total-item-" + rowId;
        var sum_total = $("#num").val();
        console.log(sum_total);
        $.ajax({
            url: "http://localhost/Laravel/unimart_laravelpro/unimart/card/ajax",
            data: { rowId: rowId, qty_: qty_ },
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#" + curent).html(data.total_item);
                $("p#total-price span").text(data.total);
            },
        });
    });
    $(".add_cart").click(function () {
        var id = $(this).attr("data-id");
        $.ajax({
            url: "http://localhost/Laravel/unimart_laravelpro/unimart/card/add",
            data: { id: id },
            type: "GET",
            dataType: "json",
            success: function (data) {
                $("p#dest_update span").text(data.number);
                $("span#num").text(data.number);
                $("#dropdown").html(data.output);
                Swal.fire({
                    title: "Đã thêm sản phẩm vào giỏ ",
                    icon: "success",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#159895",
                    confirmButtonText: "Đi vào giỏ hàng",
                    cancelButtonText: "Mua tiếp",
                }).then((result) => {
                    if (result.value) {
                        window.location.href =
                            "http://localhost/Laravel/unimart_laravelpro/gio-hang.san-pham.html";
                    }
                });
            },
        });
    });
    $(".delete_cart").click(function () {
        var id_cart = $(this).attr("data-id");
        var id = $(this).attr("id");
        var curent = "tr-cart-" + id;
        $.ajax({
            url: "http://localhost/Laravel/unimart_laravelpro/unimart/card/remove",
            data: { id_cart: id_cart },
            type: "GET",
            success: function (data) {
                $("#" + curent).hide(function () {
                    Swal.fire({
                        position: "top-center",
                        icon: "success",
                        title: "Xóa thành công",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                }),
                    setTimeout(function () {
                        window.location.href =
                            "http://localhost/Laravel/unimart_laravelpro/gio-hang.san-pham.html";
                    }, 1500);
            },
        });
    });
    //search
    $("#s").keyup(function () {
        var text = $(this).val();
        $.ajax({
            url: "http://localhost/Laravel/unimart_laravelpro/unimart.search.html",
            data: { text: text },
            type: "GET",
            dataType: "json",
            success: function (data) {
                $("#search-ajax").html(data.html);
            },
        });
    });
    //  SLIDER
    var slider = $("#slider-wp .section-detail");
    slider.owlCarousel({
        autoPlay: 4500,
        navigation: false,
        navigationText: false,
        paginationNumbers: false,
        pagination: true,
        items: 1, //10 items above 1000px browser width
        itemsDesktop: [1000, 1], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 1], // betweem 900px and 601px
        itemsTablet: [600, 1], //2 items between 600 and 0
        itemsMobile: true, // itemsMobile disabled - inherit from itemsTablet option
    });

    //  ZOOM PRODUCT DETAIL
    $("#zoom").elevateZoom({
        gallery: "list-thumb",
        cursor: "pointer",
        galleryActiveClass: "active",
        imageCrossfade: true,
        loadingIcon: "http://www.elevateweb.co.uk/spinner.gif",
    });

    //  LIST THUMB
    var list_thumb = $("#list-thumb");
    list_thumb.owlCarousel({
        navigation: true,
        navigationText: false,
        paginationNumbers: false,
        pagination: false,
        stopOnHover: true,
        items: 5, //10 items above 1000px browser width
        itemsDesktop: [1000, 5], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 5], // betweem 900px and 601px
        itemsTablet: [768, 5], //2 items between 600 and 0
        itemsMobile: true, // itemsMobile disabled - inherit from itemsTablet option
    });

    //  FEATURE PRODUCT
    var feature_product = $("#feature-product-wp .list-item");
    feature_product.owlCarousel({
        autoPlay: true,
        navigation: true,
        navigationText: false,
        paginationNumbers: false,
        pagination: false,
        stopOnHover: true,
        items: 4, //10 items above 1000px browser width
        itemsDesktop: [1000, 4], //5 items between 1000px and 901px
        itemsDesktopSmall: [800, 3], // betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0
        itemsMobile: [375, 1], // itemsMobile disabled - inherit from itemsTablet option
    });

    //  SAME CATEGORY
    var same_category = $("#same-category-wp .list-item");
    same_category.owlCarousel({
        autoPlay: true,
        navigation: true,
        navigationText: false,
        paginationNumbers: false,
        pagination: false,
        stopOnHover: true,
        items: 4, //10 items above 1000px browser width
        itemsDesktop: [1000, 4], //5 items between 1000px and 901px
        itemsDesktopSmall: [800, 3], // betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0
        itemsMobile: [375, 1], // itemsMobile disabled - inherit from itemsTablet option
    });

    //  SCROLL TOP
    $(window).scroll(function () {
        if ($(this).scrollTop() != 0) {
            $("#btn-top").stop().fadeIn(150);
        } else {
            $("#btn-top").stop().fadeOut(150);
        }
    });
    $("#btn-top").click(function () {
        $("body,html").stop().animate({ scrollTop: 0 }, 800);
    });

    // CHOOSE NUMBER ORDER
    var value = parseInt($("#num-order").attr("value"));
    var quantity = $("#num-order").attr("data-quantity");
    $("#plus").click(function () {
        if (value < quantity) {
            value++;
        }
        $("#num-order").attr("value", value);

        update_href(value);
    });
    $("#minus").click(function () {
        if (value > 1) {
            value--;
            $("#num-order").attr("value", value);
        }
        update_href(value);
    });

    function update_href(value) {
        qty = value;
        return qty;
    }
    $(".cart_detail").click(function () {
        quantity = quantity;
        qty = update_href(value);
        id = $("#num-order").attr("data-id");
        $.ajax({
            url: "http://localhost/Laravel/unimart_laravelpro/unimart/card/addmore",
            data: { qty: qty, id: id, quantity: quantity },
            method: "GET",
            success: function (data) {
                window.location.href =
                    "http://localhost/Laravel/unimart_laravelpro/gio-hang.san-pham.html";
            },
        });
    });

    //  MAIN MENU
    $("#category-product-wp .list-item > li")
        .find(".sub-menu")
        .after('<i class="fa fa-angle-right arrow" aria-hidden="true"></i>');

    //  TAB
    tab();

    //  EVEN MENU RESPON
    $("html").on("click", function (event) {
        var target = $(event.target);
        var site = $("#site");

        if (target.is("#btn-respon i")) {
            if (!site.hasClass("show-respon-menu")) {
                site.addClass("show-respon-menu");
            } else {
                site.removeClass("show-respon-menu");
            }
        } else {
            $("#container").click(function () {
                if (site.hasClass("show-respon-menu")) {
                    site.removeClass("show-respon-menu");
                    return false;
                }
            });
        }
    });

    //  MENU RESPON
    $("#main-menu-respon li .sub-menu").after(
        '<span class="fa fa-angle-right arrow"></span>'
    );
    $("#main-menu-respon li .arrow").click(function () {
        if ($(this).parent("li").hasClass("open")) {
            $(this).parent("li").removeClass("open");
        } else {
            //            $('.sub-menu').slideUp();
            //            $('#main-menu-respon li').removeClass('open');
            $(this).parent("li").addClass("open");
            //            $(this).parent('li').find('.sub-menu').slideDown();
        }
    });
    //Xem thêm
    const description = $(".product-description .description");
    const readMoreBtn = $(".product-description .read-more");
    // const expandedHeight = description[0].scrollHeight;

    let isExpanded = false;

    readMoreBtn.on("click", function (event) {
        event.preventDefault();

        isExpanded = !isExpanded;

        if (isExpanded) {
            description.animate({ height: "50%" }, 500);
            readMoreBtn.text("Xem thêm");
        } else {
            description.animate({ height: "100%" }, 500);
            readMoreBtn.text("Thu gọn");
        }
    });
});

function tab() {
    var tab_menu = $("#tab-menu li");
    tab_menu.stop().click(function () {
        $("#tab-menu li").removeClass("show");
        $(this).addClass("show");
        var id = $(this).find("a").attr("href");
        $(".tabItem").hide();
        $(id).show();
        return false;
    });
    $("#tab-menu li:first-child").addClass("show");
    $(".tabItem:first-child").show();
    //shearch
    function filter_data() {
        // var slug = $("#list-product-wp").attr("data- id");
        var r_price = $(".r_price:checked").val();
        var r_brand = $(".r_brand:checked").val();
        //window.location.href=price;
        if (toBoolean(r_price) && !toBoolean(r_brand)) {
            window.location.href =
                "http://localhost/Laravel/unimart_laravelpro/san-pham.html?price=" +
                r_price;
        }
        if (!toBoolean(r_price) && toBoolean(r_brand)) {
            window.location.href =
                "http://localhost/Laravel/unimart_laravelpro/san-pham.html?brand=" +
                r_brand;
        }
        if (toBoolean(r_price) && toBoolean(r_brand)) {
            window.location.href =
                "http://localhost/Laravel/unimart_laravelpro/san-pham.html?brand=" +
                r_brand +
                "&price=" +
                r_price;
        }
        if (!toBoolean(r_price) && !toBoolean(r_brand)) {
            window.location.href =
                "http://localhost/Laravel/unimart_laravelpro/san-pham.html";
        }
    }
    $(".comom_selector").click(function () {
        filter_data();
    });
    function toBoolean(value) {
        return Boolean(value);
    }
}
