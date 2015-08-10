<div class="span9" id="content">
  <div class="row-fluid">
    <?php echo $this->load->view('templates/breadcrumb.php');?>
      <div class="block">
          <div class="block-content collapse in">
              <div class="span12">
                <?php $this->load->view('shared/display_notification.php');?>
                <h3><?php echo $page_title;?></h3>
                <div class="table-toolbar">
                      <div class="btn-group">
                        <a href="/courses/assignteacher/<?php echo $course_id?>"><button class="btn btn-success">Assign Teacher&nbsp;<i class="icon-plus icon-white"></i></button></a>
                      </div>
                </div>      
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Course Title</th>
                      <th>Term</th>
                      <th>Grade Level</th>
                      <th>Teacher</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php if($query) { foreach($query as $course) { ?>
                    <tr>
                      <td><?php echo $course->course_title . " - " . $course->short_name?></td>
                      <td><?php echo $course->term ?></td>
                      <td><?php echo $course->grade_level ?></td>
                      <td><?php echo $course->full_name ?></td>
                      <td><a href='/courses/reassignteacher/<?php echo urlencode($course->term_course_id); ?>'>edit</a></td>
                      <td><a href='/courses/scheduleteacher/<?php echo urlencode($course->term_course_id); ?>'>Schedule</a></td>
                    </tr>
                  <?php } } ?>
                  <tbody>
                </table>
            </div>
        </div>
      </div>
  </div>
</div>