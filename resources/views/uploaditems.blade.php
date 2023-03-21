<x-app-layout>
    @section("title","Uploads Items")
   <div class="br-mainpanel pd-30">
        <div class='bgwhite'>
            <div class='dsibox pd-t-15 pd-b-15'>
                <div class='row flex pd-l-20 pd-r-20 pd-b-10 dsibox'>
                    <div class='col-md-12 flex' style='justify-content:space-between;'>
                        <div>
                            <h5 class='pageh'> Items: {{$cats}}</h5> 
                        </div>
                        <div>
                            <button class='btn btn-danger' id='removeitemfromitemstbl'> Remove </button>
                            <button class='dsibutton' data-toggle='modal' data-target='#enternewcategory'> Enter new Category </button>
                        </div>
                    </div>
                </div>
                <div class='row pd-l-20 pd-r-20 pd-t-10'> 
                    <div class='col-md-3'>
                        <div class='dsibox'>
                            <div class='removepmarg pd-b-20'>
                                <select class='dsitxtbox' id='thecategoryselect' name='thecategoryselect'>
                                    <?php
                                        foreach($categories as $c) {
                                            $selected = null;
                                            if ($cats != false) {
                                                if ($cats == $c->category) {
                                                    $selected = "selected";
                                                } else {
                                                    $selected = null;
                                                }
                                            }
                                            echo "<option {$selected}>{$c->category}</option>";
                                        }
                                    ?>
                                </select>
                                <div class="mg-t-10" style='justify-content:space-between;'>
                                    <button class='dsibutton' id='filterbutton'> Filter </button>
                                    <?php if ($cats != false) { ?>
                                        <a href="{{ url('') }}/uploaditems" style='color:#a4a4a4; margin-left: 15px;'> clear filter </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php if ($cats != false) { ?>
                            <div class='dsibox'>
                                <div class='pd-b-20 pd-t-20'> 
                                    <p> Upload items</p>
                                    <form method='post' action="{{route('uploaditems')}}/<?php echo $cats; ?>" enctype='multipart/form-data'>
                                        @csrf
                                        <input type='file' name='itemuploadfile'/> 
                                        <input type='submit' value='Upload File' class='dsibutton mg-t-10' />
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class='col-md-9'>
                        <div class="table-wrapper">
                            <table id='datatable1'>
                                <thead>
                                    <th> &nbsp; </th>
                                    <th> # </th>
                                    <th> Category </th>
                                    <th> Item Name </th>
                                    <th> Description </th>
                                    <th> Markup </th>
                                    <th> Item Price </th>
                                    <th> Taxable </th>
                                </thead>
                                <tbody>
                                    <?php
                                        if (count($allitems) > 0) {
                                            $count = 1;
                                            foreach($allitems as $a) {
                                                echo "<tr>";
                                                    echo "<td><input type='checkbox' class='itemscheckbox' value='{$a->itemid}'/></td>";
                                                    echo "<td>{$count}</td>";
                                                    echo "<td>{$a->category}</td>";
                                                    echo "<td class='intablink dsitext' data-tab='displayitemview' data-id='{$a->itemid}' id='showitemview' data-toggle='modal' data-target='#itemview'>{$a->itemname}</td>";
                                                    echo "<td>{$a->description}</td>";
                                                    echo "<td>{$a->markup}</td>";
                                                    echo "<td>".number_format($a->itemprice,2)."</td>";

                                                    if ($a->istaxable == 1) {
                                                        echo "<td>Taxable</td>";
                                                    } else {
                                                        echo "<td>Non-Taxable</td>";
                                                    }
                                                    
                                                echo "</tr>";
                                                $count++;
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

        <div id="itemview" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" id='itemdivbox' role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Insert Item<span id='windowselected'> </span> </h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class=''>
                        <span id='intabviewspan'></span>
                    </div>
                </div>

              </div>
            </div>
        </div>

        <div id="enternewcategory" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" id='itemdivbox' role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Insert Item<span id='windowselected'> </span> </h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class=''>
                        <table class='dsismalltable removepmarg'> 
                            <tr>
                                <td> <p> Enter new Category </p> </td>
                                <td> <input type='text' class='dsitxtbox' id='categorytxtbox'/> </td>
                            </tr>
                            <tr>
                                <td> &nbsp; </td>
                                <td> <button class='dsibutton' id='createnewcategory'> Create New Category </button> </td>
                            </tr>
                        </table>
                    </div>
                </div>

              </div>
            </div>
        </div>
        