CREATE TABLE Money_desira (
mid int primary key auto_increment, 
code varchar(50) unique not null, 
cid int not null, type char(1) not null, 
amount float not null, 
mydatetime datetime not null, 
note varchar(255),
sid int not null,
FOREIGN KEY (cid) references CPS3740.Customers(id),
FOREIGN KEY (sid) references CPS3740.Sources(id)
);


 select * from CPS3740_2021F.Money_desira;


insert into money_desira (id, code, cid, type, amount, mydatetime, sid, note) values 
 ('454','2','1','D','666','2021-10-11 18:54:30','1','rewrw333444'),
 ('455','2','1','D','321','2021-10-11 18:55:10','3','hello445555aaa'),
 ('462','1234','1','D','50','2021-11-10 22:27:47','1','qwqwew'),
 ('465','4545616581','1','D','100','2021-11-14 11:08:55','1','fdsfs'),
  ('466','123','4','D','100','2021-11-14 13:54:49','2',''),
   (),
    (),
     (),
      (),
       (),
        (),
         (),
          (),
           (),
            (),
             (),
              (),
               (),
                ();
