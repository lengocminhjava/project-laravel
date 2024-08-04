<?php
use App\Product;
use App\CategoryProduct;
use App\Page;
use App\Category_Post;



function categoryPost(){
$category = Category_Post::all();
return $category;
}

function categoryProduct(){
$category = CategoryProduct::all();
return $category;
}


function header_unimart() {
     $headers = Page::orderBy('id', 'desc')->get();
     return $headers;
}


function change_name($data)
{
    $name = [
        'transporting' => 'Đang vận chuyển',
        'canceled' => 'Đơn hàng hủy',
        'success' => 'Đơn thành công',
        'house' => 'Thanh toán tại nhà',
        'store' => 'Thanh toán tại cửa hàng'
    ];
    return $name[$data];
}
function render_menu_post($data, $menu_class, $menu_id, $parent_id = 0, $level = 0)
{
    if ($level == 0)
        $result = "<ul class='{$menu_class}' id='{$menu_id}'>";
    else
        $result = "<ul class='sub-menu'>";
    foreach ($data as $v) {
        if ($v['parent_id'] == $parent_id) {
            $result .= "<li>";
            $result .= "<a href='http://localhost/Laravel/unimart_laravelpro/bai-viet/danh-muc/{$v['slug_url']}.{$v['id']}.html' title=''>{$v['name']}</a>";
            if (childen_of_data($data, $v['id'])) {
                $result .= render_menu_post($data, $menu_id, $menu_class, $v['id'], $level + 1);
            }
            $result .= "</li>";
        }
    }
    $result .= "</ul>";
    return $result;
}
function render_menu($data, $menu_class, $menu_id, $parent_id = 0,   $level = 0)
{
    if ($level == 0)
        $result = "<ul class='{$menu_class}' id='{$menu_id}'>";
    else
        $result = "<ul class='sub-menu'>";
    foreach ($data as $v) {
        if ($v['parent_id'] == $parent_id) {
            $result .= "<li>";
            $result .= "<a href='http://localhost/Laravel/unimart_laravelpro/san-pham/{$v['slug_url']}.html'title=''>{$v['name']}</a>";
            if (childen_of_data($data, $v['id'])) {
                $result .= render_menu($data, $menu_id, $menu_class, $v['id'], $level + 1);
            }
            $result .= "</li>";
        }
    }
    $result .= "</ul>";
    return $result;
}
function menu_category($data, $menu_class, $menu_id, $parent_id = 0,   $level = 0)
{
    if ($level == 0)
        $result = "<ul class='{$menu_class}' id='{$menu_id}'>";
    else
        $result = "<ul class='sub-menu'>";
    foreach ($data as $v) {
        if ($v['parent_id'] == $parent_id) {
            $result .= "<li>";
            if ($parent_id == 0)
                $result .= "<a href='{$v['slug_url']}.html'title=''>{$v['name']}</a>";
            else
                $result .= "<a href='{$v['slug_url']}.{$v['id']}.html'title=''>{$v['name']}</a>";
            if (childen_of_data($data, $v['id'])) {
                $result .= render_menu($data, $menu_id, $menu_class, $v['id'], $level + 1);
            }
            $result .= "</li>";
        }
    }
    $result .= "</ul>";
    return $result;
}
function menu($data, $menu_class, $menu_id, $parent_id = 0,   $level = 0)
{
    if ($level == 0)
        $result = "<ul class='{$menu_class}' id='{$menu_id}'>";
    else
        $result = "<ul class='sub-menu'>";
    foreach ($data as $v) {
        if ($v['parent_id'] == $parent_id) {
            $result .= "<li>";
            if ($parent_id == 0)
                $result .= "<a href='san-pham/{$v['slug_url']}.html'title=''>{$v['name']}</a>";
            else
                $result .= "<a href='san-pham/{$v['slug_url']}.{$v['id']}.html'title=''>{$v['name']}</a>";
            if (childen_of_data($data, $v['id'])) {
                $result .= render_menu($data, $menu_id, $menu_class, $v['id'], $level + 1);
            }
            $result .= "</li>";
        }
    }
    $result .= "</ul>";
    return $result;
}
function data_tree($data, $parent_id = 0, $level = 0)
{
    $result = [];
    foreach ($data as $item) {
        if ($item['parent_id'] == $parent_id) {
            $item['level'] = $level;
            $result[] = $item;
            // unset($data[$item['id']]);
            $child = data_tree($data, $item['id'], $level + 1);
            $result = array_merge($result, $child);
        }
    }
    return $result;
}
function childen_of_data($data, $id)
{
    foreach ($data as $v) {
        if ($v['parent_id'] == $id)
            return true;
    }
    return false;
}

function search_data($data, $parent_id = 0, $level = 0)
{
    $result = array();
    foreach ($data as $v) {
        $v['level'] = $level;
        if ($v['parent_id'] == $parent_id) {
            $result[] = $v;
            if (childen_of_data($data, $v['id'])) {
                $result_child = search_data($data, $v['id'], $level + 1);
                $result = array_merge($result, $result_child);
            }
        }
    }
    return $result;
}
if (!function_exists('create_slug')) {
    function create_slug($string)
    {
        $search = array(
            '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
            '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
            '#(ì|í|ị|ỉ|ĩ)#',
            '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
            '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
            '#(ỳ|ý|ỵ|ỷ|ỹ)#',
            '#(đ)#',
            '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
            '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
            '#(Ì|Í|Ị|Ỉ|Ĩ)#',
            '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
            '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
            '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
            '#(Đ)#',
            "/[^a-zA-Z0-9\-\_]/",
        );
        $replace = array(
            'a',
            'e',
            'i',
            'o',
            'u',
            'y',
            'd',
            'A',
            'E',
            'I',
            'O',
            'U',
            'Y',
            'D',
            '-',
        );
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '-', $string);
        $string = strtolower($string);
        return $string;
    }
    function jam_read_num_forvietnamese($num = false)
    {
        $str = '';
        $num  = trim($num);

        $arr = str_split($num);
        $count = count($arr);

        $f = number_format($num);
        //KHÔNG ĐỌC BẤT KÌ SỐ NÀO NHỎ DƯỚI 999 ngàn
        if ($count < 7) {
            $str = $num;
        } else {
            // từ 6 số trở lên là triệu, ta sẽ đọc nó !
            // "32,000,000,000"
            $r = explode(',', $f);
            switch (count($r)) {
                case 4:
                    $str = $r[0] . ' tỷ';
                    if ((int) $r[1]) {
                        $str .= ' ' . $r[1] . ' Tr';
                    }
                    break;
                case 3:
                    $str = $r[0] . ' Triệu';
                    if ((int) $r[1]) {
                        $str .= ' ' . $r[1] . 'đ';
                    }
                    break;
            }
        }
        return ($str);
    }
}
function list_product_num($id)
{
    $result = array();
    $categorys =  CategoryProduct::all();
    //Kiểm tra xem có id thuộc  vào danh sách ko
    $list_parent = array(CategoryProduct::where('id', $id)->first());
    //Nhóm lại
    $list = data_tree($categorys, $id);
    //Tìm danh sách theo id
    //Nhóm lại
    $list_pro = array_merge($list, $list_parent);
    //Tìm danh sách theo id
    //Nhóm lại
    //In ra các id thỏa mãn
    foreach ($list_pro as $v) {
        $result[] = (int)$v['id'];
    }
    //Viết về dạng chuỗi
    $list_cat = implode(',', $result);
    //Danh sách của sản phẩm 
    $list_product = Product::where('status_id',6)->whereIn('category_id', $result)->paginate(10);
    return $list_product;
}
