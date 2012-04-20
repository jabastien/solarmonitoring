-- ----------------------------
--  setup default site for app
-- ----------------------------


INSERT INTO `site` (public_id, name, description, mate_url, timezone, timezone_short, status, default_site, site_admin_email) VALUES 
 ('MYPUBID', 'MYSCHOOLNAME ', 'My School Desc', 'http://mymateip.com/Dev_status.cgi?&Port=0', 'US/Eastern', 'EST' '1', '1', 'email@email.com');

-- ----------------------------
--  setup devices (ports) for charge controllers
-- ----------------------------
-- often site_id will be '1' for a first site.  but grab the site_id if using multiple sites 

INSERT INTO `device` (site_id, name, description, device_code, system_port, status) VALUES ('1', 'FlexMax ', 'Charge Controller (1st string)', 'CC', '1', '1');






