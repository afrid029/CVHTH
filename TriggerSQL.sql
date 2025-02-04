-----------Log table creation----------

CREATE TABLE `activitylog` (
  `action` varchar(2) NOT NULL,
  `actionby` varchar(100) NOT NULL,
  `impact` varchar(100) NOT NULL,
  `value` varchar(50) DEFAULT NULL,
  `old` varchar(50) DEFAULT NULL,
  `new` varchar(50) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp()
)


------------Alter Table----------------------
ALTER TABLE beneficiant ADD COLUMN updatedby varchar(100);
ALTER TABLE users ADD COLUMN updatedby varchar(100);
ALTER TABLE project ADD COLUMN updatedby varchar(100);
ALTER TABLE donationsent ADD COLUMN updatedby varchar(100);
ALTER TABLE donationreceived ADD COLUMN updatedby varchar(100);
ALTER TABLE donationevidence ADD COLUMN updatedby varchar(100);
ALTER TABLE beneficiantimages ADD COLUMN updatedby varchar(100);




-------------------------- TRIGGERS--------------------------------

DELIMITER $$
 
CREATE TRIGGER after_user_insert
AFTER INSERT
ON users
FOR EACH ROW
BEGIN
  INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.firstname, '-', NEW.role), 'ID', NEW.ID);
  
  INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.firstname, '-', NEW.role), 'first Name', NEW.firstname);
  
  INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.firstname, '-', NEW.role), 'Last Name', NEW.lastname);
  
  INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.firstname, '-', NEW.role), 'Email', NEW.email);
  
   INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.firstname, '-', NEW.role), 'Role', NEW.role);
  
   INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.firstname, '-', NEW.role), 'Contact No', NEW.contactno);
  
   INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.firstname, '-', NEW.role), 'Password', 'Password Generated');
  
   INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.firstname, '-', NEW.role), 'Email', NEW.email);
  
   IF NEW.dob IS NOT NULL THEN
     INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.firstname, '-', NEW.role), 'DOB', NEW.dob);
  END IF;
  
  
END$$

DELIMITER ;


----------------After USER UPDATE

DELIMITER $$

CREATE TRIGGER after_user_update
AFTER UPDATE
ON users
FOR EACH ROW
BEGIN

    -- First Name change
    IF OLD.firstname != NEW.firstname THEN
        INSERT INTO activitylog (action, actionby, impact, `value`, `old`, `new`)
        VALUES ('U', NEW.updatedby, CONCAT(NEW.firstname, '-', NEW.role), 'First Name', OLD.firstname, NEW.firstname);
    END IF;

    -- Last Name change
    IF OLD.lastname != NEW.lastname THEN
        INSERT INTO activitylog (action, actionby, impact, `value`, `old`, `new`)
        VALUES ('U', NEW.updatedby, CONCAT(NEW.firstname, '-', NEW.role), 'Last Name', OLD.lastname, NEW.lastname);
    END IF;

    -- Email change
    IF OLD.email != NEW.email THEN
        INSERT INTO activitylog (action, actionby, impact, `value`, `old`, `new`)
        VALUES ('U', NEW.updatedby, CONCAT(NEW.firstname, '-', NEW.role), 'Email', OLD.email, NEW.email);
    END IF;

    -- Role change
    IF OLD.role != NEW.role THEN
        INSERT INTO activitylog (action, actionby, impact, `value`, `old`, `new`)
        VALUES ('U', NEW.updatedby, CONCAT(NEW.firstname, '-', NEW.role), 'Role', OLD.role, NEW.role);
    END IF;

    -- Contact Number change
    IF OLD.contactno != NEW.contactno THEN
        INSERT INTO activitylog (action, actionby, impact, `value`, `old`, `new`)
        VALUES ('U', NEW.updatedby, CONCAT(NEW.firstname, '-', NEW.role), 'Contact Number', OLD.contactno, NEW.contactno);
    END IF;

    -- Password change (Be cautious with password handling)
    IF OLD.password != NEW.password THEN
        INSERT INTO activitylog (action, actionby, impact, `value`, `old`, `new`)
        VALUES ('U', NEW.firstname, CONCAT(NEW.firstname, '-', NEW.role), 'Password', 'Old password removed', 'New password updated');
    END IF;

    -- DOB change (null-safe comparison)
    
IF (OLD.dob IS NULL AND NEW.dob IS NOT NULL) OR (OLD.dob IS NOT NULL AND NEW.dob IS NULL) OR OLD.dob <> NEW.dob THEN


        INSERT INTO activitylog (action, actionby, impact, `value`, `old`, `new`)
        VALUES ('U', NEW.updatedby, CONCAT(NEW.firstname, '-', NEW.role), 'DOB', OLD.dob, NEW.dob);
        
