<?php
$connect=mysql_connect("localhost","u2013147555","2013147555");
$mysql=mysql_select_db("d2013147555",$connect);

$query="CREATE TABLE IF NOT EXISTS member (
member_no int(11) auto_increment primary key NOT NULL,
member_id varchar(64) NOT NULL,
nickname varchar(128),
score int(11) default '0',
numof_writing int(11) default '0',
numof_comment int(11) default '0',
numof_rcmd int(11) default '0',
visite int(11) default '1',
last_login datetime NOT NULL,
first_login datetime NOT NULL
);";

$res=mysql_query($query,$connect);
if($res){
	echo "ok\n";
}
if(!$res){
	echo "fail\n";
}

$query= "CREATE TABLE IF NOT EXISTS building (
building_no int(11) auto_increment primary key NOT NULL,
building_name varchar(128),
latitude double(20,16),
longitude double(20,16),
numof_toilet int(11) default '0'
);";

$res=mysql_query($query,$connect);
if($res){
	echo "ok\n";
}
if(!$res){
	echo "fail\n";
}

$query= "CREATE TABLE IF NOT EXISTS toilet (
toilet_no int(11) auto_increment primary key NOT NULL,
building_no int(11) NOT NULL,
toilet_name varchar(128),
rating int(11) default '0',
numof_review int(11) default '0',
foreign key (building_no) references building(building_no) on delete cascade
);";

$res=mysql_query($query,$connect);
if($res){
	echo "ok\n";
}
if(!$res){
	echo "fail\n";
}

$query="CREATE TABLE IF NOT EXISTS review (
review_no int(11) auto_increment primary key NOT NULL,
toilet_no int(11) NOT NULL,
member_no int(11) NOT NULL,
wdate datetime NOT NULL,
content text,
rcmd int(11) NOT NULL default '0',
numof_comment int(11) NOT NULL default '0',
rating int(11) NOT NULL,
image varchar(256),
thumb varchar(256),
foreign key (toilet_no) references toilet(toilet_no) on delete cascade,
foreign key (member_no) references member(member_no) on delete cascade
);";

$res=mysql_query($query,$connect);
if($res){
	echo "ok\n";
}
if(!$res){
	echo "fail\n";
}

$query="CREATE TABLE IF NOT EXISTS comment (
comment_no int(11) auto_increment primary key NOT NULL,
review_no int(11) NOT NULL,
member_no int(11) NOT NULL,
content text,
wdate datetime NOT NULL,
foreign key (review_no) references review(review_no) on delete cascade,
foreign key (member_no) references member(member_no) on delete cascade
);";

$res=mysql_query($query,$connect);
if($res){
	echo "ok\n";
}
if(!$res){
	echo "fail\n";
}

$query="CREATE TABLE IF NOT EXISTS recommend (
recommend_no int(11) auto_increment primary key NOT NULL,
review_no int(11) NOT NULL,
member_no int(11) NOT NULL,
to_mem_no int(11) NOT NULL,
foreign key (review_no) references review(review_no) on delete cascade,
foreign key (member_no) references member(member_no) on delete cascade
);";
$res=mysql_query($query,$connect);
if($res){
	echo "ok\n";
}
if(!$res){
	echo "fail\n";
}
?>