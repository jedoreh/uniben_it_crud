<?php

    include('db.php');

    if(isset($_POST['productname'])){
        //echo 'You entered ' . $_POST['productname'];

        $productname = $_POST['productname'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];


        $query = "INSERT INTO product(productname,description,price,quantity) VALUES('{$productname}', '{$description}', {$price}, {$quantity})";
        $run_query = mysqli_query($conn, $query);

        if(!$run_query){
            die('Error: ' . mysqli_error($conn));
        }

        echo $productname . ' Successfully Inserted';


    }

    
    if(isset($_POST['updateproduct'])){
        //echo 'You entered ' . $_POST['productname'];

        $productname = $_POST['productname'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $productid=$_POST['productid'];

        $query = "UPDATE product SET productname='{$productname}',description='{$description}',price={$price},quantity={$quantity} WHERE id={$productid}";
        $run_query = mysqli_query($conn, $query);

        if(!$run_query){
            die('Error: ' . mysqli_error($conn));
        }

        header("Location: viewproducts.html");

    }

    if(isset($_POST['viewdata'])){
        $query = 'SELECT * FROM product';
        $run_query = mysqli_query($conn, $query);

        

        while($row = mysqli_fetch_array($run_query)){
            echo "<div class='col-6 col-md-4 bg-info'><h3>".$row['productname']."</h3><br><p>Price: ".$row['price']."</p><p>".$row['description']."</p><button id='select".$row['id']."' data-id='".$row['id']."' class='btn btn-primary selectproduct'>Edit</button></div>";
        }

    }

    if(isset($_POST['productselected'])){
        $productid = $_POST['productid'];
        $query = "SELECT * FROM product WHERE id={$productid}";
        $run_query = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($run_query);
        echo "<div class='row'>".
            "<div class='.col-md-6 .offset-md-3'>".
                "<div class='alert alert-primary' role='alert'>".
                    "<p id='info'></p>".
                "</div>".
                "<form method='POST' id='update-product' action='process.php'>".
                    "<div class='mb-3'>".
                        "<label for='productname' class='form-label'>Product Name</label>".
                        "<input type='text' name='productname' class='form-control' value='".$row['productname']."' id='productname' placeholder='Product Name' required>".
                    "</div>".
                    "<div class='mb-3'>".
                        "<label for='description' class='form-label'>Description</label>".
                        "<textarea name='description' class='form-control' id='description' rows='3'>".$row['description']."</textarea>".
                    "</div>".
                    "<div class='mb-3'>".
                        "<label for='price' class='form-label'>Product Price</label>".
                        "<input type='text' name='price' class='form-control' value='".$row['price']."' id='price' placeholder='Price' required>".
                    "</div>".
                    "<div class='mb-3'>".
                        "<label for='quantity' class='form-label'>Product Quantity</label>".
                        "<input type='number' name='quantity' min='0' max='100' class='form-control' value='".$row['quantity']."' id='quantity' value='1' placeholder='Quantity'>".
                    "</div>".
                    "<div class='mb-3'>".
                        "<input type='hidden' name='productid' class='form-control' value='".$row['id']."' id='productid'>".
                        "<input type='hidden' name='updateproduct' class='form-control' value='updateproduct' id='productid'>".
                        "<input type='submit' class='btn btn-primary' value='Update Product'>".
                        "<button class='btn btn-primary'>Update Picture</button>".
                        "<input type='reset' class='btn btn-success' value='Reset'>".
                    "</div>".
                "</form>".
            "</div>".
        "</div>".
    "</div>";
    }




?>

<script src='assets/js/jquery.js'></script>
<script>

$(document).ready(function(){

$('.selectproduct').on('click', function(evt){
            evt.preventDefault()
            var productid = $(this).attr('data-id')

            var productselected = 'productselected'
            $.post('process.php', {productid: productid, productselected: productselected}, function(data){
                $('#display').html(data)
            })

})

    $("#update-product").submit(function(evt){
                

                var url = $(this).attr("action")
                var postData = $(this).serialize()

                $.post(url, postData,function(data){
                   
                    console.log(postData)
                    $(".alert").show()
                    $("#info").html(data)
                    
                })

               

            })


})


</script>