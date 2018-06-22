<?php require_once PATHROOT.'/views/inc/header.php'; ?>
<div class="jumbotron jumbotron-flud text-center">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="container">
            
                <div id="fb-root"></div>
                
                <h1><?php echo $data['title']; ?></h1>
                <hr>
                <form>
                    <p>Let your friends guess your answers. Share it through ..</p>
                    <div class="row">
                        <div class="col">
                            <input type="button" class="btn btn-primary btn-block" value="facebook" onclick="shareinfacebook();">
                        </div>
                        <div class="col">
                            <input type="button" value="WhatsApp" class="btn btn-success btn-block" onclick="shareinwhatsapp();">
                            <!--<spanid="whatsapp_share_android">
                                <a id= href="whatsapp://send?text=<?php //echo $data['urlref']; ?>" /><input type="button" value="WhatsApp" class="btn btn-success btn-block"></a>
                            </span>-->
                        </div>
                        <div class="col">
                            <input type="button" id="clipbrdbtn" name="clipbrdbtn" value="Copy to Clipboard" onclick="copytoclipboard();" class="btn  btn-block">
                        </div>
                    </div>
                    <input type="hidden" value=<?php echo $data['urlref'];?> id="urlref" name="urlref">
                </form>
            </div>
        </div>
    </div>
</div>

<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0';
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php require_once PATHROOT.'/views/inc/footer.php'; ?>