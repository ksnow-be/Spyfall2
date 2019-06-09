var ft_list;
var room_num;
var b_start;
var b_log_ab;
var my_or_not = false;
$(document).ready(function () {
	ft_list = $('#ft_list');
	room_num = $('#Room');
	b_start = $('#start');
	b_log_ab = $('#l_a');
});

function upload() {
	var lol = decodeURIComponent(location.search.substr(1)).split('&');
	ft_list.empty();
	aj("GET", 'select.php', function (data) {
		if (data == "false") {
			document.location.replace("main.html");
		}
		else if (data == "true") {
			document.location.replace('game.html?' + lol[0]);
		}
		else {
			data = jQuery.parseJSON(data);
			jQuery.each(data, function (i, val) {
				ft_list.prepend($('<div class="player_tab" data-id="' + i + '">' + val + '</div>'));
			});
		}
			
	});
}

function worker() {
	$.ajax({
	  url: 'check.php', 
	  success: function(html) {
		if (html == 'true')
			upload();
	  },
	  complete: function() {
		setTimeout(worker, 500);
	  }
	});
}

function room() {
	room_num.empty();
	aj("GET", 'functions/give_game_id.php', function (data) {
		if (data != 'false')
			room_num.prepend($('<h3 id="number_alert">' + data + '</h3>'));
	});
}

function vote() {
	aj("GET", 'functions/give_vote.php', function () {return;});
}

function my_game() {
	aj("GET", "functions/mda.php", function (data) {
		if (data == "true")
			my_or_not = true;
		if (my_or_not == true) {
			b_start.prepend($('<form action="start.php"><button value="Start" type="submit" class="buttons" id="Begin_but">Begin</button></form>'));
			b_log_ab.prepend($('<button value="Logout" type="submit" class="buttons" id="Abort_but">Abort</button>'));
		}
		else
			b_log_ab.prepend($('<button value="Logout" type="submit" class="buttons" id="Abort_but">Disconnect</button>'));
	})
}

function aj(method, url, status) {
	$.ajax({
		method: method,
		url: url,
	}).done(function (data) {
		status(data);
	});
}

