drop table tantargy;

create table tantargy(id int(5) primary key auto_increment,nev varchar(200),rovidites varchar(200));

select * from tantargy where nev like 'f%';
select count(*) from tantargy;