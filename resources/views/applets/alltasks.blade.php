<?php if (count($data) > 0) {?>
    <?php foreach($data as $d) { ?>
        <a href="{{route('customer')}}/<?php echo $d->custid; ?>"class="contact-list-link new">
            <div class="d-flex">
                <!-- <div class="pos-relative">
                    <img src="http://via.placeholder.com/280x280" class="wd-40 rounded-circle" alt="">
                    <div class="contact-status-indicator bg-success"></div>
                </div> -->
                <div class="contact-person">
                <span class="tx-12 op-5 d-inline-block"> DUE: <?php echo date("M. d, Y @ h:i A", strtotime($d->taskdatetime)); ?></span>
                    <p class="mg-b-0"><?php echo $d->reference; ?></p>
                    <span class="tx-12 op-5 d-inline-block"> <?php echo $d->companyname; ?></span>
                </div>
            </div>
        </a>
    <?php } ?>
<?php } else { ?>
    <p> no task assigned for you today </p>
<?php } ?>