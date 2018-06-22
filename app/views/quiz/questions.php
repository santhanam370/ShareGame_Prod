<?php require_once PATHROOT.'/views/inc/header.php'; ?>
<div class="jumbotron jumbotron-flud text-center">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="container">
                <h1><?php echo $data['title']; ?></h1>
                <hr>
                <form id='form' name='form' action="<?php echo ($data['context']=='answer' ? BASEURL.'/Quizes/questions' : BASEURL.'/Quizes/answeredQuestions'); ?>" method="POST">
                    <div class="form-group">
                        <lable><strong><?php echo $data['question']?></strong></lable>
                    </div>
                    <div id="options">
                    <?php 
                    $count=1;
                    foreach($data['options'] as $option){?>
                    <div class="row">
                        <div  class="col">
                            <input type="button" id="<?php echo 'option'.$count; ?>" value="<?php echo $option;?>" onclick="makeSelection(this);"  class="btn btn-block">
                        </div>
                    </div>
                    <?php $count++; } ?>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="Submit" id="submit" value="Submit" class="btn btn-block">
                        </div>
                    </div>
                    <?php if($data['context']=='verifyanswer'){?>
                    <div class="row">
                        <div class="col">
                            <lable><strong>Score: <span id="scoreCard" name="scoreCard" ><?php echo $data['score']; ?></span>/<?php echo $data['totalScore']; ?> </strong></lable>
                        </div>
                    </div>
                    <?php }?>
                    <input type="hidden" id="optionCount" name="optionCount" value="<?php echo count($data['options']);?>">
                    <input type="hidden" id="selectedOption" name="selectedOption" value="">
                    <input type="hidden" id="questionnumber" name="questionnumber" value="<?php echo $data['questionnumber'];?>">
                    <input type="hidden" id="id" name="id" value="<?php echo $data['id'];?>">
                    <input type="hidden" id="correctOption" name="correctOption" value="<?php echo $data['correctOption'];?>">
                    <input type="hidden" id="context" name="context" value="<?php echo $data['context'];?>">
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once PATHROOT.'/views/inc/footer.php'; ?>