<?php
try{
 $sever='127.0.0.1:3307';
 $user='root';
 $password='';
 $database='project';
 $con=mysqli_connect( $sever,$user,$password, $database);
}catch(mysqli_sql_exception){
    echo "can'n connect to the database";
}
 
 if(isset($_POST['add'])){
    $item=$_POST['item'];
    if(!empty($item)){
        $query="INSERT INTO list(name) VALUES('$item')";
        if(mysqli_query($con,$query)){
            echo'
            <center>
            <div class="alert alert-success" role="alert">
                Item added successfully
            </div>
            </center>
            ';
        }
    }

 }

 if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    // Handle GET request
    // echo "This is a GET request.";
    if($_GET['action']=='delete'){
        $item=$_GET['item'];
        $query="DELETE FROM list WHERE id='$item'";
        if(mysqli_query($con,$query)){
            echo'
            <center>
                <div class="alert alert-danger" role="alert">
                    Item Delete successfully
                </div>
            </center>
    
            ';
        }else{
            echo mysqli_error($con);
        }
    
     }
    
     elseif($_GET['action']=='done'){
        $item=$_GET['item'];
        $query="UPDATE list SET status=1 WHERE id='$item'";
        if(mysqli_query($con,$query)){
            echo '
            <center>
              <div class="alert alert-info" role="alert">
                    Item Marked as Done
                </div>
                
            </center>
            ';
        }else{
            echo mysqli_error($con);
        }
    
     }
    

} 
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
    .done{
        text-decoration: line-through;
    }
</style>
</head>
<body>
    <main>
        <div class="container pt-5">
            <div class="row">
                <div class="col-sm-12 col-md-3"></div>
                 <div class="col-sm-12 col-md-6">
                  <div class="card">
                <div class="card-header">
                    <p>ToDo List</p>
                </div>
               <div class="card-body">
                <form action="project.php" method="post">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="item" placeholder="Add a item">
                    </div>
                    <input type="submit" class="btn btn-dark" name="add" value="Add item">
                </form>
                <div class="mt-5 mb-5">
                  
                   <?php
                    $query='SELECT* FROM list';
                    $result=mysqli_query($con,$query);
                    if($result->num_rows > 0){
                        $i=1;
                        while($row=$result->fetch_assoc()){
                          $done=$row['status']== 1 ?"done":'';
                        echo '
                              <div class="row mt-4">
                   <div class="col-sm-12 col-md-1"><h5 class="'.$done.'">'.$i.'</h5></div>
                    <div class="col-sm-12 col-md-6"><h5 class="'.$done.'">'.$row['name'].'</h5></div>
                    <div class="col-sm-12 col-md-5">
                        <a href="?action=done&item='.$row['id'].'" class="btn btn-outline-dark">Mark as Done</a>
                        <a href="?action=delete&item='.$row['id'].'" class="btn btn-outline-danger">Delete</a>
                    </div>
               </div>
                        ';
                        $i++;
                    }
                }
                    else{
                       echo '
                         <center>
                        <img src="folder.png" width="120px" alt="Empty List"><br><span>your List is Empty</span>
                    </center>
                       '; 
                    }
                    ?>
            </div>
        </div>
    </main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>   
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>  
<script>
    $(document).ready(function(){
        $ (".alert").fadeTo(4000,400).slideUp(400,function(){
            $('.alert').slideUp(400);

        })
    })
    </script>
</body>
</html>