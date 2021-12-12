<?php
    foreach ($mess as $m) {

        if($m["author"]===$_SESSION["user"]["email"]){
            ?>
<li class="message right appeared">
    <div class="avatar">You</div>
    <div class="text_wrapper">
        <div class="author_right"><?=$m["author"]."  (YOU)"?></div>
        <div class="text"><?=$m["text"]?></div>
    </div>
</li>
<?php
        }else{
            ?>
<li class="message left appeared">
    <div class="avatar"><?=ucfirst($m["author"][0])?></div>
    <div class="text_wrapper">
        <div class="author_left"><?=$m["author"]?></div>
        <div class="text"><?=$m["text"]?></div>
    </div>
</li>
<?php
        }
    };
    ?>
<script>
