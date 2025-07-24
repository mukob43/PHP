<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loop for Show Product</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- DataTable CSS -->
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css" rel="stylesheet">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>


    <style>
        .container{
            max-width: 800px;;
        }
    </style>
</head>
<body>
    <?php
    $products = [
        ['id'=>1001, 'name'=>'Apple', 'price'=>60, 'quantity'=>50],
        ['id'=>1002, 'name'=>'Banana', 'price'=>25, 'quantity'=>100],
        ['id'=>1003, 'name'=>'Orange', 'price'=>40, 'quantity'=>70],
        ['id'=>1004, 'name'=>'Mango', 'price'=>55, 'quantity'=>60],
        ['id'=>1005, 'name'=>'Grapes', 'price'=>80, 'quantity'=>45],
        ['id'=>1006, 'name'=>'Pineapple', 'price'=>70, 'quantity'=>30],
        ['id'=>1007, 'name'=>'Papaya', 'price'=>35, 'quantity'=>40],
        ['id'=>1008, 'name'=>'Watermelon', 'price'=>90, 'quantity'=>25],
        ['id'=>1009, 'name'=>'Strawberry', 'price'=>100, 'quantity'=>35],
        ['id'=>1010, 'name'=>'Blueberry', 'price'=>120, 'quantity'=>20],
        ['id'=>1011, 'name'=>'Kiwi', 'price'=>85, 'quantity'=>50],
        ['id'=>1012, 'name'=>'Peach', 'price'=>60, 'quantity'=>40],
        ['id'=>1013, 'name'=>'Pear', 'price'=>50, 'quantity'=>65],
        ['id'=>1014, 'name'=>'Cherry', 'price'=>110, 'quantity'=>30],
        ['id'=>1015, 'name'=>'Guava', 'price'=>45, 'quantity'=>55]  
    ];

    // foreach ($products as $product) {
    //         echo $product['id'] , "ชื่อสินค้า: " , $product['name'] , "ราคา: " , $product['price'] , "จำนวน: " , $product['quantity'],"ชิ้น<br>";
    //     }
    ?>

    <div class = "container mt-5">
        <h1>Product List</h1>

        <form action="" method="POST" calss="mb-3">
        <div>
            <input type="number" name="price" placeholder="Enter Price" class="form-control mb-2">
            <button type="submit" class="btn btn-primary">Fillter</button>
        </div>
        </form>
        <table id="productTable"class ="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>id</th>
                    <th>ชื่อสินค้า</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                </tr>
            </thead>
            <tbody>

            <?php

            //check if form is submit
            if(isset($_POST['price']) && !empty($_POST['price'])){
                $filterprice = $_POST['price'];
                $filterproducts = array_filter($products, callback: function($product) use ($filterprice){return $product['price'] == $filterprice;});
                $filterproducts = array_values($filterproducts);
            
            }
            else{
                $filterproducts = $products;
            }

            foreach ($filterproducts as $index => $product) {
            // echo $product['id'] , "ชื่อสินค้า: " , $product['name'] , "ราคา: " , $product['price'] , "จำนวน: " , $product['quantity'],"ชิ้น<br>";
            echo "<tr>";
            echo "<td>".($index+1)."</td>";
            echo "<td>",$product['id'],"</td>";
            echo "<td>",$product['name'],"</td>";
            echo "<td>",$product['price'],"</td>";
            echo "<td>",$product['quantity'],"</td>";
            echo "</tr>";
            }
            ?>
            </tbody>
        </table>

    </div>

    <script>scr="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"</script>
    <script>
        let table = new DataTable('#productTable');
    </script>
    <hr>
    <a href="index.php">Home</a>
</body>
</html>