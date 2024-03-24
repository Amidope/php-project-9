-- DROP TABLE IF EXISTS url_checks;

CREATE TABLE urls
(
    id         bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    name       varchar(255),
    created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(0) CHECK (created_at = current_timestamp(0))
);


CREATE TABLE url_checks
(
    id          bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    url_id      bigint REFERENCES urls (id),
    status_code int,
    h1          varchar(255),
    title       varchar(255),
    description varchar(255),
    created_at  TIMESTAMP NOT NULL DEFAULT current_timestamp(0) CHECK (created_at = current_timestamp(0))
);
