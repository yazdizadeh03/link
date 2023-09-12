<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body>
 
    <div class="card-body">
       <div id="sampleTable">
         
       </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
    function lodetable(page){
          $.ajax({
            url : '../wp-content/plugins/best-link/table.php',
            type : 'POST',
            data : {page_no:page},
            success : function(data) {
              $('#sampleTable').html(data);
            }
          });
      }
      lodetable();

    $(document).on("click","#pagenation a",function(e) {
        e.preventDefault();
        var page_id = $(this).attr("id");
        lodetable(page_id);
    });


  });
</script>
</body>
</html>