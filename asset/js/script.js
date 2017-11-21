

// When the user clicks on <span> (x), close the modal
document.getElementsByClassName("close").onclick = function() {
    modal.style.display = "none";
}

function showModal(number){
	document.getElementById('myModal' + number).style.display = "block";
}
function closeModal(number){
	document.getElementById('myModal' + number).style.display = "none";
}

function Countdown(sec, id) {
  var timer,
  instance = this,
  seconds = sec || 10,
  updateStatus = function (sec) {
	var minutes = Math.floor(sec / 60);
	var seconds = sec - minutes * 60;
	var finalTime = str_pad_left(minutes,'0',2)+':'+str_pad_left(seconds,'0',2);
	document.getElementById(id).innerHTML = finalTime;
  },
  counterEnd = function () {
	window.location.reload(false);
  };

  function decrementCounter() {
    updateStatus(seconds);
    if (seconds === 0) {
      counterEnd();
      instance.stop();
    }
    seconds--;
  }

  this.start = function () {
    clearInterval(timer);
    timer = 0;
    seconds = sec;
    timer = setInterval(decrementCounter, 1000);
  };

  this.stop = function () {
    clearInterval(timer);
  };
}

function str_pad_left(string,pad,length) {
    return (new Array(length+1).join(pad)+string).slice(-length);
}

$(document).ready(function() {
	$('[data-toggle="popover"]').popover();
	$('.no-jump').click(function(event) {
		event.preventDefault();
		return false;
	});
	$('input').tooltip({ /*or use any other selector, class, ID*/
		placement: "bottom",
		trigger: "focus"
	});

	$(".btn-like").hover(function(){
		$(this).find("span").html('<i class="fa fa-thumbs-up" aria-hidden="true"></i>');
	}, function(){
		$(this).find("span").html('<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>');
	});
	$(".btn-unlike").hover(function(){
		$(this).find("span").html('<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>');
	}, function(){
		$(this).find("span").html('<i class="fa fa-thumbs-up" aria-hidden="true"></i>');
	});


	$(function() {
		$('.img-zoom').on('click', function() {
		$('.enlargeImageModalSource').attr('src', $(this).attr('src'));
		$('#enlargeImageModal').modal('show');
		});
	});
});
