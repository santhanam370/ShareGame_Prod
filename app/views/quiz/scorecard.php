<?php require_once PATHROOT.'/views/inc/header.php'; ?>
<div class="jumbotron jumbotron-flud text-center">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="container">
                <h1><?php echo $data['title']; ?></h1>
                <hr>
                    <div class="row">
                        <div class="col">
                            <p><?php echo $data["scoreinfo"]; ?></p>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<?php require_once PATHROOT.'/views/inc/footer.php'; ?>