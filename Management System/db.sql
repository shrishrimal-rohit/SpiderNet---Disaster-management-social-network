
drop database if exists cmpe281proj;
create database cmpe281proj;
use cmpe281proj;

CREATE TABLE user  (user_id INTEGER NOT NULL, 
						username CHAR(20) NOT NULL,
                        fname CHAR(20) NULL,
                        lname CHAR(20) NULL,
                        email CHAR(30) NULL,
                        password CHAR(20) NOT NULL,
                        bdd INTEGER NULL,
                        bdm INTEGER NULL,
                        bdy INTEGER NULL,
                        instance_id CHAR(4) NOT NULL,
                        enter_date DATE NULL);
                        
CREATE TABLE instance (instance_id INTEGER NOT NULL,
                        instance_name CHAR(25) NOT NULL,
                        admin_id INTEGER NOT NULL,
                        num_user INTEGER NOT NULL,
                        dns CHAR(20) NULL,
                        ip CHAR(20)  NULL);

CREATE TABLE rule	(instance_idA INTEGER NOT NULL,
						instance_idB INTEGER NOT NULL,
                        auth CHAR(20) NOT NULL);
          
CREATE TABLE activity (user_id INTEGER NOT NULL,
										instance_id INTEGER NOT NULL,
                                        date CHAR(20) NULL);
                                        
insert into instance values(1, 'sanJosePoliceDepartment', 1, 7, null, null);
insert into instance values(2, 'sanJoseStateUniversity', 2, 4, null, null);
insert into instance values(3, 'sanJoseHospital', 3, 5, null, null);
insert into user values(1,'jason','jason','su',null,'123',null,null,null,1,null);
insert into user values(2,'hunter','hunter','su',null,'123',null,null,null,2,null);
insert into user values(3,'jack','jack','hu',null,'123',null,null,null,3,null);
insert into user values(4,'honda','honda','liu',null,'123',null,null,null,3,null);
insert into user values(5,'annie','annie','li',null,'123',null,null,null,2,null);
insert into user values(6,'bob','bob','sun',null,'123',null,null,null,1,null);
insert into user values(7,'cathy','crystal','liu',null,'123',null,null,null,1,null);
insert into user values(8,'david','david','zhang',null,'123',null,null,null,2,null);
insert into user values(9,'edison','edison','chang',null,'123',null,null,null,1,null);
insert into user values(10,'ef','effy','zhu',null,'123',null,null,null,3,null);
insert into user values(12,'gar','gary','gao',null,'123',null,null,null,1,null);
insert into user values(13,'har','harry','huo',null,'123',null,null,null,2,null);
insert into user values(14,'jac','jackson','huang',null,'123',null,null,null,1,null);
insert into user values(15,'kat','kathy','cao',null,'123',null,null,null,3,null);
insert into user values(16,'luc','lucas','he',null,'123',null,null,null,1,null);
insert into user values(17,'man','mandy','gao',null,'123',null,null,null,3,null);
insert into rule values(1, 2,'yes');
insert into rule values(1, 3,'yes');
insert into rule values(3, 2,'no');
insert into activity values(2,2,null);
insert into activity values(1,1,null);
insert into activity values(3,3,null);
insert into activity values(4,3,null);
insert into activity values(5,2,null);
insert into activity values(8,2,null);
insert into activity values(13,2,null);
insert into activity values(14,1,null);
insert into activity values(15,3,null);
insert into activity values(16,1,null);
insert into activity values(17,3,null);
insert into activity values(9,1,null);
insert into activity values(10,1,null);
