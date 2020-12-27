# bizmates-weather

![bizmates](https://user-images.githubusercontent.com/40732088/103063674-00ec8b80-45ed-11eb-96f8-71049063d9e0.png)

 bizmates exam
 
 coded by Reeve Callejo
 
 frameworks:
 
 laravel
 
 vuejs
 
 api:
 
  https://api.openweathermap.org
  
  https://api.foursquare.com/

steps: 

1.)copy .env.example .env or cp .env.example .env

2.)composer install

3.) npm install

4.)php artisan key:generate

5.)php artisan serve


 Application was designed to view time,weather status and popular places according to selected city/country


MYSQL EXAM:

PART ONE: 

1.)SELECT CONCAT('T',LPAD(REPLACE(trn_teacher.id, ',', ''), 11, '0'))  as ID,nickname as Nickname,trn_teacher.status as status,
GROUP_CONCAT(case when trn_teacher_role.role= 1 then 'trainor' when trn_teacher_role.role= 2 then 'assessor' when trn_teacher_role.role= 3 then 'staff' end) as Roles
FROM trn_teacher
INNER JOIN trn_teacher_role ON trn_teacher_role.teacher_id = trn_teacher.id
group by trn_teacher.id

![image](https://user-images.githubusercontent.com/40732088/103162502-5ebae680-482c-11eb-9494-8af51b6b1107.png)

PART TWO:

select REPLACE(d.ID, ',', '') as ID,d.Nickname,sum(d.Open) as Open,sum(d.Reserved) as Reserved,sum(d.Taught) as Taught,sum(d.NoShow) as "No Show" from( SELECT trn_teacher.id as ID,trn_teacher.nickname as Nickname, count(case when trn_time_table.status= "1" then 1 end ) as Open,count(case when trn_time_table.status= 3 then 1 end) as Reserved,0 as Taught,0 as "NoShow" FROM trn_teacher JOIN trn_time_table ON trn_teacher.id = trn_time_table.teacher_id where trn_teacher.status = 1 GROUP by ID,Nickname UNION SELECT trn_teacher.id as ID,trn_teacher.nickname as Nickname,0 as Open,0 as Reserved, count(case when trn_evaluation.result= "1" then 1 end ) as Taught,count(case when trn_evaluation.result= 2 then 1 end) as "NoShow" FROM trn_teacher JOIN trn_evaluation ON trn_teacher.id = trn_evaluation.teacher_id where trn_teacher.status = 1 GROUP by ID,Nickname ) d group by 1,2 order by 1,2

![image](https://user-images.githubusercontent.com/40732088/103162512-84e08680-482c-11eb-8172-9c3552773249.png)

