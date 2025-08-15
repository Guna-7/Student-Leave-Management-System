<aside id="slide-out" class="side-nav white fixed" style="background-color: #20b2aa;">
    <div class="sidebar-container" style="height: 100vh; overflow-y: auto;">
        <!-- Sidebar content goes here -->
        <div class="side-nav-wrapper" style="background-color: #20b2aa;">
            <div class="sidebar-profile">
                <div class="sidebar-profile-image">
                    <img src="assets/images/profile-image.png" class="circle" alt="">
                </div>
                <div class="sidebar-profile-info">
                    <?php 
                        $eid=$_SESSION['eid'];
                        $sql = "SELECT StaffName ,staff_id from  tblstaff where ID=:eid";
                        $query = $dbh -> prepare($sql);
                        $query->bindParam(':eid',$eid,PDO::PARAM_STR);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $cnt=1;
                        if($query->rowCount() > 0) {
                            foreach($results as $result) { ?>  
                                <p style="color: black;"><?php echo htmlentities($result->StaffName);?></p>
                                <span style="color: black;"><?php echo htmlentities($result->staff_id)?></span>
                    <?php }} ?>
                </div>
            </div>
            <ul class="sidebar-menu collapsible collapsible-accordion" style="background-color: skyblue;" data-collapsible="accordion">
                <li class="no-padding"><a class="waves-effect waves-grey" href="stf-myprofile.php?staff_id=<?php echo $eid; ?>" style="color: black;">My Profiles</a></li>
                <li class="no-padding"><a class="waves-effect waves-grey" href="staff-change-password.php" style="color: black;"><i class="material-icons"></i>Change Password</a></li>
                <li class="no-padding">
                    <a class="collapsible-header waves-effect waves-grey" style="color: black;"><i class="material-icons"></i>Students Management<i class="nav-drop-icon material-icons"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="stf-students.php?staff_id=<?php echo $eid; ?>" style="color: black;">students</a></li>
                            <li><a href="stf-studentLeaves.php?staff_id=<?php echo $eid; ?>" style="color: black;">All Leaves</a></li>
                            <li><a href="stf-studentPendingleaves.php?staff_id=<?php echo $eid; ?>" style="color: black;">Pending Leaves</a></li>
                            <li><a href="downloadfiles.php" style="color: black;">Uploaded files</a></li>
                            
                            

                        </ul>
                    </div>
                </li>
                <li class="no-padding"><a class="waves-effect waves-grey" href="logout.php" style="color: black;"><i class="material-icons"></i>Logout</a></li>
                
            </ul>
        </div>
        <div class="footer">
            <p class="copyright"><a href="http://adhiyamaan.ac.in/ace/" style="color: black;">ACE</a>©</p>
        </div>
    </div>
</aside>
