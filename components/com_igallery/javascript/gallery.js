var igalleryClass = new Class
({
	options: 
	{
    },

    initialize: function(options)
    {
        this.setOptions(options);
        
        //the imageindex represents what pic is currently shown, the first pic is 0
        this.imageIndex = 0;
        
        //we wont insert an image for the lightbox until the big image gets clicked on
        if(this.options.main == 1)
        {
        	//check to see if the url has a &image=5 in it (manually bookmarking images can be done with this)
        	this.urlImageId = this.getUrlParamater('image');
        	
        	//if it does have a &image=5 in it
        	if(this.urlImageId != 'unset')
        	{
        		//set the imageindex so we display the image that was in the url 
        		this.imageIndex = this.urlImageId - 1;
        	}
        	
	        //insert the first image
	        this.swapImage(this.options.imageTypeFolder, this.options.jsonImagesImageType[this.imageIndex], false, this.imageIndex);
        }
        
        //make the mootools scroller for the thumbnails
		this.thumbScroller = new Scroller(this.options.thumbContainer, {area: this.options.scrollBoundary, velocity: this.options.scrollSpeed});
		$(this.options.thumbContainer).addEvent('mouseenter', this.thumbScroller.start.bind(this.thumbScroller));
		$(this.options.thumbContainer).addEvent('mouseleave', this.thumbScroller.stop.bind(this.thumbScroller));
		
		//add the thumbclick behaviors
		this.addThumbBehaviors();
		
		//add the behaviors to the up/down left/right arrows
		if(this.options.showUpDown == 1)
		{
			this.addArrowBehaviors(this.options.upArrow, -200,'vertical');
			this.addArrowBehaviors(this.options.downArrow, 200,'vertical');
		}
		if(this.options.showLeftRight == 1)
		{
			this.addArrowBehaviors(this.options.rightArrow, 200,'horizontal');
			this.addArrowBehaviors(this.options.leftArrow, -200,'horizontal');
		}
		
		//if this is the main gallery and preload is on, call up the preload function every .75 seconds
		//the function will clear itself when it has finished preloading
		//we won't preload the lightbox images until the lightbox has opened
		if(this.options.preload == 1 && this.options.main == 1)
		{
			this.preloadCounter = 0;
			this.preloaderVar = this.preloadImages.periodical(750, this ,this.options.imageTypeFolder);
		}
        
        //if the slideshow is enabled and this is the main gallery
        if(this.options.enableSlideshow == 1 && this.options.main == 1)
        {
        	//add the thumbclick event to the play button
        	this.clearSlideShow();
        	
        	if(this.options.showSlideshowControls == 1)
			{
        	
	        	//add the slideshow forward button behavior
	        	$(this.options.slideshowForward).addEvent('click', function(e)
				{
					this.clearSlideShow();
					this.slideShowSwap(true);
				}.bind(this));
				
				//add the slideshow back button behavior
				$(this.options.slideshowRewind).addEvent('click', function(e)
				{
					this.clearSlideShow();
					this.slideShowSwap(false);
				}.bind(this));
			}
        	
        	//start the slideshow now if autostart is on
        	if(this.options.slideshowAutostart == 1)
        	{
        		//the false means dont swap right away, but wait for the pause amount, then swap
        		this.slideShowStart(false);
        	}
        }
        
    },
    
    addThumbBehaviors: function(options)
    {   
    	//get all the thumb links into an array
        this.linksArray = $(this.options.thumbTable).getElements('a');
		
        //loop through the array
		this.linksArray.each(function(el,index)
		{	
			//add a click event to each thumb link
			el.addEvent('click', function(e)
			{	
				//stop the link going to its href
				e = new Event(e).stop();
				
				//if the large image is hidden, make a thumbclick go to the lightbox/link
				if(this.options.showLargeImage == 0 && this.options.main == 1)
				{
					//get the correct thumb link, check its class to see if it is a lightbox
					//link or a external link, and its target to see if the external link is new window
					this.thumbLinksArray = $(this.options.thumbContainer).getElements('a');
					this.thumbLinkClass = el.getProperty('class');
					this.thumbLinkTarget = el.getProperty('target');
					
					if(this.thumbLinkClass == 'picture_link')
					{	
						el.setStyle('cursor', 'pointer');
						
						if (this.thumbLinkTarget == '_blank') 
						{
							window.open(this.thumbLinksArray[index]);
						}
						else
						{
							window.location = this.thumbLinksArray[index];
						}
							
					}
					else
					{
						this.showLightBox(index);
					}
				}
				//otherwise make the thumbnail click swap an image and add a click behavior to the new big image
				else
				{
					//swap the image
					this.swapImage(this.options.imageTypeFolder, this.options.jsonImagesImageType[index], this.options.fade, index);
				}
			
			}.bind(this));
		}.bind(this));
	},
    
    swapImage : function(imageType, imageObject, fade, index)
	{
		this.removeImage(fade);
		
		this.insertImage(imageType, imageObject, fade, index);
		
		//update the imageindex to the image we just injected
		this.imageIndex = index;
		
		//set the click behavior for the main image
		if(this.options.main == 1 && this.options.showLargeImage == 1)
		{
			this.addMainImageClick(index);
		}
		
		//show the correct rating
		if(this.options.allowRating == 1)
		{
			this.swapRating();
		}
		
		//show the correct comments
		if(this.options.allowComments == 1)
		{
			this.swapComments();
		}
		
		//show the correct description
		if(this.options.showDescriptions == 1)
		{
			this.swapDescription(index);
		}
		
	},
	
	removeImage : function(fade)
	{
		//get the image at the top of the large img div
		this.imageToRemove = $(this.options.largeImage).getElement('img[class=large_img]');
		
		//on the first load there wont be any image to remove
		if(this.imageToRemove != null)
		{
			//if fade is true then fade it out then remove
			if(fade == 1)
			{
				this.imageFadeAway = new Fx.Style(this.imageToRemove, 'opacity');
				this.imageFadeAway.start(1,0).chain(function()
				{
					this.imageToRemove.remove();
				}.bind(this));
			}
			
			//otherwise just remove it
			else
			{
				this.imageToRemove.remove();
			}
		}
		
		//if we are in the main gallery and there is a magnify gif, remove it
		if(this.options.main == 1 && this.options.lightboxOn == 1)
		{
			if (this.options.magnify == 1 && $('magnifygif') != null) 
			{
				$('magnifygif').remove();
			}
		}
	},
	
	insertImage : function(imageType, imageObject, fade, index)
	{
		this.ImageAsset = new Asset.images([this.options.host + 'images/stories/igallery/' + this.options.folder + '/' + imageType + '/' + imageObject.filename ], 
		{
			onComplete: function()
			{
				//get the size of the large image div and work out the margins so the image is centered
				this.largeImgDivSizeArray = $(this.options.largeImage).getSize();
				this.imageToInjectLeftMargin = Math.round( (this.largeImgDivSizeArray.size.x - imageObject.width) /2 );
				this.imageToInjectTopMargin  = Math.round( (this.largeImgDivSizeArray.size.y - imageObject.height) /2 );
				
				//set the images position
				this.ImageAsset.setStyles
				({
					position: 'absolute',
					left: this.imageToInjectLeftMargin,
					top: this.imageToInjectTopMargin,
					width: imageObject.width,
					height: imageObject.height
				});
				
				//if fade is on then fade it in
				if(fade == true)
				{
					this.ImageAsset.setStyle('opacity',0);
					this.ImageAsset.injectTop( $(this.options.largeImage) );
					this.ImageAssetInjected = $(this.options.largeImage).getElement('img');
					this.imageFadeIn = new Fx.Style(this.ImageAssetInjected, 'opacity').start(0,1);
				}
				
				//otherwise inject it without fading
				else
				{
					this.ImageAsset.injectTop( $(this.options.largeImage) );
				}
				
				this.ImageAsset.setProperty('class', 'large_img');
				
				//if we are in the main gallery, and the lightbox and magnify gif are set to on
				if(this.options.main == true && this.options.magnify == 1 && this.options.lightboxOn == 1)
				{
					//insert the magnify gif
					this.insertMagnify(index, this.imageToInjectLeftMargin, this.imageToInjectTopMargin);
				}
				
			}.bind(this)
		});
	},
	
	addMainImageClick : function(index)
	{
			//get the correct thumb link, check its class to see if it is a lightbox
			//link or a external link, and its target to see if the external link is new window
			this.linksArray = $(this.options.thumbContainer).getElements('a');
			this.linkClass = this.linksArray[index].getProperty('class');
			this.linkTarget = this.linksArray[index].getProperty('target');
			
			//if the class is picture link then add a link behavior
			if(this.linkClass == 'picture_link')
			{	
				$(this.options.largeImage).setStyle('cursor', 'pointer');
				$(this.options.largeImage).removeEvents('click');
				
				$(this.options.largeImage).addEvent('click', function(e)
				{
					if (this.linkTarget == '_blank') 
					{
						window.open(this.linksArray[index]);
					}
					else
					{
						window.location = this.linksArray[index];
					}
					
				}.bind(this));
			}

			//if there is no link, and the lightbox is on, add the lightbox behavior
			if(this.options.lightboxOn == 1 && this.linkClass == 'no_link' )
			{
				$(this.options.largeImage).removeEvents('click');
				
				$(this.options.largeImage).setStyle('cursor', 'pointer');
				
				$(this.options.largeImage).addEvent('click', function(e)
				{	
					this.showLightBox(index);
				}.bind(this));
			}
	},
	
	addArrowBehaviors: function(arrow, pixels, mode)
	{
   		this.arrowScroller = new Fx.Scroll(this.options.thumbContainer);
		
		$(arrow).addEvent('click', function(e)
		{
			this.containerSizeArray = $(this.options.thumbContainer).getSize();
			this.currentScrollX = this.containerSizeArray.scroll.x;
			this.currentScrollY = this.containerSizeArray.scroll.y;
			
			if (mode == 'horizontal') 
			{
				this.arrowScroller.scrollTo(this.currentScrollX + pixels, this.currentScrollY);
			}
			
			if (mode == 'vertical') 
			{
				this.arrowScroller.scrollTo(this.currentScrollX, this.currentScrollY + pixels);
			}
			
	    }.bind(this));
    },
    
    lboxPreloadStarter : function()
	{
		this.preloadCounter = 0;
		this.preloaderVar = this.preloadImages.periodical(750, this ,this.options.imageTypeFolder);
	},
    
    preloadImages : function(imageType)
	{	
		//preload the image
    	new Asset.images([this.options.host + 'images/stories/igallery/' + this.options.folder + '/' + imageType + '/' + this.options.jsonImagesImageType[this.preloadCounter].filename ],
		{
		    onComplete: function()
		 	{
				
		    }
		});
		
		this.preloadCounter++;
		
		//if we are on the last pic, then clear the periodical var that calls this function every .75 secs
		if(this.preloadCounter == this.options.numPics)
		{
			$clear(this.preloaderVar);
		}
	},
	
	swapDescription : function(index)
	{
		//hide all the descriptions
		this.descriptionDivs = $(this.options.desContainer).getElements('div[class=des_div]');
		this.descriptionDivs.each(function(el,index)
		{
			el.setStyle('display', 'none');
		});
		
		//scroll to the top and show the current description
		$(this.options.desContainer).scrollTo(0,0);
		this.descriptionDivs[index].setStyle('display', 'block');
	},
	
	slideShowStart : function(instant)
	{
		if(instant == true)
		{
			//swap the image right away
			this.slideShowSwap(true);
		}
		
		//make the slideshow function run periodically
  		this.slideShowObject = this.slideShowSwap.periodical(this.options.slideshowPause, this, true);
		
  		//make the play button a pause button that will clear the slideshow
  		if(this.options.showSlideshowControls == 1)
		{
			$(this.options.slideshowPlay).setProperty('src', this.options.host + '/components/com_igallery/images/pause.jpg');
			$(this.options.slideshowPlay).removeEvents();
			$(this.options.slideshowPlay).addEvent('click', function(e)
			{
				this.clearSlideShow();
			}.bind(this));
		}
	},
    
    slideShowSwap : function(forward)
	{
		//if we are moving forward
		if(forward == true)
		{
			//if we are on the last pic, make the imageindex the first pic
			if(this.imageIndex == this.options.numPics - 1)
			{
				this.imageIndex = 0;
			}
			//otherwise increase the index by one  
			else
			{
				this.imageIndex++
			}
		}
		
		//if the back button is pressed
    	else
    	{
    		//if we are on the first pic, we want the index to be the last pic in the array
    		if(this.imageIndex == 0)
			{
				this.imageIndex = this.options.numPics - 1;
			}
			//otherwise decrease the index by one
			else
			{
				this.imageIndex--
			}
    	}
		
		//swap the image
		this.swapImage(this.options.imageTypeFolder, this.options.jsonImagesImageType[this.imageIndex], this.options.fade, this.imageIndex );
	},
	
	clearSlideShow : function()
	{
		$clear(this.slideShowObject);
		
		if(this.options.showSlideshowControls == 1)
		{
			$(this.options.slideshowPlay).setProperty('src', this.options.host + '/components/com_igallery/images/play.jpg');
			$(this.options.slideshowPlay).removeEvents();
			$(this.options.slideshowPlay).addEvent('click', function(e)
			{
				this.slideShowStart(true);
			}.bind(this));
		}
	},
	
	swapRating: function()
	{	
		this.caculateDisplayRating();
		
		this.showRatingMessage();
		
    	//if they are logged in, add the mouse over stars behavior
		if(this.options.guest == 0)
		{
			this.ratingStars.each(function(el,index)
			{
				el.removeEvents();
				
				//if they have not rated this image before...
				if(this.options.ratedArray[this.imageIndex] == 0)
				{
					this.addStarsMouseover(el,index);
					this.addStarsClick(el,index);
				}
			}.bind(this));
		}
	},
	
	caculateDisplayRating: function()
	{
		this.ratingCounter = 0;
		this.ratingSum = 0;
		
		//if there are some ratings for this pic..
		if( typeof(this.options.ratingsArray[this.imageIndex]) != 'undefined' )
		{
			//loop through the subarray and caculate the number of ratings and ratings sum
			for(this.i=0; this.i<this.options.ratingsArray[this.imageIndex].length; this.i++)
			{	
				this.ratingSum = this.ratingSum + this.options.ratingsArray[this.imageIndex][this.i];
				this.ratingCounter++;
			}
			
			//work out the rating and round to nearest point 5
			this.imgRatingtoRound = this.ratingSum/this.ratingCounter;
			this.imgRating = Math.round( (this.imgRatingtoRound * 2) ) /2;
		}
		//otherwise if there are no ratings set the rating to zero
		else
		{
			this.imgRating = 0;
		}	
		
		//display the number of ratings
		$(this.options.numRatings).setHTML(this.ratingCounter);
		
		//get all the rating stars
		this.ratingStars = $(this.options.ratingsForm).getElements('img');
		
		//make all the stars white
		for(this.k = 0; this.k<5; this.k++)
		{
			this.ratingStars[this.k].setProperty('src', this.options.host + 'components/com_igallery/images/star-white.gif');
		}
		
		//round the rating down and make those stars blue
		for(this.m = 0; this.m<Math.floor(this.imgRating); this.m++)
		{
			this.ratingStars[this.m].setProperty('src', this.options.host + 'components/com_igallery/images/star-blue.gif');
		}
		
		//if the rating is x.5 rather than x.0, add in a half star
		if(this.imgRating - Math.floor(this.imgRating) > 0)
		{
			this.ratingStars[Math.floor(this.imgRating)].setProperty('src', this.options.host + 'components/com_igallery/images/star-half.gif');
		}
	},
	
	showRatingMessage: function()
	{
		//hide all the rating messages
    	this.ratingMessages = $(this.options.ratingsMessageContainer).getElements('span');
    	this.ratingMessages.each(function(el,index){el.setStyle('display','none')});
    	
    	//if the user is a guest, display the login to rate message
    	if(this.options.guest == 1)
		{
    		this.ratingMessages[0].setStyle('display','inline');
		}
		
		//if the user is logged in and has not rated this image, display a rate photo message
		if(this.options.guest == 0 && this.options.ratedArray[this.imageIndex] == 0)
		{
    		this.ratingMessages[1].setStyle('display','inline');
		}
		
		//if the user is logged in and has rated this image, display a you have rated message
		if(this.options.guest == 0 && this.options.ratedArray[this.imageIndex] == 1)
		{
    		this.ratingMessages[2].setStyle('display','inline');
		}
	},
	
	addStarsMouseover: function(el,index)
	{
		el.addEvent('mouseenter', function()
	    {
	    	for(this.i = 0; this.i<5; this.i++)
			{
				//if, for example, it is the third star, then make starts 1-3 blue, and stars 4-5 white (on mouseover of the third star)
				if(this.i <= index)
				{
					this.ratingStars[this.i].setProperty('src', this.options.host + 'components/com_igallery/images/star-blue.gif');
				}
				else
				{
					this.ratingStars[this.i].setProperty('src', this.options.host + 'components/com_igallery/images/star-white.gif');
				}
			}
	    }.bind(this));
	    
	    el.addEvent('mouseleave', function()
	    {
	    	//when the mouse leaves, redisplay the original rating
	    	for(this.i = 0; this.i<5; this.i++)
			{
				if(this.i < Math.floor(this.imgRating))
				{
					this.ratingStars[this.i].setProperty('src', this.options.host + 'components/com_igallery/images/star-blue.gif');
				}
				else
				{
					this.ratingStars[this.i].setProperty('src', this.options.host + 'components/com_igallery/images/star-white.gif');
				}
				
				if(this.imgRating - Math.floor(this.imgRating) > 0)
				{
					this.ratingStars[Math.floor(this.imgRating)].setProperty('src', this.options.host + 'components/com_igallery/images/star-half.gif');
				}
			}
	    }.bind(this));
	},
	
	addStarsClick: function(el,index)
	{
	    //add the submit click event to each star
	    el.addEvent('click', function()
	    {	
	    	//hide all the rating messages
	    	this.ratingMessages.each(function(el,index){el.setStyle('display','none')});
	    	
	    	//show the loader gif
	    	this.ratingMessages[3].setStyle('display','inline');
	    	
	    	//set the imageid and the rating in the form
	    	$(this.options.ratingsImgId).setProperty('value', this.options.idArray[this.imageIndex]);
	    	$(this.options.ratingsImgRating).setProperty('value', index + 1);
	    	
	    	//send the form
	    	$(this.options.ratingsForm).send
			({
				onComplete: function(response) 
				{
					//hide all the rating messages
					this.ratingMessages.each(function(el,index){el.setStyle('display','none')});
	    			
					//if they have been logged out display the log in message
					if(response == 0)
	    			{
						this.ratingMessages[5].setStyle('display','inline');
	    			}
	    			
	    			//if they have already voted say so
	    			if(response == 1)
	    			{
						this.ratingMessages[2].setStyle('display','inline');
	    			}
	    			
	    			//if the respone was success 
	    			if(response == 2)
	    			{
						//update the ratings array, the rating counter is one more
						//than the amount in the sub array(which starts at 0), the index is
						//the rating star that was clicked on (which go from 0-4)
						if((typeof(this.options.ratingsArray[this.imageIndex]) == 'undefined') )
						{
							this.options.ratingsArray[this.imageIndex] = new Array();
						}
						this.options.ratingsArray[this.imageIndex][this.ratingCounter] = index + 1;
						
						//update the rated array
						this.options.ratedArray[this.imageIndex] = 1;
						
						//recaculate and display the new rating total
						this.caculateDisplayRating();
						
						//hide all the rating messages
						this.ratingMessages.each(function(el,index){el.setStyle('display','none')});
						
						//say the rating has been added
						this.ratingMessages[4].setStyle('display','inline');
	    			}
				}.bind(this)
			});
	    }.bind(this));
	},
	
	swapComments: function()
	{
		this.showCorrectComments();
		
		//if the user is logged in then add the comment form behavior
		if(this.options.guest == 0)
		{	
			this.addCommentSubmit();
		}
    },
    
    showCorrectComments: function()
	{
		this.commentsContainerChildDivs = $(this.options.commentsContainer).getElements('div');
    	
    	this.commentsCounter = 0;
    	
    	this.commentsContainerChildDivs.each(function(el,index)
		{
			this.commentDivId = el.getProperty('class');
			this.commentDivIdArray = this.commentDivId.split("_");
			this.commentDivId = this.commentDivIdArray.pop();
			
			if(this.commentDivId == this.options.idArray[this.imageIndex])
			{
				el.setStyle('display','block');
				this.commentsCounter++
			}
			else
			{
				el.setStyle('display', 'none');
			}
		}.bind(this));
			
		//display the comments amount
		$(this.options.commentsAmount).setHTML(this.commentsCounter);
		
    	//if we are in the lightbox, and the comments we just inserted made the overall window 
    	//taller, adjust the background darkdiv so it extends all the way down
		if(this.options.main == 0)
		{	
			this.totalScrollHeight = Window.getScrollHeight();
			$(this.options.lboxDark).setStyle('height',this.totalScrollHeight);
		}
	},
	
	addCommentSubmit: function()
	{
		//remove any previous events
		$(this.options.commentsForm).removeEvents();
		
		//set the correct img id in the form
		$(this.options.commentsImgId).setProperty('value', this.options.idArray[this.imageIndex]);
		
		//hide any previous display message
		this.commentsMessages = $(this.options.commentsMessageContainer).getElements('span');
		this.commentsMessages.each(function(el,index){el.setStyle('display','none')});
		
		//when the form is submtted...
		$(this.options.commentsForm).addEvent('submit', function(e) 
		{
			//dont send the form, we will do it through ajax
			new Event(e).stop();
			
			this.commentToSend = $(this.options.commentsTextarea).getValue();
			
			//if the comments field is empty, display an error message
			if(this.commentToSend.length < 1)
			{
				this.commentsMessages[0].setStyle('display','inline');
				return;
			}
			
			//show the loading gif
			$(this.options.commentsLoadingGif).setHTML('<img src="' + this.options.host + 'components/com_igallery/images/loader.gif');
			
			//send the form using mootools ajax send function
			$(this.options.commentsForm).send
			({
				onComplete: function(response) 
				{
					//if they have been logged out display a message to login again
					if(response == 0)
					{
						this.commentsMessages[1].setStyle('display','inline');
						return;
					}
					
					//make a new div to inject into the comments data container
					this.newCommentDiv = new Element('div',
					{
						'class': 'comments_div_' + this.options.idArray[this.imageIndex]
					});
					
					//add the html into it
					this.newCommentDiv.setHTML(response);
					
					//inject it
					this.newCommentDiv.injectInside(this.options.commentsContainer);
					
					//inject it into the other galleries commments container
					if(this.options.main == 1 && this.options.lightboxOn == 1 && this.lboxGalleryObject.options.allowComments == 1)
					{
						this.newCommentDiv.clone().injectInside(this.lboxGalleryObject.options.commentsContainer);
					}
					if(this.options.main != 1 && this.mainGalleryObject.options.allowComments == 1)
					{
						this.newCommentDiv.clone().injectInside(this.mainGalleryObject.options.commentsContainer);
					}
					
					//remove the loading gif
					$(this.options.commentsLoadingGif).setHTML('');
							
					//display a comment succesfully added message
					this.commentsMessages[2].setStyle('display','inline');
					
					//empty the textarea
					$(this.options.commentsTextarea).value = '';
					
					$(this.options.commentsAmount).setHTML(this.commentsCounter + 1);
					
					//redo the show comments function, so the new comment will be pulled out of the comments
					//container, and displayed
					this.showCorrectComments();
					
				}.bind(this)
			});
		}.bind(this));
	},
	
	showLightBox : function(index)
	{
		//preload the large lightbox images
		if(this.lboxGalleryObject.options.preload == 1)
		{
			this.lboxGalleryObject.lboxPreloadStarter();
		}
		
		//inject the white div
		this.bodyTag = document.getElementsByTagName("body").item(0);
		this.scrolledDown = Window.getScrollTop();
		this.totalScrollHeight = Window.getScrollHeight();
		this.totalWidth = Window.getWidth();
		
		this.lboxPaddingLeft = $(this.options.lboxWhite).getStyle('padding-left').toInt();
		this.lboxPaddingRight = $(this.options.lboxWhite).getStyle('padding-right').toInt();
		this.lboxPadding = (this.lboxPaddingLeft + this.lboxPaddingRight) / 2;
		
		this.whiteDivLeftMargin = (this.totalWidth/2) - ( (this.options.lightboxWidth)/2) + this.lboxPadding;
		$(this.options.lboxWhite).injectTop(this.bodyTag);
		$(this.options.lboxWhite).setStyles
		({
			'top': this.scrolledDown + 30,
	        'left': this.whiteDivLeftMargin,
	        'opacity': '0',
			'display': 'block'
		});
		
		//inject the dark div
		this.totalScrollHeight = Window.getScrollHeight();
		
		$(this.options.lboxDark).injectTop(this.bodyTag);
		$(this.options.lboxDark).setStyles
		({
			'width': '100%',
	        'height': this.totalScrollHeight,
	        'top': '0px',
	        'left': '0px',
	        'opacity': '0',
			'display': 'block'
		});
		
		//fade the divs in
		this.darkDivFade = new Fx.Style( $(this.options.lboxDark) , 'opacity');
		this.darkDivFade.start(0,.7);
		
		this.whiteDivFadeIn = new Fx.Style( $(this.options.lboxWhite) , 'opacity');
		this.whiteDivFadeIn.start(0,1);
		
		
		//inject in the first image
		this.lboxGalleryObject.swapImage('lightbox', this.options.jsonImages.lbox[index], 0, index);
		
		//if the lightbox slide show is enabled...
		if(this.lboxGalleryObject.options.enableSlideshow == 1)
    	{
    		//add the thumbclick event to the play button
        	this.lboxGalleryObject.clearSlideShow();
        	
        	if(this.lboxGalleryObject.options.showSlideshowControls == 1)
			{
        	
	        	//add the slideshow forward button behavior
	        	$(this.lboxGalleryObject.options.slideshowForward).addEvent('click', function(e)
				{
					this.lboxGalleryObject.clearSlideShow();
					this.lboxGalleryObject.slideShowSwap(true);
				}.bind(this));
				
				//add the slideshow back button behavior
				$(this.lboxGalleryObject.options.slideshowRewind).addEvent('click', function(e)
				{
					this.lboxGalleryObject.clearSlideShow();
					this.lboxGalleryObject.slideShowSwap(false);
				}.bind(this));
			
			}
        	
        	//start the slideshow now if autostart is on
        	if(this.lboxGalleryObject.options.slideshowAutostart == 1)
        	{
        		//the false means dont swap right away, but wait for the pause amount, then swap
        		this.lboxGalleryObject.slideShowStart(false);
        	}
    	}
		
		//add the close image behavior
		$(this.options.closeImage).addEvent('click', function(e)
		{
			//if the lightbox slideshow is running this will clear it
			this.lboxGalleryObject.clearSlideShow();
			
			//remove the dark div
			this.darkDivFade.start(0.7,0).chain(function()
			{
				$(this.options.lboxDark).setStyle('display','none');
			}.bind(this));
			
			//remove the white div
			this.whiteDivFadeIn.start(1,0).chain(function()
			{
				//empty the lightbox image container
				$(this.lboxGalleryObject.options.largeImage).setHTML('');
				
				$(this.options.lboxWhite).setStyle('display','none');
			}.bind(this));
			
			//if they have rated in the lightbox, and the ratings are displayed in the main gallery,
			//then the main gallery rating may need to be recaculated
			if(this.options.allowRating == 1)
			{
				this.caculateDisplayRating();
			}
			
		}.bind(this));
	},

	insertMagnify : function(index, mainImageLeftMargin, mainImageTopMargin)
    {
  		this.currentLargeImage = $(this.options.largeImage).getElement('img[class=large_img]');
    	
  		this.largeImageLeftPadding = this.currentLargeImage.getStyle('padding-left').toInt();
    	this.largeImageTopPadding = this.currentLargeImage.getStyle('padding-top').toInt();
    	this.largeImageLeftMargin = this.currentLargeImage.getStyle('margin-left').toInt();
    	this.largeImageTopMargin = this.currentLargeImage.getStyle('margin-top').toInt();
    	
 
    	//we want the magnify image to sit at the bottom right corner of the image. If it is positioned
    	//absolutely in the main image div, it's left margin needs to be the width of the main image
    	//plus the left margin of the main image, minus its own width, same principal for top margin
		this.magnifyMarginLeft = mainImageLeftMargin + this.options.jsonImages.main[index].width - 27 + this.largeImageLeftPadding + this.largeImageLeftMargin;
		this.magnifyMarginTop = mainImageTopMargin + this.options.jsonImages.main[index].height - 20 + this.largeImageTopPadding + this.largeImageTopMargin;
		
		//load the magnify image
		this.magnifyImage = new Asset.images([this.options.host + 'components/com_igallery/images/magnify.gif' ], 
		{
			onComplete: function()
			{
				//inject it into the large image div, in the correct position, make a higher z index so we are
				//sure it will be on top of the image, and make it a bit transparent, so it looks a bit nicer
				//on top of the image
				this.magnifyImage[0].injectInside(this.options.largeImage).setStyles
				({
					position: 'absolute',
					left: this.magnifyMarginLeft,
					top: this.magnifyMarginTop,
					'z-index': 10,
					opacity: 0.7
				});
				
				//set an id so we can remove it on the next image swap
				this.magnifyImage[0].setProperty('id', 'magnifygif');
				
			}.bind(this)
		});
	},
	
	getUrlParamater : function (strParamName)
	{
		this.strReturn = 'unset';
		
		//get the full url
		this.strHref = window.location.href;
		
		//if there is a question mark in the string
		if(this.strHref.indexOf("?") > -1)
		{
			//get the string after the ?
			this.strQueryString = this.strHref.substr(this.strHref.indexOf("?")).toLowerCase();
			
			//split it into an array
			this.aQueryString = this.strQueryString.split("&");
			
			//loop through the array
			for( this.i = 0; this.i < this.aQueryString.length; this.i++ )
			{
				//search the query string for the paramater that was passed to this function
				//with an equals on the end, if it is found
				if( this.aQueryString[this.i].indexOf(strParamName.toLowerCase() + "=") > -1 )
				{
					//split the string
					this.aParam = this.aQueryString[this.i].split("=");
					
					//and return the bit after the equals
					this.strReturn = this.aParam[1];
					break;
				}
			}
		}
		//return the string, with any special bits like %20 put back into characters
		return unescape(this.strReturn);
	} 

});

igalleryClass.implement(new Options);
