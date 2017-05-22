TYPE=TRIGGERS
triggers='CREATE OR REPLACE DEFINER=`root`@`%` TRIGGER new_user_trigger AFTER INSERT\nON mdh_users\nFOR EACH ROW\nBEGIN\n	INSERT INTO benutzer (joomla_user_id) values ( NEW.id);\nEND'
sql_modes=1342177280
definers='root@%'
client_cs_names='utf8'
connection_cl_names='utf8_general_ci'
db_cl_names='utf8_general_ci'
