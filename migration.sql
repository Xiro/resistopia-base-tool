# INSERT INTO cic_new.base_category (name) SELECT Name FROM resi_new.tbl_basecategory WHERE Name != 'keine';
# INSERT INTO cic_new.eye_color (name) SELECT Name FROM resi_new.tbl_eyecolor;
# INSERT INTO cic_new.rank (name, short_name) SELECT Name, Shortname FROM resi_new.tbl_rank;
# INSERT INTO cic_new.special_function (name, short_name) SELECT Name, Shortname FROM resi_new.tbl_specialcategory;