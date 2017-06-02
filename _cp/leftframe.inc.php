<div id="left">
<div class="media user-media">
<a class="user-link" href="">
<img class="media-object img-thumbnail user-img" alt="User Picture" src="assets/img/user.gif">
</a>

<div class="media-body">
<h5 class="media-heading"><?php echo $_SESSION['username'];
 ?></h5>
<ul class="list-unstyled user-info">
<li><a href="javascript:void(0)">Administrator</a></li>
<li style="font-size: 12px;"><i class="fa fa-calendar"></i>&nbsp;Last Access : <br>
<small style="font-size: 12px;"><?php echo date('d, M, H:i:s', strtotime($_SESSION['lastLogin'])); ?></small>
</li>
</ul>
</div>
</div>
<ul id="menu" class="collapse">
    <li class="nav-divider"></li>
    
    <li class="panel"><a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#gallery-nav"><i class="fa fa-picture-o"></i> Gallery<span class="pull-right"><i class="fa fa-angle-left"></i></span></a>
        <ul class="collapse" id="gallery-nav">
            <li class=""><a href="Basic-Module/Alb_CreateNewAlbum.php">Create Album</a></li>
            <li class=""><a href="Basic-Module/Alb_UploadImg.php">Upload Image</a></li>
        </ul>
    </li>
    <li class="panel "><a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed"
    data-target="#news-nav"><i class="fa fa-newspaper-o"></i> News Updates<span class="pull-right"><i class="fa fa-angle-left"></i></span></a>
        <ul class="collapse" id="news-nav">
            <li class=""><a href="Basic-Module/UploadEventHeading.php">Create New News</a></li>
            <li class=""><a href="Basic-Module/ListEvents.php">View All News</a></li>
        </ul>
    </li>
   <li class="panel "><a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed"
    data-target="#upd-nav"><i class="fa fa-pencil"></i> Notice<span class="pull-right"><i class="fa fa-angle-left"></i></span></a>
        <ul class="collapse" id="upd-nav">
            <li class=""><a href="Basic-Module/UploadNoticeUpdate.php">Create New </a></li>
        </ul>
    </li>
    <li class="panel "><a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#mails-nav"><i class="fa fa-envelope"></i> Contacts & Mails<span class="pull-right"><i class="fa fa-angle-left"></i></span></a>
      <ul class="collapse" id="mails-nav">
          <li class=""><a href="Basic-Module/MailViewList.php">Mails</a></li>
        </ul>
    </li>
    <li class="panel "><a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#document-nav"><i class="fa fa-folder-open-o"></i> Documents & Files<span class="pull-right"><i class="fa fa-angle-left"></i></span>
    </a>
        <ul class="collapse" id="document-nav">
            <li class=""><a href="Basic-Module/Adm_UploadData.php">Upload Document</a></li>
        </ul>
    </li>
    <!--<li class="panel "><a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#dashboard-prod"><i class="fa fa-envelope"></i> Contacts<span class="pull-right"><i class="fa fa-angle-left"></i></span></a>
      <ul class="collapse" id="dashboard-prod">
          <li class=""><a href="Basic-Module/MailViewList.php">Mails</a></li>
        </ul>
    </li>
    
    <li class="panel "><a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed"
    data-target="#form-testimonilas"><i class="fa fa-file"></i> Testimonials<span class="pull-right"><i class="fa fa-angle-left"></i></span></a>
        <ul class="collapse" id="form-testimonilas">
            <li class=""><a href="Basic-Module/UploadTestimonial.php">Upload New Testimonials</a></li>
            
        </ul>
    </li>
    
    
    <li class="panel "><a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed"
    data-target="#form-menunav"><i class="fa fa-file"></i> Site Content<span class="pull-right"><i class="fa fa-angle-left"></i></span></a>
        <ul class="collapse" id="form-menunav">
            <li class=""><a href="Basic-Module/UploadMenuDescription.php">Manage </a></li>
            <li class=""><a href="Basic-Module/UploadMenu.php">Add New </a></li>
        </ul>
    </li>
    
    <li class="panel "><a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed"
    data-target="#form-staff"><i class="fa fa-file"></i> Staff<span class="pull-right"><i class="fa fa-angle-left"></i></span></a>
        <ul class="collapse" id="form-staff">
            <li class=""><a href="Staffs/CreateStaff.php">Create New Staff</a></li>
            <li class=""><a href="Staffs/StaffList.php">Staff List</a></li>
        </ul>
    </li>
    
     
    -->
</ul>
<!-- /#menu -->
</div>

