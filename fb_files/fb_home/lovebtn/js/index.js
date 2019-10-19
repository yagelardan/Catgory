
//$('.btn-counter_likecount').on('click', function(event, count) {
$('html').on('click','.btn-counter_likecount',function(event, count) {
  event.preventDefault();
  //alert("hello");
  var $this = $(this),
      count = $this.attr('data-count'),
      active = $this.hasClass('active'),
      multiple = $this.hasClass('multiple-count_likecount');
  
  $.fn.noop = $.noop;
  $this.attr('data-count', ! active || multiple ? ++count : --count  )[multiple ? 'noop' : 'toggleClass']('active');






});





//$('img').on('click',function(event) {
$('html').on('click','.youtubecontainer',function(event) {
	
  event.preventDefault();
  //alert("hello");
        video = '<iframe src="'+ $(this).attr('data-video') +'" width="100%" height="300px"  webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
        $(this).replaceWith(video);

		
    });