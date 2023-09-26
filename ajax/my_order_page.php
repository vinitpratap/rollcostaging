<?php

if (isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])
        == 'xmlhttprequest') {
    include '../class/config.php';
    $u_id = $_POST["user_id"];

    $item_per_page = 10;
    if (isset($_POST["page"]) && $_POST["page"] > 0) {
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT,
                FILTER_FLAG_STRIP_HIGH); //filter number
        if (!is_numeric($page_number)) {
            die('Invalid page number!');
        } //incase of invalid page 
    } else {
        $page_number = 1; //if there's no page number, set it to 1
    }
    if (isset($u_id)) {
        $user_id = filter_var($u_id, FILTER_SANITIZE_NUMBER_INT,
                FILTER_FLAG_STRIP_HIGH); //filter number
    }
    //get total number of records from database for pagination
    $results = "SELECT COUNT(*) as top_cnt from rollco_ms_order where user_id = " . $user_id . " ";
    $get_total_rows = $sq->numsrow($results);
    $get_total_rowsno = $sq->fearr($results);

    $total_pages = ceil($get_total_rowsno['top_cnt'] / $item_per_page);

    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);
    $checkord_sql = "SELECT ord.order_id,ord.order_no,ord.totalprice,ord.Qty,Date(ord.order_date)as order_date FROM rollco_ms_order as ord WHERE ord.user_id = '" . $user_id . "'  order by ord.order_id desc LIMIT $page_position, $item_per_page";
    $numsroword = $sq->numsrow($checkord_sql);
    $data = $sq->query($checkord_sql);
    $data1 = '';
    while ($rs = $sq->fetch($data)) {
        $data1 .= '<tr>';
        $data1 .= '<td> <a href="order-details.php?order_id=' . $rs['order_id'] . '">' . $rs['order_no'] . '</a></td>';
        $data1 .= '<td>' . $rs['Qty'] . '</td>';
        $data1 .= '<td>' . sprintf("%.2f", $rs['totalprice']) . '</td>';
        $data1 .= '<td>' . $rs['order_date'] . '</td>';
        $data1 .= '<td><a href="order-details.php?order_id=' . $rs['order_id'] . '">  <img src="images/view-eye.svg"></a> </td></tr>';
    }

    /* We call the pagination function here to generate Pagination link for us. 
      As you can see I have passed several parameters to the function. */
    $pagination = paginate_function($item_per_page, $page_number,
            $get_total_rowsno['top_cnt'], $total_pages);

    $jsonmessg['success'] = 'true';
    $jsonmessg['datavalues'] = $data1;
    $jsonmessg['pagination'] = $pagination;
    echo json_encode($jsonmessg);
    return;
}

################ pagination function #########################################

function paginate_function($item_per_page, $current_page, $total_records,
        $total_pages) {
    $pagination = '';
    if ($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) { //verify total pages and current page number
        $pagination .= '<div  class="col-lg-12"><div class="pagingnav" aria-label="Page navigation"><ul class="pagination justify-content-end">';

        $right_links = $current_page + 3;
        $previous = $current_page - 1; //previous link 
        $next = $current_page + 1; //next link
        $first_link = true; //boolean var to decide our first link

        if ($current_page > 1) {
            $previous_link = ($previous <= 0) ? 1 : $previous;

            $pagination .= '<li class="page-item"> <a class="page-link" href="#" data-page="' . $previous_link . '" title="Previous">Previous</a></li>';
            for ($i = ($current_page - 2); $i < $current_page; $i++) { //Create left-hand side links
                if ($i > 0) {
                    $pagination .= ' <li class="page-item"><a class="page-link" href="#"data-page="' . $i . '" title="Page' . $i . '">' . $i . '</a></li>';
                }
            }
            $first_link = false; //set first link to false
        }
        if ($first_link) { //if current active page is first link
            $pagination .= '<li class="page-item active"><a class="page-link">' . $current_page . '</a></li>';
        } elseif ($current_page == $total_pages) { //if it's the last active link
            $pagination .= '<li class="page-item active"><a class="page-link">' . $current_page . '</a></li>';
        } else { //regular current link
            $pagination .= '<li class="page-item active"><a class="page-link active">' . $current_page . '</a></li>';
        }

        for ($i = $current_page + 1; $i < $right_links; $i++) { //create right-hand side links
            if ($i <= $total_pages) {
                $pagination .= '<li class="page-item "><a class="page-link" pg_txt" href="#" data-page="' . $i . '" title="Page ' . $i . '">' . $i . '</a></li>';
            }
        }
        if ($current_page < $total_pages) {
            $next_link = ($i > $total_pages) ? $total_pages : $i;
            $pagination .= '<li class="page-item "><a class="page-link" href="#" data-page="' . ($current_page
                    + 1) . '" title="Next">Next</a></li>'; //next link
        }

        $pagination .= '</ul></div></div>';
    }

    return $pagination; //return pagination links
}
?>

