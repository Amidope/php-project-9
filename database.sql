DROP TABLE IF EXISTS urls;

CREATE TABLE urls (
    id bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    name varchar(255),
    created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(0) CHECK (created_at = current_timestamp(0))
);
