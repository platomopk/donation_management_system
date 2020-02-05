
	$().ready(function() {

		$('#msgYes').click(function(event) {
			$('#msgYesWrapper').toggle();
			if($('#msgYesWrapper').is(':visible')){
				$('#msgYesCaret').toggleClass('fa-caret-up fa-caret-down');
			}else{
				$('#msgYesCaret').toggleClass('fa-caret-down fa-caret-up');
			}

			$('#msgYes').removeClass("msgRCHeaderCollapsed").addClass('msgRCHeaderExpanded');
			$('#msgMaybe').removeClass("msgRCHeaderExpanded").addClass('msgRCHeaderCollapsed');
			$('#msgNo').removeClass("msgRCHeaderExpanded").addClass('msgRCHeaderCollapsed');
			$('#msgNYR').removeClass("msgRCHeaderExpanded").addClass('msgRCHeaderCollapsed');
		});

		$('#msgMaybe').click(function(event) {
			$('#msgMaybeWrapper').toggle();
			if($('#msgMaybeWrapper').is(':visible')){
				$('#msgMaybeCaret').toggleClass('fa-caret-down fa-caret-up');
			}else{
				$('#msgMaybeCaret').toggleClass('fa-caret-up fa-caret-down');
			}


			$('#msgYes').removeClass("msgRCHeaderCollapsed").addClass('msgRCHeaderCollapsed');
			$('#msgMaybe').removeClass("msgRCHeaderCollapsed").addClass('msgRCHeaderExpanded');
			$('#msgNo').removeClass("msgRCHeaderExpanded").addClass('msgRCHeaderCollapsed');
			$('#msgNYR').removeClass("msgRCHeaderExpanded").addClass('msgRCHeaderCollapsed');
		});

		$('#msgNo').click(function(event) {
			$('#msgNoWrapper').toggle();
			if($('#msgNoWrapper').is(':visible')){
				$('#msgNoCaret').toggleClass('fa-caret-down fa-caret-up');
			}else{
				$('#msgNoCaret').toggleClass('fa-caret-up fa-caret-down');
			}

			$('#msgYes').removeClass("msgRCHeaderCollapsed").addClass('msgRCHeaderCollapsed');
			$('#msgMaybe').removeClass("msgRCHeaderCollapsed").addClass('msgRCHeaderCollapsed');
			$('#msgNo').removeClass("msgRCHeaderCollapsed").addClass('msgRCHeaderExpanded');
			$('#msgNYR').removeClass("msgRCHeaderCollapsed").addClass('msgRCHeaderCollapsed');
		});

		$('#msgNYR').click(function(event) {
			$('#msgNYRWrapper').toggle();
			if($('#msgNYRWrapper').is(':visible')){
				$('#msgNYRCaret').toggleClass('fa-caret-down fa-caret-up');
			}else{
				$('#msgNYRCaret').toggleClass('fa-caret-up fa-caret-down');
			}

			
			$('#msgYes').removeClass("msgRCHeaderCollapsed").addClass('msgRCHeaderCollapsed');
			$('#msgMaybe').removeClass("msgRCHeaderCollapsed").addClass('msgRCHeaderCollapsed');
			$('#msgNo').removeClass("msgRCHeaderCollapsed").addClass('msgRCHeaderCollapsed');
			$('#msgNYR').removeClass("msgRCHeaderCollapsed").addClass('msgRCHeaderExpanded');
		});


		$('#myAccount').click(function(event) {
			$('#signedINNavBar').toggle();
		});

		$('#myAccountSmall').click(function(event) {
			event.preventDefault();
			$('.smallNav').toggle('slow/400/fast');
		});




		$('#cross').click(function(event) {
				$('#preview').css('display','none');
			});

		$('#view').click(function(event) {
						$('#preview').css('display','block');
					});


					$('.dCard').click(function(event) {
						window.location.href = "edit.php";
					});

				$(window).resize(function(event) {
					//event.preventDefault();
					if ($(window).width()>1019) {
						// hide sidebar if visible
						if ($('.mainNavBarWrapper').is(':visible')) {
							//alert("sidenav is is showing  after 1019");
							closeNav();
						}
					}					
				});

				$('#guestBtn').click(function(event) {
					event.preventDefault();
					$('#guestBox').hide();
					 $('#rsvpBox').show();

					 $('#guestBtn').css({'background-color':'#FC4D2F','color':'white'});
					 $('#rsvpBtn').css({'background-color':'#8fce51','color':'black'});
					// $('#guestBox').css('display','block');
					// $('#rsvpBox').css('display','none');
				});

				$('#rsvpBtn').click(function(event) {
					event.preventDefault();
					$('#guestBox').show();
					 $('#rsvpBox').hide();

					 $('#rsvpBtn').css({'background-color':'#FC4D2F','color':'white'});
					 $('#guestBtn').css({'background-color':'#8fce51','color':'black'});
					// $('#guestBox').css('display','none');
					// $('#rsvpBox').css('display','block');
					/* Act on the event */
				});

					$('#kittiLi').hover(function(){
					$("#caretKitti").css({'display':'block','text-align':'center'});
					},function () {
					    $("#caretKitti").css('display','none');
					});

					$('#submenu1').hover(function () {
					    $("#sm1").css('display','block');
					    $("#linksm1").css('color','#8fce51');
						},function () {
					    $("#sm1").css('display','none');

					    $("#linksm1").css('color','white');
					});

					$('#submenu2').hover(function () {
					    $("#sm2").css('display','block');
					    $("#linksm2").css('color','#8fce51');
						},function () {
					    $("#sm2").css('display','none');
					    $("#linksm2").css('color','white');
					});

					$.fn.isOnScreen = function(){
	    
				    var win = $(window);
				    
				    var viewport = {
				        top : win.scrollTop(),
				        left : win.scrollLeft()
				    };
				    viewport.right = viewport.left + win.width();
				    viewport.bottom = viewport.top + win.height();
				    
				    var bounds = this.offset();
				    bounds.right = bounds.left + this.outerWidth();
				    bounds.bottom = bounds.top + this.outerHeight();
				    
				    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));	
					};

					window.onscroll=function(e){
					if($("#step1").isOnScreen()){
						$('#step1').addClass('animated slideInLeft');
						$('#step2').addClass('animated slideInLeft');
						$('#step3').addClass('animated slideInLeft');
						$('#step4').addClass('animated slideInLeft');
							
					}
					else
					{
						$('#step1').removeClass('animated slideInLeft');
						$('#step2').removeClass('animated slideInLeft');
						$('#step3').removeClass('animated slideInLeft');
						$('#step4').removeClass('animated slideInLeft');
							
					}
					}

					$('.handle').click(function(event) { 
						$("nav ul").toggleClass('showing');
					});

					$('.mobiletestlarge').bjqs({
						animtype:'slide',
						height : 150,
						width : 395,
						responsive : false,
						animduration : 450, // how fast the animation are
						animspeed : 4000, // the delay between each slide
						automatic : true, // automatic

						// control and marker configuration
						showcontrols : false, // show next and prev controls
						centercontrols : true, // center controls verically
						nexttext : '', // Text for 'next' button (can use HTML)
						prevtext : '', // Text for 'previous' button (can use HTML)
						showmarkers : false, // Show individual slide markers
						centermarkers : false, // Center markers horizontally

						// interaction values
						keyboardnav : true, // enable keyboard navigation
						hoverpause : true, // pause the slider on hover

						// presentational options
						usecaptions : true, // show captions for images using the image title tag
						randomstart : true, // start slider at random slide
					});


					// function slider
					$('.iptest').bjqs({
						animtype:'slide',
						height : 355,
						width : 450,
						responsive : false,
						animduration : 450, // how fast the animation are
						animspeed : 8000, // the delay between each slide
						automatic : true, // automatic

						// control and marker configuration
						showcontrols : true, // show next and prev controls
						centercontrols : true, // center controls verically
						nexttext : '<img src="assets/left.png" style="margin-left:100%;margin-top:-100%" class="img img-responsive">', // Text for 'next' button (can use HTML)
						prevtext : '<img src="assets/right.png" style="margin-left:-100%;margin-top:-100%" class="img img-responsive">', // Text for 'previous' button (can use HTML)
						showmarkers : false, // Show individual slide markers
						centermarkers : false, // Center markers horizontally

						// interaction values
						keyboardnav : true, // enable keyboard navigation
						hoverpause : true, // pause the slider on hover

						// presentational options
						usecaptions : true, // show captions for images using the image title tag
						randomstart : true, // start slider at random slide
					});

					$('.mediumtest').bjqs({
						animtype:'slide',
						height : 355,
						width : 800,
						responsive : false,
						animduration : 450, // how fast the animation are
						animspeed : 8000, // the delay between each slide
						automatic : true, // automatic

						// control and marker configuration
						showcontrols : true, // show next and prev controls
						centercontrols : true, // center controls verically
						nexttext : '<img src="assets/left.png" style="margin-left:100%;margin-top:-100%" class="img img-responsive">', // Text for 'next' button (can use HTML)
						prevtext : '<img src="assets/right.png" style="margin-left:-100%;margin-top:-100%" class="img img-responsive">', // Text for 'previous' button (can use HTML)
						showmarkers : false, // Show individual slide markers
						centermarkers : false, // Center markers horizontally

						// interaction values
						keyboardnav : true, // enable keyboard navigation
						hoverpause : true, // pause the slider on hover

						// presentational options
						usecaptions : true, // show captions for images using the image title tag
						randomstart : true, // start slider at random slide
					});

					// function slider
					$('.test').bjqs({
						animtype:'slide',
						height : 355,
						width : 1200,
						responsive : false,
						animduration : 450, // how fast the animation are
						animspeed : 8000, // the delay between each slide
						automatic : true, // automatic

						// control and marker configuration
						showcontrols : true, // show next and prev controls
						centercontrols : true, // center controls verically
						nexttext : '<img src="assets/left.png" style="margin-left:100%;margin-top:-100%" class="img img-responsive">', // Text for 'next' button (can use HTML)
						prevtext : '<img src="assets/right.png" style="margin-left:-100%;margin-top:-100%" class="img img-responsive">', // Text for 'previous' button (can use HTML)
						showmarkers : false, // Show individual slide markers
						centermarkers : false, // Center markers horizontally

						// interaction values
						keyboardnav : true, // enable keyboard navigation
						hoverpause : true, // pause the slider on hover

						// presentational options
						usecaptions : true, // show captions for images using the image title tag
						randomstart : true, // start slider at random slide
					});

					$('.mobiletest').bjqs({
						animtype:'slide',
						height : 355,
						width : 250,
						responsive : false,
						animduration : 450, // how fast the animation are
						animspeed : 8000, // the delay between each slide
						automatic : true, // automatic

						// control and marker configuration
						showcontrols : true, // show next and prev controls
						centercontrols : true, // center controls verically
						nexttext : '<img src="assets/left.png" style="margin-left:100%;margin-top:-100%" class="img img-responsive">', // Text for 'next' button (can use HTML)
						prevtext : '<img src="assets/right.png" style="margin-left:-100%;margin-top:-100%" class="img img-responsive">', // Text for 'previous' button (can use HTML)
						showmarkers : false, // Show individual slide markers
						centermarkers : false, // Center markers horizontally

						// interaction values
						keyboardnav : true, // enable keyboard navigation
						hoverpause : true, // pause the slider on hover

						// presentational options
						usecaptions : true, // show captions for images using the image title tag
						randomstart : true, // start slider at random slide
					});
		});
