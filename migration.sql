INSERT INTO base_category (name) SELECT Name FROM resi_new.tbl_basecategory WHERE Name != 'keine';
INSERT INTO eye_color (name) SELECT Name FROM resi_new.tbl_eyecolor WHERE Name != 'n/a';
INSERT INTO mission_status (name) SELECT Name FROM resi_new.tbl_missionstatus;
INSERT INTO rank (name, short_name) SELECT Name, Shortname FROM resi_new.tbl_rank;
INSERT INTO special_function (name, short_name) SELECT Name, Shortname FROM resi_new.tbl_specialcategory Name != 'keine';
INSERT INTO mission_status (name) SELECT Name FROM resi_new.tbl_missionstatus;