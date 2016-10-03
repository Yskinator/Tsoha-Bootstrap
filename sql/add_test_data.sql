-- TIME_AND_PLACE-taulun testidata
INSERT INTO TIME_AND_PLACE(dow, tp_date, start_time, end_time, location) VALUES ('ti', '2011-11-11', '12:00', '14:00', 'Exactum');
--CATEGORY-taulun testidata
INSERT INTO CATEGORY (name, supercategory) VALUES ('root', NULL), ('tsoha', 1), ('tietokanta', 2), ('matikka', 1);
-- USERS-taulun testidata
INSERT INTO USERS (username, password, list_root) VALUES ('Ville-Matti', 'Ville-Matti123', 1);