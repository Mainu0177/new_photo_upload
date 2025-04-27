<?php  
include 'includes/header.php'; 

$error = "";
$success = "";

// check if the form has been submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_FILES['image'];


    if(empty($title) || empty($description)){
        $error = "All fields are required";
     } 
     else {
        $target_dir = 'assets/images/';

        if(!file_exists($target_dir)){
           mkdir($target_dir, 0777, true);
        }
   
        $file = $image['name'];
        $new_name = uniqid() . $file;
   
        $target_file = $target_dir . $new_name;
   
        if($image['size'] > 5000000) {
           $error = "File size is too large";
        } else {
           if(move_uploaded_file($image['tmp_name'], $target_file)){
            $sql = "INSERT INTO images (title, description, filename) VALUES (:title, :description, :filename)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                
                ':title' => $title,
                ':description' => $description,
                ':filename'   =>  $new_name
            ]);
            $success = "Image uploaded successfully";
            $title = "";
            $description = "";
           }
           
           else {
               $error = "Error uploading image";
           }    
        }
     }
   
}

?>


<div class="my-4">
        <h1>Photo Gallery</h1>
</div>

<?php if($success) :?>
<div class="alert alert-success" role="alert">
  <?php echo $success; ?>
</div>
<?php endif; ?>

<?php if($error) :?>
<div class="alert alert-danger" role="alert">
  <?php echo $error; ?>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" >      
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea type="text" class="form-control" name="description" >  </textarea>   
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Choice Image</label>
                <input type="file" class="form-control" name="image"/>  
            </div>
            
           
            <button type="submit" class="btn btn-success">Upload Photo</button>
         </form>
            </div>
       
        </div>
 
    </div>

</div>



<?php  
    include 'includes/footer.php';
?>