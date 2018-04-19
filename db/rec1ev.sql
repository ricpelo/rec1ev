DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
    id       bigserial    PRIMARY KEY
  , nombre   varchar(255) NOT NULL UNIQUE
  , password char(64)
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
