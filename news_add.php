<?php
include("head.php");
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg p-4 rounded border-0">
                <h4 class="text-center font-weight-bold mb-4 text-primary">افزودن خبر جدید</h4>

                <form action="news_add_action.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="font-weight-bold">تصویر خبر:</label>
                        <input type="file" class="form-control-file border p-2 rounded shadow-sm" name="image">
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">عنوان خبر:</label>
                        <input type="text" class="form-control shadow-sm" name="title" placeholder="عنوان خبر را وارد کنید">
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">متن خبر:</label>
                        <textarea class="form-control shadow-sm" name="text" placeholder="متن خبر را وارد کنید" rows="5"></textarea>
                    </div>

                    <div class="text-center">
                        <input type="submit" class="btn btn-primary btn-lg shadow-sm px-4 rounded-pill" value="ذخیره خبر">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>
