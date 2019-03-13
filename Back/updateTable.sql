ALTER TABLE usuario
ADD email VARCHAR(50) NULL UNIQUE

alter table usuario
add isNotificationEmail bit default 1


alter table usuario
add isNotificationModal bit default 1

alter table usuario
add timeNotificationEmail Int default 7

alter table usuario
add timeNotificationModal Int default 7
