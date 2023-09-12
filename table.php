<?php include 'jdf.php';
include 'database.php';

function get_remaining_days($expirationDate)
{
    $current_gdate = date('Y/m/d');
    $arr_parts = explode('/', $current_gdate);
    $gYear = $arr_parts[0];
    $gMonth = $arr_parts[1];
    $gDay = $arr_parts[2];
    $current_jdate = gregorian_to_jalali($gYear, $gMonth, $gDay, '/');

    $startArry = date_parse($current_jdate);
    $endArry = date_parse($expirationDate);

    // Convert dates to Julian Days
    $start_date = gregoriantojd($startArry["month"], $startArry["day"], $startArry["year"]);
    $end_date = gregoriantojd($endArry["month"], $endArry["day"], $endArry["year"]);

    // Return difference
    return round(($end_date - $start_date), 0);
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
</head>
<body>

      <?php 
      global $wpdb;
      $table_name = $wpdb->prefix . 'my_plugin_links';

        $limit_per_page = 10;
        $page = isset($_POST['page_no']) ? $_POST['page_no'] : 1;

        $offset = ($page - 1) * $limit_per_page;
        $query="SELECT * FROM $table_name LIMIT {$offset},{$limit_per_page}";
        $result=mysqli_query($conn,$query);
       ?>
        <table class="table"style="width: 99%;">
            <thead>
                <tr>
                    <th scope="col" style="text-align: center;"><?php esc_html_e('Id','danolink'); ?></th>
                    <th scope="col" style="text-align: center;"><?php esc_html_e('Link Name','danolink'); ?></th>
                    <th scope="col" style="text-align: center;"><?php esc_html_e('Link URL','danolink'); ?></th>
                    <th scope="col" style="text-align: center;"><?php esc_html_e('Link Date','danolink'); ?></th>
                    <th scope="col" style="text-align: center;"><?php esc_html_e('Expiration Date','danolink'); ?></th>
                    <th scope="col" style="text-align: center;"><?php esc_html_e('Remaining Days','danolink'); ?></th>
                    <th scope="col" style="text-align: center;"><?php esc_html_e('Link Type','danolink'); ?></th>
                    <th scope="col" style="text-align: center;"><?php esc_html_e('operations','danolink'); ?></th>

                  
                </tr>
            </thead>
            <tbody>
                <?php
                $sn = 1;
                
 while ($row = mysqli_fetch_assoc($result)) { 
    $expirationDate = $row['expiration_date'];
    $linkDate = $row['link_date'];
    $remainingDays = get_remaining_days($expirationDate);

        if ($remainingDays < 0) {
        $updateQuery = "UPDATE $table_name SET Remaining_days = 1 WHERE id = " . $row['id'];
         mysqli_query($conn, $updateQuery);
    }
    else {
      $updateQuery = "UPDATE $table_name SET Remaining_days = 0 WHERE id = " . $row['id'];
         mysqli_query($conn, $updateQuery);
    }

?>
 
                    <tr>
                        <th scope="row" style="text-align: center;"><?php echo ($sn+10*($page-1)); ?></th>
                        <td><?php echo  $row['link_name']; ?></td>
                        <td><a href="<?php echo $row['link_url'];?>" target="_blank"><?php echo $row['link_url']; ?></td>
                         <td><?php echo $row['link_date']; ?></td>
                         <td><?php echo $row['expiration_date']; ?></td>
                         <td><?php echo ($remainingDays < 0 ?  esc_html_e('The link has expired','danolink')  : ($remainingDays + 1 . esc_html_e('days left','danolink'))) ?></td>
                         <td><?php echo $row['link_type']; ?></td>
                         <td><a  class="btn btn-success" href='javascript:void(0)' onclick="editData(<?php echo $row['id'] ?>)" data-toggle='modal' data-target='#myModal'><i class="fa fa-edit"></i></a>
                         <a  class="btn btn-danger" href='javascript:void(0)' onclick="deleteData(<?php echo $row['id']?>)"><i class="fa fa-trash"></i></a></td>
                    </tr>
                  <?php $sn++;
 ?> 
                <?php } ?>
            </tbody>
        </table>
          <?php 
            $sql_total = "SELECT * FROM $table_name";
            $record = mysqli_query($conn,$sql_total);
            $total_record = mysqli_num_rows($record);
            $total_pages = ceil($total_record/$limit_per_page);
           ?>
        <div class="pagenation" id="pagenation">

            <?php if($page > 1){ ?>

            <a href="" id="<?php echo $page-1;?>" class="button-style btn btn-success"><?php esc_html_e('Previous','danolink'); ?></a>                    

            <?php } ?>

            <?php for ($i=1; $i <= $total_pages; $i++) { ?>
                <a id="<?php echo $i ?>" href="" class="link btn btn-primary"><?php echo $i ?></a>
            <?php } ?>

            <?php if($page != $total_pages){ ?>

            <a href="" id="<?php echo $page+1; ?>" class="button-style btn btn-success"><?php esc_html_e('Next','danolink'); ?></a> 

            <?php } ?>
          
        </div> 

</body>
  <!-- Modal -->
          <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title"><?php esc_html_e('Edit Link','danolink'); ?></h4>
        </div>
        <div class="modal-body">
            <div class="my-plugin-form-container">
          <p id="msg"></p>
    <form id="updateForm" method="POST">
       <input type="hidden" name="action" value="my_plugin_add_link">
<input name="id" type="hidden" >
            <label for="my_plugin_new_link_name"><?php esc_html_e('Link Name','danolink'); ?>:</label>
            <input type="text" name="link_name" id="link_name" required>

            <label for="my_plugin_new_link_url"><?php esc_html_e('Link URL','danolink'); ?>:</label>
            <input style="width: 300px;" type="url" name="link_url"  id="link_url" required>

            <label for="my_plugin_link_date"><?php esc_html_e('Link_date','danolink'); ?>:</label>
             <input type="date" name="link_date" id="link_date"  readonly>

             <label for="my_plugin_link_expiration_date"><?php esc_html_e('Expiration Date','danolink'); ?> :</label>
             <input type="text" data-jdp data-jdp-min-date="today" name="expiration_date" id="expiration_date" />

            <label for="my_plugin_link_type"><?php esc_html_e('Link Type','danolink'); ?>:</label>
            <select name="link_type" id="link_type">
                <option value="footer">footer</option>
                <option value="sidebar">sidebar</option>
            </select>

            <input type="submit" value="<?php esc_html_e('Save','danolink'); ?>">
    </form>
</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php esc_html_e('Close','danolink'); ?></button>
        </div>
      </div>

    </div>
  </div>

</div>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</html>


