DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
    id       bigserial    PRIMARY KEY
  , numero   varchar(255) NOT NULL UNIQUE
  , nombre   varchar(255)
  , password varchar(64)
);

DROP TABLE IF EXISTS citas CASCADE;

CREATE TABLE citas
(
    id         bigserial PRIMARY KEY
  , fecha      date      NOT NULL
  , hora       time      NOT NULL
  , usuario_id bigint    NOT NULL REFERENCES usuarios (id)
                         ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO usuarios (numero, nombre, password)
VALUES ('123', 'Pepe', crypt('123', gen_salt('bf', 12)));
