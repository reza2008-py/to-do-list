<?php
include("head.php");
$id=$_GET["id"];
$link=mysqli_connect("localhost","root","","onenewa-db");
$result=mysqli_query($link,"SELECT * FROM `news` WHERE id=$id");
mysqli_close($link);
$row=mysqli_fetch_array($result);
$title="";
$text="";
$imageurl="";
if($row){
    $title=$row["title"];
    $text=$row["text"];
    $imageurl=$row["imageurl"];
}
?>

<div class="row">
    <p class="col">خبر را ویرایش کنید</p>
</div>
<form action="news_edit_action.php" method="post" enctype="multipart/form-data" class="row m-2">
    <input type="file" class="col-12 col-md card m-1" 
    name="image" value="<?php echo($imageurl); ?>">

    <input type="text" class="col-12 col-md card m-1" 
    name="title" placeholder="عنوان" value="<?php echo($title); ?>">

    <input type="text" class="col-12 col-md card m-1" 
    name="id" placeholder="id" hidden value="<?php echo($id); ?>">

    <input type="text" class="col-12 col-md card m-1" 
    name="text" placeholder="متن خبر" value="<?php echo($text); ?>">

    <input type="submit" class="col-12 col-md card m-1" 
    value="ذخیره">
</form>

<?php
include("footer.php");
?>