END IF;

    -- Temp password change (null-safe comparison)

IF (OLD.temp_password IS NULL AND NEW.temp_password IS NOT NULL) OR (OLD.temp_password IS NOT NULL AND NEW.temp_password IS NULL) OR OLD.temp_password <> NEW.temp_password THEN
  INSERT INTO activitylog (action, actionby, impact, `value`, `old`, `new`)
        VALUES ('U', 'Anonymous/User', CONCAT(NEW.firstname, '-', NEW.role), 'Temp Password', 'Temp Password Generated', 'Temp Password Generated');
        
END IF;

END$$

DELIMITER ;


-------------Project Insert------------

DELIMITER $$
 
CREATE TRIGGER after_project_insert
AFTER INSERT
ON project
FOR EACH ROW
BEGIN
  INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.name,'-Project'), 'ID', NEW.ID);
  
  INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.name,'-Project'), 'Project name', NEW.name);
  
  INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.name,'-Project'), 'Description', NEW.description);
  
END$$

DELIMITER ;

-----Project Update---------
DELIMITER $$

CREATE TRIGGER after_project_update
AFTER UPDATE
ON project
FOR EACH ROW
BEGIN

 
    IF OLD.name != NEW.name THEN
        INSERT INTO activitylog (action, actionby, impact, `value`, `old`, `new`)
        VALUES ('U', NEW.updatedby, CONCAT(OLD.name,'-Project'), 'Project name', OLD.name, NEW.name);
    END IF;
    
    
    IF OLD.description != NEW.description THEN
        INSERT INTO activitylog (action, actionby, impact, `value`, `old`, `new`)
        VALUES ('U', NEW.updatedby, CONCAT(OLD.name,'-Project'),'Description', OLD.description, NEW.description);
    END IF;

END$$

DELIMITER ;


-------------INSERT Disbursed donation-----------
DELIMITER $$
 
CREATE TRIGGER after_donationsent_insert
AFTER INSERT
ON donationsent
FOR EACH ROW
BEGIN
	
    DECLARE donor VARCHAR(50);
    DECLARE proj VARCHAR(50);
    DECLARE bene VARCHAR(50);
    
    SELECT firstname INTO donor from users where ID = NEW.Donor_ID; 
    SELECT name INTO proj FROM project where ID = NEW.Project_ID;
    SELECT firstName INTO bene FROM beneficiant WHERE ID = NEW.Beneficiant_ID;

  INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT('Distri.Don ', NEW.ID), 'ID', NEW.ID);
  
  INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT('Distri.Don ', NEW.ID), 'Donor', donor);
  
    INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT('Distri.Don ', NEW.ID), 'Date', NEW.date);
  
    INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT('Distri.Don ', NEW.ID), 'Amount', NEW.amount);
  
    INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT('Distri.Don ', NEW.ID), 'Purpose', NEW.purpose);
  
    INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT('Distri.Don ', NEW.ID), 'Project', proj);
  
    INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT('Distri.Don ', NEW.ID), 'Beneficiary', bene);
  
END$$

DELIMITER ;



-------------------Update Disbursed Donation---------------


  DELIMITER $$
 
CREATE TRIGGER after_donationsent_update
AFTER UPDATE
ON donationsent
FOR EACH ROW
BEGIN
	
    DECLARE olddonor VARCHAR(50);
    DECLARE newdonor VARCHAR(50);
    DECLARE oldproject VARCHAR(50);
    DECLARE newproject VARCHAR(50);
    DECLARE oldbene VARCHAR(50);
    DECLARE newbene VARCHAR(50);
    
    IF OLD.Donor_ID != NEW.Donor_ID THEN
        SELECT firstname INTO olddonor from users where ID = OLD.Donor_ID;
        SELECT firstname INTO newdonor from users where ID = NEW.Donor_ID;
         INSERT INTO activitylog (action, actionby, impact, `value`, `old`, `new`)
  VALUES ('U', NEW.updatedby, CONCAT('Distri.Don ', NEW.ID), 'Donor', olddonor, newdonor);
    
    END IF;
    
    IF OLD.date != NEW.date THEN
    	 INSERT INTO activitylog (action, actionby, impact, `value`, `old`, `new`)
  VALUES ('U', NEW.updatedby, CONCAT('Distri.Don ', NEW.ID), 'Date', OLD.date, NEW.date);
    END IF;
    
    IF OLD.amount != NEW.amount THEN
    	 INSERT INTO activitylog (action, actionby, impact, `value`, `old`, `new`)
  VALUES ('U', NEW.updatedby, CONCAT('Distri.Don ', NEW.ID), 'Amount', OLD.amount, NEW.amount);
    END IF;
    
    IF OLD.purpose != NEW.purpose THEN
    	 INSERT INTO activitylog (action, actionby, impact, `value`, `old`, `new`)
  VALUES ('U', NEW.updatedby, CONCAT('Distri.Don ', NEW.ID), 'Purpose', OLD.purpose, NEW.purpose);
    END IF;
    
      IF OLD.Project_ID != NEW.Project_ID THEN
        SELECT name INTO oldproject from project where ID = OLD.Project_ID;
        SELECT name INTO newproject from project where ID = NEW.Project_ID;
         INSERT INTO activitylog (action, actionby, impact, `value`, `old`, `new`)
  VALUES ('U', NEW.updatedby, CONCAT('Distri.Don ', NEW.ID), 'Project', oldproject, newproject);
    
    END IF;
    
    IF OLD.Beneficiant_ID != NEW.Beneficiant_ID THEN
        SELECT firstName INTO oldbene from beneficiant where ID = OLD.Beneficiant_ID;
        SELECT firstName INTO newbene from beneficiant where ID = NEW.Beneficiant_ID;
         INSERT INTO activitylog (action, actionby, impact, `value`, `old`, `new`)
  VALUES ('U', NEW.updatedby, CONCAT('Distri.Don ', NEW.ID), 'Beneficiant', oldbene, newbene);
    
    END IF;

  
