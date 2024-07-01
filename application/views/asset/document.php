<!-----------------------------------------------------------------------------------------------------> 
<!--                                                                                                 --> 
<!--                                        D O C U M E N T                                         -->  
<!--                                                                                                 -->  
<!----------------------------------------------------------------------------------------------------->


 <div id="document" class="tab-pane fade <?php echo (($active_tab === 'document') ? 'in active' : '') ?>">

      <div class="box">
        <div class="box-body">
          <div class="row">
            <div class="col-md-12 col-xs-12">                            


              <?php echo form_open_multipart('asset/uploadDocument') ?>
              <?php echo "<table width='100%'>" ?>
              <?php echo "<tr>" ?>
              <?php echo "<td width='10%' align=left><input type='file' required='required' name='asset_document' id='asset_document' size='60'  /></td>" ?>  
              <?php echo "<td><input type='submit' name='submit' class='btn btn-primary' value='Add Document' /></td>" ?>  
              <?php echo "</tr>" ?>
              <?php echo "</table>" ?>              
              <?php echo "</form>"?>

              <br>

              <div class="col-md-12 col-xs-12">
                <table id="manageTableDocument" class="table table-bordered table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <th>Document</th>
                      <th>Size</th>
                      <th>Action</th>                                    
                    </tr>
                  </thead>
                </table>  
            </div>  
          </div>
        </div> 

        <div class="box-footer">
            <a href="<?php echo base_url('asset/') ?>" class="btn btn-warning">Close</a>
        </div>

      </form>
    </div>
  </div>
  </div>


<!-- Delete Document -->

<?php if(in_array('deleteDocument', $user_permission)): ?>

<div class="modal fade" tabindex="-1" role="dialog" id="removeDocumentModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Document</h4>
      </div>
      <form role="form" action="<?php echo base_url('asset/removeDocument') ?>" method="post" id="removeFormDocument">
        <div class="modal-body">
          <p>Do you really want to delete?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php endif; ?>


<!--  End of the form  -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</div>


<!------------------------------------->
<!-- Javascript part of Document    --->
<!------------------------------------->

<script type="text/javascript">
var manageTableDocument;
var base_url = '<?php echo base_url(); ?>';
var document_asset_id = <?php echo $asset_data['asset_id']; ?>;
var document_type_id = 'all';  //for all type of documents

  $("#DocumentAssetNav").addClass('active');

  // initialize the datatable 
  manageTableDocument = $('#manageTableDocument').DataTable({
    'ajax': {
          url: base_url + 'asset/fetchAssetDocument/',
          type: 'POST',
          dataType: 'json',
          data: {document_asset_id: document_asset_id, document_type_id: document_type_id},
          },        
    'order': [[0, "asc"]]
  });


function removeDocument(document_id)
{
  if(document_id) {
    $("#removeFormDocument").on('submit', function() {

      var form = $(this);
      
      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { document_id:document_id }, 
        dataType: 'json',
        success:function(response) {

          manageTableDocument.ajax.reload(null, false); 

          if(response.success === true) {
            // hide the modal
            $("#removeDocumentModal").modal('hide');

          } else {

            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>'); 
          }
        }
      }); 

      return false;
    });
  }
}
</script>