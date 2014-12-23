 <script type="text/javascript">
            $(document).ready(function() { 
                $("#selGradeLevel").change(function(){                   
                     /*dropdown post */
                    $.ajax({
                    url:"<?php echo base_url(); ?>ajaxcallbacks/getClassByGradeLevel",    
                    data: {id: $(this).val()},
                    type: "POST",
                    success: function(data){
                        $("#selClass").html(data);
                        $("#selClass").prop('disabled', false);
                    }
                    });
                });
                $("#selClass").change(function(){                   
                     /*dropdown post */
                    $.ajax({
                    url:"<?php echo base_url(); ?>ajaxcallbacks/getStudentByClass",    
                    data: {id: $('#selClass').val()},
                    type: "POST",
                    success: function(data){
                        $("#selStudent").html(data);
                        $("#selStudent").prop('disabled', false);;
                    }
                    });
                });
            });
</script>
<div class="span9">
<div class="row-fluid">
     <div class="block">
        <div class="block-content collapse in">
          <div class="span12">
               <?php echo form_open('reports/reportcard', 'method="post" class="form-horizontal"'); ?>
                <fieldset>
                  <legend>Generate Report Cards</legend>
                  <div class="control-group">
                    <label class="control-label" for="selSemester">Semester</label>
                    <div class="controls">
                    <?php echo form_dropdown('selSemester', $gradelevels,'-1','class="required" id="selSemester"');  ?>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="selGradeLevel">Grade</label>
                    <div class="controls">
                    <?php echo form_dropdown('selGradeLevel', $gradelevels,'-1','class="required" id="selGradeLevel"');  ?>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="selClass">Class/Group</label>
                    <div class="controls">
                      <select name="selClass" id="selClass" disabled="" class="required">
                        <option value="-1" selected>All Classes/Groups</option>
                      </select>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="selStudent">Student</label>
                    <div class="controls" id="selStudentHolder">
                      <select name="selStudent" id="selStudent" disabled="" class="required">
                        <option value="-1" selected>All Studens</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-actions">
                    <?php echo form_submit('submit','Generate', 'class="btn btn-primary"'); ?>
                    <?php echo form_reset('reset','Reset', 'class="btn"'); ?>
                  </div>
                </fieldset>
              </form>
              <?php echo form_close(); ?>
          </div>
    </div>
  </div>

</div>
</div>