END$$

DELIMITER ;


--------------Insert Received donation ----------------
DELIMITER $$
 
CREATE TRIGGER after_donationreceived_insert
AFTER INSERT
ON donationreceived
FOR EACH ROW
BEGIN
	
    DECLARE donor VARCHAR(50);
    
    SELECT firstname INTO donor from users where ID = NEW.Donor_ID;

  INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT('Received.Don ', NEW.ID), 'ID', NEW.ID);
  
   INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT('Received.Don ', NEW.ID), 'Donor', donor);
  
    INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT('Received.Don ', NEW.ID), 'Date', NEW.date);
  
    INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT('Received.Don ', NEW.ID), 'Amount', NEW.amount);
  
  
END$$

DELIMITER ;


---------Update received Donation trigger------------
DELIMITER $$
 
CREATE TRIGGER after_donationreceived_update
AFTER Update
ON donationreceived
FOR EACH ROW
BEGIN
	
    DECLARE olddonor VARCHAR(50);
    DECLARE newdonor VARCHAR(50);
    
    IF OLD.Donor_ID != NEW.Donor_ID THEN
        SELECT firstname INTO olddonor from users where ID = OLD.Donor_ID;
        SELECT firstname INTO newdonor from users where ID = NEW.Donor_ID;
         INSERT INTO activitylog (action, actionby, impact, `value`, `old`, `new`)
  VALUES ('U', NEW.updatedby, CONCAT('Received.Don ', NEW.ID), 'Donor', olddonor, newdonor);
    
    END IF;
    
    
    IF OLD.date != NEW.date THEN
    	 INSERT INTO activitylog (action, actionby, impact, `value`, `old`, `new`)
  VALUES ('U', NEW.updatedby, CONCAT('Received.Don ', NEW.ID), 'Date', OLD.date, NEW.date);
    END IF;
    
    IF OLD.amount != NEW.amount THEN
    	 INSERT INTO activitylog (action, actionby, impact, `value`, `old`, `new`)
  VALUES ('U', NEW.updatedby, CONCAT('Received.Don ', NEW.ID), 'Amount', OLD.amount, NEW.amount);
    END IF;
    
    
  
END$$

DELIMITER ;

--------Donation Evidence Insert-------
DELIMITER $$
 
CREATE TRIGGER after_donationevidence_insert
AFTER INSERT
ON donationevidence
FOR EACH ROW
BEGIN

  INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT('D.DonationEvidence ', NEW.DS_ID), 'Image', NEW.image);
  
  
END$$

DELIMITER ;

-----Beneficiary Insert-------
DELIMITER $$
 
CREATE TRIGGER after_beneficiant_insert
AFTER INSERT
ON beneficiant
FOR EACH ROW
BEGIN

  INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.firstName,'-Beneficiary'), 'ID', NEW.ID);
  
    INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.firstName,'-Beneficiary'), 'First Name', NEW.firstName);
  
    INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.firstName,'-Beneficiary'), 'Last Name', NEW.lastName);
  
    INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.firstName,'-Beneficiary'), 'NIC', NEW.NIC);
  
    INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.firstName,'-Beneficiary'), 'Gender', NEW.sex);
  
    INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.firstName,'-Beneficiary'), 'DOB', NEW.dob);
  
    INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.firstName,'-Beneficiary'), 'Address', NEW.address);
  
    INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(NEW.firstName,'-Beneficiary'), 'GS', NEW.gsDivision);
  
   IF NEW.school IS NOT NULL THEN
   		INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  		VALUES ('I', NEW.updatedby, CONCAT(NEW.firstName,'-Beneficiary'), 'School', NEW.school);
   END IF;
   
     IF NEW.grade IS NOT NULL THEN
   		INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  		VALUES ('I', NEW.updatedby, CONCAT(NEW.firstName,'-Beneficiary'), 'Education Status', NEW.grade);
   END IF;
  
  
