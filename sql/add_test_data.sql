-- USERS-taulun testidata
INSERT INTO USERS (username, password) VALUES ('Ville-Matti', 'Ville-Matti123');
-- TIME_AND_PLACE-taulun testidata
INSERT INTO TIME_AND_PLACE(dow, tp_date, start_time, end_time, location) VALUES ('ti', '2011-11-11', '12:00', '14:00', 'Exactum');
--CATEGORY-taulun testidata
INSERT INTO CATEGORY (id, category_name, supercategory) VALUES (1, '', NULL), (2, 'tsoha', 1), (3, 'tietokanta', 2), (4, 'matikka', 1)