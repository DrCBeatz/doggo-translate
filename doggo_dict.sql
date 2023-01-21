CREATE TABLE doggo_dict (
    word_id INTEGER NOT NULL
    AUTO_INCREMENT PRIMARY KEY,
    dkey VARCHAR(128),
    dvalue VARCHAR(128)
) ENGINE=InnoDB CHARSET=utf8;

insert into doggo_dict (dkey, dvalue) values ('hello', 'henlo');
insert into doggo_dict (dkey, dvalue) values ('friend', 'fren');
insert into doggo_dict (dkey, dvalue) values ('dog', 'doggo');
insert into doggo_dict (dkey, dvalue) values ('bark', 'bork');