END$$

DELIMITER ;

------------------Beneficary Update ------------------------

DELIMITER $$
 
CREATE TRIGGER after_beneficiant_update
AFTER UPDATE
ON beneficiant
FOR EACH ROW
BEGIN

   IF OLD.firstName <> NEW.firstName THEN
   	 INSERT INTO activitylog (action, actionby, impact, `value`,`old`, `new`)
  VALUES ('U', NEW.updatedby, CONCAT(NEW.firstName,'-Beneficiary'), 'First Name',OLD.firstName, NEW.firstName);
   END IF;
   
   IF OLD.lastName <> NEW.lastName THEN
   	 INSERT INTO activitylog (action, actionby, impact, `value`,`old`, `new`)
  VALUES ('U', NEW.updatedby, CONCAT(NEW.firstName,'-Beneficiary'), 'Last Name',OLD.lastName, NEW.lastName);
   END IF;

   IF OLD.nic <> NEW.nic THEN
   	 INSERT INTO activitylog (action, actionby, impact, `value`,`old`, `new`)
  VALUES ('U', NEW.updatedby, CONCAT(NEW.firstName,'-Beneficiary'), 'NIC',OLD.nic, NEW.nic);
   END IF;
   
   IF OLD.sex <> NEW.sex THEN
   	 INSERT INTO activitylog (action, actionby, impact, `value`,`old`, `new`)
  VALUES ('U', NEW.updatedby, CONCAT(NEW.firstName,'-Beneficiary'), 'Gender',OLD.sex, NEW.sex);
   END IF;
   
   IF OLD.dob <> NEW.dob THEN
   	 INSERT INTO activitylog (action, actionby, impact, `value`,`old`, `new`)
  VALUES ('U', NEW.updatedby, CONCAT(NEW.firstName,'-Beneficiary'), 'DOB',OLD.dob, NEW.dob);
   END IF;
   
   IF OLD.address <> NEW.address THEN
   	 INSERT INTO activitylog (action, actionby, impact, `value`,`old`, `new`)
  VALUES ('U', NEW.updatedby, CONCAT(NEW.firstName,'-Beneficiary'), 'Address',OLD.address, NEW.address);
   END IF;
   
   IF OLD.gsDivision <> NEW.gsDivision THEN
   	 INSERT INTO activitylog (action, actionby, impact, `value`,`old`, `new`)
  VALUES ('U', NEW.updatedby, CONCAT(NEW.firstName,'-Beneficiary'), 'GS',OLD.gsDivision, NEW.gsDivision);
   END IF;
   
   IF (OLD.school IS NOT NULL AND NEW.school IS NULL) OR (OLD.school IS NULL AND NEW.school IS NOT NULL) OR (OLD.school <> NEW.school) THEN
   	 INSERT INTO activitylog (action, actionby, impact, `value`,`old`, `new`)
  VALUES ('U', NEW.updatedby, CONCAT(NEW.firstName,'-Beneficiary'), 'School',OLD.school, NEW.school);
   END IF;
   
    IF (OLD.grade IS NOT NULL AND NEW.grade IS NULL) OR (OLD.grade IS NULL AND NEW.grade IS NOT NULL) OR (OLD.grade <> NEW.grade) THEN
   	 INSERT INTO activitylog (action, actionby, impact, `value`,`old`, `new`)
  VALUES ('U', NEW.updatedby, CONCAT(NEW.firstName,'-Beneficiary'), 'Education Status',OLD.grade, NEW.grade);
   END IF;
     
END$$

DELIMITER ;


-------------Beneficiary Image Insert----------------

DELIMITER $$
 
CREATE TRIGGER after_beneficiantImage_insert
AFTER INSERT
ON beneficiantimages
FOR EACH ROW
BEGIN

	DECLARE name varchar(50);
    
    SELECT firstName INTO name from beneficiant WHERE ID = NEW.Beneficiant_ID;

  INSERT INTO activitylog (action, actionby, impact, `value`, `new`)
  VALUES ('I', NEW.updatedby, CONCAT(name,'-BeneficiaryImage'), 'Image', NEW.image);
  
  
END$$

DELIMITER ;