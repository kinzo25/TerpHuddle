<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" href="css/listyle.css" type="text/css" media="all">
	<script type="text/javascript" src="js/listjq.js"></script>
    <script type="text/javascript">
	$(document).ready(function(){
		$(".btn").click(function(){
			var eventid = $(this).attr('id');
			if(! window.focus)return true; 
				var gotourl = "verifyuser.php?cvnt="+eventid;
				window.open(gotourl, 'user_window', 'toolbar=no,left=600,top=350,resizable=yes,width=500,height=350');
				return false;
				location.reload();
			//document.location.href = gotourl;
			//$("#res").load("window.open(register_form.php, '_blank')");
		});
		
	});
	
$(function(){
	var progress=$('.progress');
	var state=$('.state');
	var txtWrap=$('.txtWrap');
	var max=Number($('#max').html());
	var min=Number($('#min').html());
	var cur=Number($('#cur').html());

	state.hover(function(){
        txtWrap.show();
	},function(){
        txtWrap.hide();
	});

	if(cur<min){
        progress.addClass('red');  
	}else if(cur>=min){
		if(cur>max){
            progress.addClass('orange');
		}else if(cur>(max*0.8)){
		    progress.addClass('yellow');
		}else{
            progress.addClass('green');
		}
	}
})
  </script>
  <?php  
        //print_r($_GET);
        $cat_id = $_GET[type_id];
		// construct query
	    $query1 = "SELECT name FROM event_type WHERE type_id = '$cat_id'";
	    // create connection
		$servername = 'localhost';
        $username = 'kchavda';
        $password = 'kchavda01';
        $dbname = 'g1';
	    $database = new mysqli($servername, $username, $password, $dbname);
	    // check connection
	    if ($database->connect_error) {
		    die("Connection failed: ". $database->connect_error);
	    }
	    // execute query
	    if ( !( $result = $database->query ($query1) ) )
		   print ("Warning! could not execute query <br />" );
		// display Category
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				   echo "<title>Category: $row[name]</title>";
					//echo '<div class="container">';
						//echo '<header>';
						//echo '<h1>'.$row[name].'</h1>';
						//echo '</header>';
					//echo '</div>';
				}
		}else{echo "0 results<br />";}
		$database->close(); // close the connection    
   ?>
	</head>
	<body>
		<header>
			<a href="http://g1.psjconsulting.com/"><img class="logo" src="images/logo_t.png"></a>
			<a class="nav" href="help.html">Help</a>
			<a class="nav" href="#">My Events</a>
			<a class="nav" href="new_event_form.php">Create an Event</a>
			<a class="nav" href="new_user_form.php">Sign Up</a>
			<a class="nav" href="http://g1.psjconsulting.com/">Home</a>
		</header>
		
		<?php 
            $cat_id = $_GET[type_id];				
			// create connection
			$servername = 'localhost';
			$username = 'kchavda';
			$password = 'kchavda01';
			$dbname = 'g1';
			$database = new mysqli($servername, $username, $password, $dbname);
			// check connection
			if ($database->connect_error) {
			   die("Connection failed: ". $database->connect_error);
			}		
			// execute query
			$query2 = "SELECT * FROM event WHERE type_id = '$cat_id' AND registration_deadline >= CURDATE() ORDER by date,title";
			if ( !( $result = $database->query ($query2) ) ) {
				print ("Warning! could not execute query <br />" );
			} else {
				// retrieve events
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						//retrieve event data into an array
						$vactive = $row["active"];
						if ($vactive == 1) {
							$vstatus = "Open";
						} else {$vstatus = "Closed";}
						$vtitle = $row["title"];
						$vdescr = $row["description"];
						$fdate = date_create($row["date"]);
						$vdate = date_format($fdate,'l, F j, Y');
						$ddate = date_format($fdate,'j');
						$mdate = date_format($fdate,'M');
						$vduration = $row["duration"];
						$vcost = $row["cost_perperson"];
						$fregdline = date_create($row["registration_deadline"]);
						$vregdline = date_format($fregdline, 'l, F j, Y');
						$vmaxgsize = $row["max_groupsize"];
						$vmingsize = $row["min_groupsize"];
						$venid = $row["venue_id"];
						$vntid = $row["event_id"];
						$vimage = $row["image_id"];
						//retieve venue address
						if (!($result2 = $database->query ("Select * FROM location WHERE venue_id ='$venid'"))) {
							print ("Warning! could not execute location query <br />");
						} else {
							if ($result2->num_rows > 0) {
								$row = $result2->fetch_assoc();
								//retrieve venue data into variables
								$vname = $row["venue_name"];
								$vaddr = $row["address"];
								$vaddr2 = $row["address2"];
								$vcity = $row["city"];
								$vstateid = $row["state_id"];
								$vzip = $row["zipcode"];
							}
						}
						//retrieve venue image
						if (!($result3 = $database->query ("Select * FROM image WHERE image_id ='$vimage'"))) {
							print ("Warning! could not execute image query <br />");
						} else {
							if ($result3->num_rows > 0) {
								$row = $result3->fetch_assoc();
								//retrieve venue address data into variables
								$vpath = $row["image"];
								$valt = $row["description"];
							}
						}
						//retrieve state 
						if (!($result8 = $database->query ("Select * FROM state WHERE state_id ='$vstateid'"))) {
							print ("Warning! could not execute state query <br />");
						} else {
							if ($result8->num_rows > 0) {
								$row = $result8->fetch_assoc();
								$vstate = $row["state_name"];
							}
						}
						//retrieve number of participants
						if ( !( $result9 = $database->query ( "SELECT Count(*) as totcnt from participant WHERE event_id = '$vntid'") ) ) {
							print ("Warning!   could not execute participant query <br />" );
						} else {
							if ($result9->num_rows > 0) {
								$row = $result9->fetch_assoc();
								$vcount = $row["totcnt"];
							}
						}
						//display data retrieved	
						echo '<div class = "clear">';
						echo '<section class ="event-title">';
							echo '<div class="content-wrap">';
								echo '<div class="col-wide">';
									echo '<p class="event-name">'.$vdate.'<p>';
									echo '<h1 class="event-name">'.$vtitle.'</h1>';
									echo '<img class="event-img" src="'.$vpath.'">';
								echo '</div>';
								echo '<div class="col-narrow">';
									echo '<div class="info-wrap">';
										echo '<table width="100%" class="table3">';
											echo '<tr>';
												echo '<td class="title-info" width="40%" align="right">Organizer</td>';
													//retrieve organizers
													if (!($result4 = $database->query ("Select * FROM participant WHERE event_id ='$vntid' and organizer=1"))) {
														print ("Warning! could not execute participant query <br />");	
													} else {
														//retrieve organizer information
														if ($result4->num_rows > 0) {
														    while ($row = $result4->fetch_assoc()) {
																	$vorgid = $row["user_id"];
																	if (!($result5 = $database->query ("Select * FROM user WHERE user_id ='$vorgid'"))) {
																		print ("Warning! could not execute participant query <br />");
																	} else {
																		if ($result5->num_rows > 0) {
																			$row = $result5->fetch_assoc();
																			$vfname = $row["first_name"];
																			$vlname = $row["last_name"];
																			echo '<td class="title-table" width="60%" align="left">'.$vfname." ".$vlname.'</td>';
																		}
																	}
															}
														}
													    else{echo '<td class="title-table" width="60%" align="left">Organizer Info Missing</td>';}
													}
											echo '</tr>';
											echo '<tr>';
												echo '<td class="title-info" width="40%" align="right">Maximum Size:</td>';
												echo '<td class="title-table" width="60%" align="left" id="max">'.$vmaxgsize.'</td>';
											echo '</tr>';
											echo '<tr>';
												echo '<td class="title-info" width="40%" align="right">Minimum Size:</td>';
												echo '<td class="title-table" width="60%" align="left" id="min">'.$vmingsize.'</td>';
											echo '</tr>';
											echo '<tr>';
												echo '<td class="title-info" width="40%" align="right">Current Size:</td>';
												echo '<td class="title-table" width="60%" align="left" id="cur">'.$vduration.'</td>';
											echo '</tr>';
										echo '</table>';
										echo '<div class="btn-wrap">';
											echo '<div class="hoverShow">';
												echo '<div class="state">';
													echo '<div class="progress"></div>';
												echo '</div>';
												echo '<div class="txtWrap">';
													echo '<div><p class="item">Minimum:</p><p class="val" id="smin">'.$vmingsize.'</p></div>';
													echo '<div><p class="item">Current:</p><p class="val" id="sCurrent">'.$vcount.'</p></div>';
												echo '</div>';
											echo '</div>';
										echo '</div>';	

										echo '<button class="btn" id="'.$vntid.'">Join</button>';
										
									echo '</div>';
								echo '</div>';
								echo '<div class="time">';
									echo '<div class="day">'.$ddate.'</div>';
									echo '<div class="month">'.$mdate.'</div>';
								echo '</div>';
							echo '</div>';
						echo'</section';
						// event-info and event address
						echo '<table class="table">';
							echo '<tr>';
								echo '<td width="60%" rowspan="3" class="event-wrap">';
									echo '<section class="event-info">';
										echo '<div>';
											echo '<p class="event-content">'.$vdescr. "<br/> Event Status: ".$vstatus. "<br />Registration Deadline: ".$vregdline.'</p>';
										echo '</div>';
										echo '<div class="cost">';
											echo '<div class="title-info">Cost</div>';
											echo '<div class="title-table">'.$vcost.'</div>';
										echo '</div>';
										echo '<div class="event-info">';
											// display participants informarion
											if (!($result6 = $database->query ("Select * FROM participant WHERE event_id ='$vntid' and organizer<>1"))) {
												print ("Warning! could not execute participant query <br />");	
											} else {
												echo '<p class="event-content">Participants: <br /></p>';
												//retrieve participants information
												if ($result6->num_rows > 0){
													while ($row = $result6->fetch_assoc()) {
														$vpartid = $row["user_id"];
														if (!($result7 = $database->query ("Select * FROM user WHERE user_id ='$vpartid'"))) {
															print ("Warning! could not execute participant query <br />");
														} else {
															if ($result7->num_rows > 0) {
																$row = $result7->fetch_assoc();
																$vfname = $row["first_name"];
																$vlname = $row["last_name"];
																$vemail = $row["email"];
																echo '<p>'.$vfname." ".$vlname.", ".$vemail.'</p>';
															}
														}
													}
												}else{echo '<p>Be the 1st to register for this event <br /></p>';}
											}
										echo '</div>';
									echo '</section>';
								echo '</td>';
								echo '<td width="40%" class="event-address">';
									echo '<table width="100%" class="table2">';
										echo '<tr>';
	                						echo '<td class="title-table" width="80%" align="left">'.$vname.'</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td class="title-table" width="80%" align="left">'.$vaddr."  ".$vaddr2.'</td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td class="title-table" width="80%" align="left">'.$vcity."  ".$vstate."  ".$vzip.'</td>';
										echo '</tr>';
									echo '</table>';
								echo '</td>';
							echo '</tr>';
						echo '</table>';
						echo '</div>';
					}
				}else{echo'No Event exist for this category <br />';}
			}
			$database->close(); // close the connection
		?>
	</body>
</html>
