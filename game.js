var mapp;
var data_g;
var timer;
var name_loc;
var role;
var game_id;
var src_img;
var r_role;
var r_loc;
var r_new;
var r_discon;
var vote;
var tr = false;
var my_or_not = false;
var rt = false;

$(document).ready(function () {
	mapp = $('#mapp');
	timer = $('#timer');
	name_loc = $('#name_loc');
	role = $('#role');
	vote = $('#vote');
	r_new = $('#start_new');
	r_discon = $('#Discon');
});

//Парсинг данных

function map() {
	var lol = decodeURIComponent(location.search.substr(1)).split('&');
	var kent = lol[0].split('=');
	game_id = kent[1];
	aj("GET", "take_map_info.php?game_id=" + game_id, function (data) {
		if (data != 'not_found') {
			data = jQuery.parseJSON(data);
			src_img = data['img'];
			r_role = data['role'];
			r_loc = data['loc'];
		}
	});
}

function parse1() {
	var lol = decodeURIComponent(location.search.substr(1)).split('&');
	var kent = lol[0].split('=');
	game_id = kent[1];
	aj("GET", "take_map_info.php?game_id=" + game_id, function (data) {
		if (data != 'not_found') {
			data = jQuery.parseJSON(data);
			src_img = data['img'];
			r_role = data['role'];
			r_loc = data['loc'];
		}
	});
}

//Вывод картинки и локации

function map1(data) {
	role.empty();
	role.prepend($('<h3>' + data + '</h3>'));
}

function map2(data) {
	name_loc.empty();
	name_loc.prepend($('<h3>' + data + '</h3>'));
}

function map3(data) {
	mapp.empty();
	mapp.prepend($('<img src="'+ data + '">'));
}

function update(tum) {
	var min = 0;
	var sec = 0;
	if (tum > 59)
		min = parseInt((tum / 60), 10);
	sec = parseInt((tum % 60), 10);
	if (sec < 10)
		sec = "0" + sec;
	if (min < 10)
		min = "0" + min;
	if (tum < 0) {
		min = "00"
		sec = "00";
	}
	timer.empty();
	timer.prepend($('<h2>' + min + ':' + sec + '</h2>'));
}

function exit() {
	r_discon.empty();
	if (my_or_not == true)
		r_discon.prepend($('<form method="POST" action="exit.php" id="l_a"><button value="Logout" type="submit" class="buttons" id="Abort_but">Abort</button></form>'));
	else
		r_discon.prepend($('<form method="POST" action="exit.php" id="l_a"><button value="Logout" type="submit" class="buttons" id="Abort_but">Disconnect</button></form>'));
}

//Новая игра

function new_or_not() {
	var lol = decodeURIComponent(location.search.substr(1)).split('&');
	aj("GET", "check.php", function (data) {
		if (data == "true")
			document.location.replace("lobbi.html?" + lol[0]);
		else
			setTimeout(new_or_not, 500);
	})
}

//Голосование

function vote_lol() {
	aj("GET", "start_vote.php", function (data) {
		var pol;
		console.log(data);
		data = jQuery.parseJSON(data);
		if (tr == false) {
			role.empty();
			name_loc.empty();
			mapp.empty();
			map3("pics/WHOIS.png");
			tr = true;
		}
		vote.empty();
		jQuery.each(data, function (i, val) {
			pol = val.split(';');
			vote.prepend($('<div class="player_tab before_tab" data-id="' + i + '">' + pol[1] + " - " + pol[0] + '</div>').click(vote_it));
		});
		if (check(data) == 1) {
			rt = true;
			new_or_not();
		}
	});
	if (rt == false)
		setTimeout(vote_lol, 100);
}

function vote_it() {
	if (confirm('Вы уверены?'))
		aj("GET", "put_vote.php?id=" + $(this).data('id'), vote_lol);
}

function check(data) {
	var i = 0;
	var sum = 0;
	var r_vote = -1;
	var max = 0;
	var count = 0
	var mes_val;
	var str;
	while (data[i]) {
		str = data[i];
		data[i] = str.split(';');
		str = data[i];
		mes_val = parseInt(str[0], 10);
		if (max == mes_val)
			count++;
		if (max < mes_val) {
			max = mes_val;
			r_vote = i;
			count = 1;
		}
		sum += mes_val;
		i++;
	}
	if (sum == i && count == 1) {
		role.empty();
		name_loc.empty();
		mapp.empty();
		timer.empty();
		vote.empty();
		if (data_g['roles'][r_vote] == 'Шпион') {
			map3("pics/TROLL.png");
			vote.prepend($('<h3> Вы выйграли!! Этого пиздюка поймали!</h3>'));
		}
		else {
			map3("pics/WHOIS.png");
			i = 0;
			while (data_g['roles'][i]) {
				if (data_g['roles'][i] == 'Шпион')
					break ;
				i++;
			}
			vote.prepend($('<h3> Шпионом был - ' + data_g[i] + '!!! Вы ЛОХИ!</h3>'));
		}
		if (my_or_not == true) {
			r_new.empty();
			r_new.prepend($('<form action="continue.php"><button value="Start" type="submit" class="buttons" id="Begin_but">NEXT</button></form>'));
		}
		return (1);
	}
	return (0);
}

/// Таймер

function take_new3() {
	var lul = new Date().getTime() / 1000;
	var tum;
	tum = data_g["t_finish"] - lul;
	if (data_g["t_finish"] <= lul) {
		vote_lol();
		update(tum);
	}
	else {
		update(tum);
		setTimeout(take_new3, 10);
	}
}

function take_new2() {
	var lul = new Date().getTime() / 1000;
	var tum;
	tum = data_g["t_start"] - lul;
	if (data_g["t_start"] <= lul) {
		map3(src_img);
		map1(r_role);
		if (r_loc)
			map2(r_loc);
		take_new3();
		exit();
	}
	else {
		update(tum);
		setTimeout(take_new2, 10);
	}
}

function take_new(data) {
	var i = 0;
	while (data[i]) {
		if (data[i]['game_id'] == game_id)
		{
			data_g = data[i];
			take_new2();
			return ;
		}
		i++;
	}
	console.log("ERROR");
	document.location.replace("main.html");
};

function load_info() {
	var lol = decodeURIComponent(location.search.substr(1)).split('&');
	var kent = lol[0].split('=');
	game_id = kent[1];
	aj("GET", "take_role.php", function (data) {
		console.log(data);
		data = jQuery.parseJSON(data);
		console.log(data);
		take_new(data);
	});
};

function my_game() {
	aj("GET", "functions/mda.php", function (data) {
		if (data == "true")
			my_or_not = true;
	})
}

function aj(method, url, status) {
	$.ajax({
		method: method,
		url: url,
	}).done(function (data) {
		status(data);
	});
};
