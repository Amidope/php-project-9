DROP TABLE IF EXISTS url_checks;
DROP TABLE IF EXISTS urls;


CREATE TABLE urls
(
    id         bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    name       varchar(255) NOT NULL,
    created_at TIMESTAMP NOT NULL
);


CREATE TABLE url_checks
(
    id          bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    url_id      bigint REFERENCES urls (id),
    status_code int NOT NULL,
    h1          varchar(1000) NOT NULL,
    title       text NOT NULL,
    description text,
    created_at  TIMESTAMP NOT NULL
);
