<?php require_once PATHROOT.'/views/inc/header.php'; ?>
<div class="jumbotron jumbotron-flud text-center">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="container">
                <h1><?php echo $data['title']; ?></h1>
                <hr>
                <form action="<?php echo BASEURL.'/user/register'?>" method="POST">
                    <div class="form-group">
                        <lable for="name"><strong>Name: <sup>*</sup></strong></lable>
                        <input type='text' id='name' name='name' class="form-control form-control-lg <?php echo (!empty($data['nameerror']) ? 'is-invalid' : ''); ?>"  value="<?php echo $data['name']; ?>"></input>
                        <span class="invalid-feedback"><?php echo $data['nameerror']; ?></span>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Create Quiz" class="btn btn-success btn-block">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once PATHROOT.'/views/inc/footer.php'; ?>