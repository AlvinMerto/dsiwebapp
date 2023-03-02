<p class='mg-b-5'> Comment </p>
<textarea id='thecommenttxt' 
          class='dsitxtbox' 
          style='width:300px; height:200px;resize:none;'><?Php if(count($comment)>0) {echo $comment[0]->thecomment;} ?></textarea>
<br/><br/>

<?php if ($isowner || $allowed) { ?>
    <?php if ($action == "new") {?>
        <button class='dsibutton' id='addcommentbtn'> Add Comment </button>
    <?php } else { ?>
        <button class='dsibutton' id='updatecommentbtn'> Update Comment </button>
    <?php } ?>
<?php } ?>