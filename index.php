<?php  
include 'includes/header.php';  

$sql ="SELECT * FROM images ORDER BY upload_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(); // Fixed issue
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Debugging check
// print_r($images); 
?>

<div class="my-4">
    <h1>Photo Gallery</h1>
</div>

<div class="row">
<?php
if(count($images) > 0) {
    foreach($images as $image) {
?>
    <div class="card" style="width: 18rem;">
        <img src="assets/images/<?php echo $image['filename']; ?>" class="card-img-top" alt="Image">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($image['title']); ?></h5>
            <p class="card-text"><?php echo htmlspecialchars($image['description']); ?></p>
            <p class="card-text"><?php echo date('M, D, Y', strtotime($image['upload_date'])); ?></p>
        </div>
    </div>
<?php
    }
} else { ?>
    <div class="alert alert-danger" role="alert">
        <p>No Images Found</p>
    </div>
<?php } ?>

<?php  
include 'includes/footer.php';
?>