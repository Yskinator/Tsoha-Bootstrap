CREATE TABLE CATEGORY(
    id SERIAL PRIMARY KEY,
    name varchar(200) NOT NULL,
    supercategory INTEGER REFERENCES CATEGORY(id)
);

CREATE TABLE USERS(
    id SERIAL PRIMARY KEY,
    username varchar(40) NOT NULL,
    password varchar(40) NOT NULL,
    list_root INTEGER REFERENCES CATEGORY(id)
);

CREATE TABLE NOTE(
    id SERIAL PRIMARY KEY,
    note varchar(200) NOT NULL,
    supercategory INTEGER REFERENCES CATEGORY(id)
);

CREATE TABLE TIME_AND_PLACE(
    id SERIAL PRIMARY KEY,
    dow varchar(2),
    tp_date DATE,
    start_time TIME,
    end_time TIME,
    location varchar(200),
    supercategory INTEGER REFERENCES CATEGORY(id)
);